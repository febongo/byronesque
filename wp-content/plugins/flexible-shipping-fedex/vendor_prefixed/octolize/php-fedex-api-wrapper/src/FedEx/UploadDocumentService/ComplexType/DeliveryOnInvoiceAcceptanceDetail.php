<?php

namespace FedExVendor\FedEx\UploadDocumentService\ComplexType;

use FedExVendor\FedEx\AbstractComplexType;
/**
 * DeliveryOnInvoiceAcceptanceDetail
 *
 * @author      Jeremy Dunn <jeremy@jsdunn.info>
 * @package     PHP FedEx API wrapper
 * @subpackage  Upload Document Service
 *
 * @property Party $Recipient
 * @property TrackingId $TrackingId
 */
class DeliveryOnInvoiceAcceptanceDetail extends \FedExVendor\FedEx\AbstractComplexType
{
    /**
     * Name of this complex type
     *
     * @var string
     */
    protected $name = 'DeliveryOnInvoiceAcceptanceDetail';
    /**
     * Set Recipient
     *
     * @param Party $recipient
     * @return $this
     */
    public function setRecipient(\FedExVendor\FedEx\UploadDocumentService\ComplexType\Party $recipient)
    {
        $this->values['Recipient'] = $recipient;
        return $this;
    }
    /**
     * Specifies the tracking id for the return, if preassigned.
     *
     * @param TrackingId $trackingId
     * @return $this
     */
    public function setTrackingId(\FedExVendor\FedEx\UploadDocumentService\ComplexType\TrackingId $trackingId)
    {
        $this->values['TrackingId'] = $trackingId;
        return $this;
    }
}
