<?php

namespace FedExVendor\FedEx\UploadDocumentService\SimpleType;

use FedExVendor\FedEx\AbstractSimpleType;
/**
 * DangerousGoodsAccessibilityType
 *
 * @author      Jeremy Dunn <jeremy@jsdunn.info>
 * @package     PHP FedEx API wrapper
 * @subpackage  Upload Document Service
 */
class DangerousGoodsAccessibilityType extends \FedExVendor\FedEx\AbstractSimpleType
{
    const _ACCESSIBLE = 'ACCESSIBLE';
    const _INACCESSIBLE = 'INACCESSIBLE';
}
