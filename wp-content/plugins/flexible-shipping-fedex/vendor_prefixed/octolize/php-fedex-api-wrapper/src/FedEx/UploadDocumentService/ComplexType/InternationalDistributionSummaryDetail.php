<?php

namespace FedExVendor\FedEx\UploadDocumentService\ComplexType;

use FedExVendor\FedEx\AbstractComplexType;
/**
 * Totals accumulated during the processing of CRNs into the consolidation.
 *
 * @author      Jeremy Dunn <jeremy@jsdunn.info>
 * @package     PHP FedEx API wrapper
 * @subpackage  Upload Document Service
 *
 * @property Weight $TotalWeight
 * @property int $TotalPackageCount
 * @property int $TotalUniqueAddressCount
 * @property Money $TotalCustomsValue
 * @property Money $TotalInsuredValue
 * @property Money $TotalFreightCharges
 * @property Money $TotalInsuranceCharges
 * @property Money $TotalTaxesOrMiscellaneousCharges
 * @property Money $TotalHandlingCosts
 * @property Money $TotalPackingCosts
 * @property ShipmentDryIceDetail $DryIceDetail
 * @property \FedEx\UploadDocumentService\SimpleType\DangerousGoodsAccessibilityType|string $DangerousGoodsAccessibility
 */
class InternationalDistributionSummaryDetail extends \FedExVendor\FedEx\AbstractComplexType
{
    /**
     * Name of this complex type
     *
     * @var string
     */
    protected $name = 'InternationalDistributionSummaryDetail';
    /**
     * Set TotalWeight
     *
     * @param Weight $totalWeight
     * @return $this
     */
    public function setTotalWeight(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Weight $totalWeight)
    {
        $this->values['TotalWeight'] = $totalWeight;
        return $this;
    }
    /**
     * Set TotalPackageCount
     *
     * @param int $totalPackageCount
     * @return $this
     */
    public function setTotalPackageCount($totalPackageCount)
    {
        $this->values['TotalPackageCount'] = $totalPackageCount;
        return $this;
    }
    /**
     * Set TotalUniqueAddressCount
     *
     * @param int $totalUniqueAddressCount
     * @return $this
     */
    public function setTotalUniqueAddressCount($totalUniqueAddressCount)
    {
        $this->values['TotalUniqueAddressCount'] = $totalUniqueAddressCount;
        return $this;
    }
    /**
     * Set TotalCustomsValue
     *
     * @param Money $totalCustomsValue
     * @return $this
     */
    public function setTotalCustomsValue(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalCustomsValue)
    {
        $this->values['TotalCustomsValue'] = $totalCustomsValue;
        return $this;
    }
    /**
     * Set TotalInsuredValue
     *
     * @param Money $totalInsuredValue
     * @return $this
     */
    public function setTotalInsuredValue(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalInsuredValue)
    {
        $this->values['TotalInsuredValue'] = $totalInsuredValue;
        return $this;
    }
    /**
     * Set TotalFreightCharges
     *
     * @param Money $totalFreightCharges
     * @return $this
     */
    public function setTotalFreightCharges(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalFreightCharges)
    {
        $this->values['TotalFreightCharges'] = $totalFreightCharges;
        return $this;
    }
    /**
     * Set TotalInsuranceCharges
     *
     * @param Money $totalInsuranceCharges
     * @return $this
     */
    public function setTotalInsuranceCharges(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalInsuranceCharges)
    {
        $this->values['TotalInsuranceCharges'] = $totalInsuranceCharges;
        return $this;
    }
    /**
     * Set TotalTaxesOrMiscellaneousCharges
     *
     * @param Money $totalTaxesOrMiscellaneousCharges
     * @return $this
     */
    public function setTotalTaxesOrMiscellaneousCharges(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalTaxesOrMiscellaneousCharges)
    {
        $this->values['TotalTaxesOrMiscellaneousCharges'] = $totalTaxesOrMiscellaneousCharges;
        return $this;
    }
    /**
     * Set TotalHandlingCosts
     *
     * @param Money $totalHandlingCosts
     * @return $this
     */
    public function setTotalHandlingCosts(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalHandlingCosts)
    {
        $this->values['TotalHandlingCosts'] = $totalHandlingCosts;
        return $this;
    }
    /**
     * Set TotalPackingCosts
     *
     * @param Money $totalPackingCosts
     * @return $this
     */
    public function setTotalPackingCosts(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Money $totalPackingCosts)
    {
        $this->values['TotalPackingCosts'] = $totalPackingCosts;
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
     * Set DangerousGoodsAccessibility
     *
     * @param \FedEx\UploadDocumentService\SimpleType\DangerousGoodsAccessibilityType|string $dangerousGoodsAccessibility
     * @return $this
     */
    public function setDangerousGoodsAccessibility($dangerousGoodsAccessibility)
    {
        $this->values['DangerousGoodsAccessibility'] = $dangerousGoodsAccessibility;
        return $this;
    }
}
