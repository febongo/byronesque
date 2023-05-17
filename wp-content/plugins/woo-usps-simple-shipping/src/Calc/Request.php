<?php declare(strict_types=1);
namespace Dgm\UspsSimple\Calc;


class Request
{
    /**
     * @var string
     * @psalm-readonly
     */
    public $apiUserId;

    /**
     * @var Package
     * @psalm-readonly
     */
    public $package;

    /**
     * @var Services
     * @psalm-readonly
     */
    public $services;

    /**
     * @var bool
     * @psalm-readonly
     */
    public $groupByWeight;

    /**
     * @var bool
     * @psalm-readonly
     */
    public $commercialRates;


    public function __construct(string $apiUserId, Package $package, Services $services, bool $groupByWeight, bool $commercialRates)
    {
        $this->package = $package;
        $this->services = $services;
        $this->groupByWeight = $groupByWeight;
        $this->commercialRates = $commercialRates;
        $this->apiUserId = $apiUserId;
    }

    public function cacheKey(): string
    {
        return hash('sha256', serialize($this));
    }
}