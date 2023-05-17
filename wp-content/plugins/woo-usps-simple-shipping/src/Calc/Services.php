<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */
declare(strict_types=1);
namespace Dgm\UspsSimple\Calc;


class Services
{
    public const RETAIL_GROUND_CODE = '4';

    /**
     * @var bool
     * @psalm-readonly
     */
    public $retailGroundEnabled;

    /**
     * @param callable(string $familyId, string $title): string  $getFamilyTitle
     * @param callable(string $familyId, string $serviceId): bool  $isServiceEnabled
     */
    public function __construct(callable $getFamilyTitle, callable $isServiceEnabled)
    {
        $_fams = include(__DIR__.'/../../data-domestic-services-usps.php');
        if (!$_fams) {
            throw new \RuntimeException("failed to load services data");
        }

        $famSort = 0;
        foreach ($_fams as $_famid => $_fam) {
            $_famid = strtolower($_famid);
            $fam = new ServiceFamily($_famid, $getFamilyTitle($_famid, $_fam['name']), $famSort++);
            foreach ($_fam['services'] as $_sid => $_service) {
                $_sid = (string)$_sid;
                if (!$isServiceEnabled($_famid, $_sid)) {
                    continue;
                }
                $realUspsCode = $_sid[0] === '0' ? '0' : $_sid;
                $this->serviceMatchersByCode[$realUspsCode][] = self::makeServiceMatcher($_sid, $fam);
            }
        }

        $this->retailGroundEnabled = !empty($this->serviceMatchersByCode[self::RETAIL_GROUND_CODE]);
    }

    public function find(string $uspsCode, string $uspsTitle): ?Service
    {
        $matchers = $this->serviceMatchersByCode[$uspsCode] ?? [];
        foreach ($matchers as $m) {
            if ($s = $m($uspsTitle)) {
                return $s;
            }
        }

        return null;
    }

    public function empty(): bool
    {
        return empty($this->serviceMatchersByCode);
    }

    private $serviceMatchersByCode = [];

    private static function makeServiceMatcher(string $synthCode, ServiceFamily $family): callable
    {
        $sizes = Fitters::$i;

        $m = [
            '0A' => [$sizes->POSTCARD, 'Postcards'],
            '12' => [$sizes->POSTCARD],
            '15' => [$sizes->POSTCARD],

            '0B' => [$sizes->LETTER, 'Letter'],
            '78' => [$sizes->LETTER],

            '0C' => [$sizes->LARGE_ENVELOPE, 'Large Envelope'],

            '0D' => [$sizes->PARCEL, 'Parcel'],
            '0E' => [$sizes->PARCEL, '/Package Service(.*)Retail/'],
            '61' => [$sizes->PARCEL],
            '53' => [$sizes->PARCEL],
        ];

        $size = $m[$synthCode][0] ?? null;
        $service = self::makeService($synthCode, $family, $size);
        $title = $m[$synthCode][1] ?? null;

        if (!isset($title)) {
            return new MatchAny($service);
        }
        if ($title[0] === '/') {
            return new MatchRegex($service, $title);
        }
        return new MatchSubstr($service, $title);
    }

    private static function makeService(string $synthCode, ServiceFamily $family, ?FitFn $fitFn): Service
    {
        // Media Mail and Library Mail are considered commercial services by USPS. Effective January 22, 2023,
        // commercial services return a commercial rate instead (the retail rate turned into 0.00). We should
        // switch to the commercial price irregardles of other settings to maintain the status quo.
        // https://www.usps.com/business/web-tools-apis/2023-web-tools-release-notes.pdf (page 4)
        //
        // Updated 6.02.2023: but actually, Media Mail returns <Rate> instead of <CommercialRate> sometimes.
        // So, we use the lowest of both rates even if the commercial rates option is disabled.
        $alwaysUseCommercialRate = $synthCode === '6' || $synthCode === '7';

        return new Service($family, $fitFn, $alwaysUseCommercialRate);
    }
}

class ServiceFamily
{
    /**
     * @var string
     * @psalm-readonly
     */
    public $id;

    /**
     * @var string
     * @psalm-readonly
     */
    public $title;

    /**
     * @var int
     * @psalm-readonly
     */
    public $sort;


