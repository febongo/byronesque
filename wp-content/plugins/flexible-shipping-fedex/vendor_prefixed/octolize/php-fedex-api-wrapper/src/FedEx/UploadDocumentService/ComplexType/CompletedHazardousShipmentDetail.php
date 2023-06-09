<?php

namespace FedExVendor\FedEx\UploadDocumentService\ComplexType;

use FedExVendor\FedEx\AbstractComplexType;
/**
 * Computed shipment level hazardous commodity information.
 *
 * @author      Jeremy Dunn <jeremy@jsdunn.info>
 * @package     PHP FedEx API wrapper
 * @subpackage  Upload Document Service
 *
 * @property CompletedHazardousSummaryDetail $HazardousSummaryDetail
 * @property ShipmentDryIceDetail $DryIceDetail
 * @property AdrLicenseDetail $AdrLicense
 */
class CompletedHazardousShipmentDetail extends \FedExVendor\FedEx\AbstractComplexType
{
    /**
     * Name of this complex type
     *
     * @var string
     */
    protected $name = 'CompletedHazardousShipmentDetail';
    /**
     * Set HazardousSummaryDetail
     *
     * @param CompletedHazardousSummaryDetail $hazardousSummaryDetail
     * @return $this
     */
    public function setHazardousSummaryDetail(\FedExVendor\FedEx\UploadDocumentService\ComplexType\CompletedHazardousSummaryDetail $hazardousSummaryDetail)
    {
        $this->values['HazardousSummaryDetail'] = $hazardousSummaryDetail;
        return $this;
    }
    /**
     * Set DryIceDetail
     *
     * @param ShipmentDryIceDetail $dryIceDetail
     * @return $this
     */
    public function setDryIceDetail(\FedExVendor\FedEx\UploadDocumentService\ComplexType\ShipmentDryIceDetail $dryIceDetail)
    {
        $this->values['DryIceDetail'] = $dryIceDetail;
        return $this;
    }
    /**
     * This contains the ADR License information, which identifies the license number and ADR category under which the customer is allowed to ship.
     *
     * @param AdrLicenseDetail $adrLicense
     * @return $this
     */
    public function setAdrLicense(\FedExVendor\FedEx\UploadDocumentService\ComplexType\AdrLicenseDetail $adrLicense)
    {
        $this->values['AdrLicense'] = $adrLicense;
        return $this;
    }
}