    public function __construct(string $id, string $title, int $sort)
    {
        $this->id = $id;
        $this->title = $title;
        $this->sort = $sort;
    }
}

class Service
{
    /**
     * @var ServiceFamily
     * @psalm-readonly
     */
    public $family;

    /**
     * @var bool
     * @psalm-readonly
     */
    public $alwaysUseCommercialRate;


    public function __construct(ServiceFamily $family, FitFn $fitFn = null, bool $alwaysUseCommercialRate = false)
    {
        $this->family = $family;
        $this->fitFn = $fitFn;
        $this->alwaysUseCommercialRate = $alwaysUseCommercialRate;
    }

    public function fits(Dim $dim): bool
    {
        return !isset($this->fitFn) || ($this->fitFn)($dim);
    }

    private $fitFn;
}


// serializing closures requires a heavy lib
interface FitFn
{
    function __invoke(Dim $pkg): bool;
}


class FitMinMax implements FitFn
{
    public function __construct(Dim $min, Dim $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function __invoke(Dim $pkg): bool
    {
        return $this->max->fits($pkg) && $pkg->fits($this->min);
    }

    private $min;
    private $max;
}

class FitGirthLen implements FitFn
{
    /**
     * @param int|float $max
     */
    public function __construct($max)
    {
        $this->max = $max;
    }

    public function __invoke(Dim $pkg): bool
    {
        return $pkg->girth() + $pkg->length <= $this->max;
    }

    private $max;
}


class Fitters
{
    /** @var self */
    public static $i;

    public $POSTCARD;
    public $LETTER;
    public $LARGE_ENVELOPE;
    public $PARCEL;

    public function __construct()
    {
        $this->POSTCARD = new FitMinMax(Dim::of(5, 3.5, 0.007), Dim::of(6, 4.25, 0.016));
        $this->LETTER = new FitMinMax(Dim::of(5, 3.5, 0.007), Dim::of(11.5, 6.125, 0.25));
        $this->LARGE_ENVELOPE = new FitMinMax(Dim::of(11.5, 6, 0.25), Dim::of(15, 12, 0.75));
        $this->PARCEL = new FitGirthLen(108);
    }
}
Fitters::$i = new Fitters();

// serializing closures requires a heavy lib
interface MatchFn
{
    function __invoke(string $uspsTitle): ?Service;
}

class MatchAny implements MatchFn
{
    public function __construct(Service $s)
    {
        $this->service = $s;
    }

    public function __invoke(string $uspsTitle): ?Service
    {
        return $this->service;
    }

    private $service;
}

class MatchSubstr implements MatchFn
{
    public function __construct(Service $s, string $substr)
    {
        $this->service = $s;
        $this->substr = $substr;
    }

    public function __invoke(string $uspsTitle): ?Service
    {
        return (strpos($uspsTitle, $this->substr) !== false) ? $this->service : null;
    }

    private $service;
    private $substr;
}

class MatchRegex implements MatchFn
{
    public function __construct(Service $s, string $regex)
    {
        $this->service = $s;
        $this->regex = $regex;
    }

    public function __invoke(string $uspsTitle): ?Service
    {
        return preg_match($this->regex, $uspsTitle) ? $this->service : null;
    }

    private $service;
    private $regex;
}


// Regional rate boxes need additonal checks to deal with USPS's complex API
/*case "47" :
    if ( ( $packageLength > 10 || $packageWidth > 7 || $packageHeight > 4.75 ) && ( $packageLength > 12.875 || $packageWidth > 10.9375 || $packageHeight > 2.365 ) ) {
        continue 2;
    } else {
        // Valid
        break;
    }
    break;
case "49" :
    if ( ( $packageLength > 12 || $packageWidth > 10.25 || $packageHeight > 5 ) && ( $packageLength > 15.875 || $packageWidth > 14.375 || $packageHeight > 2.875 ) ) {
        continue 2;
    } else {
        // Valid
        break;
    }
    break;
case "58" :
    if ( $packageLength > 14.75 || $packageWidth > 11.75 || $packageHeight > 11.5 ) {
        continue 2;
    } else {
        // Valid
        break;
    }
    break;*/