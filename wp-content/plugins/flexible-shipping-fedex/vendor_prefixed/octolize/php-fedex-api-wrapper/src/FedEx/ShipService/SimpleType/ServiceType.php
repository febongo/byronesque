<?php

namespace FedExVendor\FedEx\ShipService\SimpleType;

use FedExVendor\FedEx\AbstractSimpleType;
/**
 * ServiceType
 *
 * @author      Jeremy Dunn <jeremy@jsdunn.info>
 * @package     PHP FedEx API wrapper
 * @subpackage  Ship Service
 */
class ServiceType extends \FedExVendor\FedEx\AbstractSimpleType
{
    const _EUROPE_FIRST_INTERNATIONAL_PRIORITY = 'EUROPE_FIRST_INTERNATIONAL_PRIORITY';
    const _FEDEX_1_DAY_FREIGHT = 'FEDEX_1_DAY_FREIGHT';
    const _FEDEX_2_DAY = 'FEDEX_2_DAY';
    const _FEDEX_2_DAY_AM = 'FEDEX_2_DAY_AM';
    const _FEDEX_2_DAY_FREIGHT = 'FEDEX_2_DAY_FREIGHT';
    const _FEDEX_3_DAY_FREIGHT = 'FEDEX_3_DAY_FREIGHT';
    const _FEDEX_DISTANCE_DEFERRED = 'FEDEX_DISTANCE_DEFERRED';
    const _FEDEX_EXPRESS_SAVER = 'FEDEX_EXPRESS_SAVER';
    const _FEDEX_FIRST_FREIGHT = 'FEDEX_FIRST_FREIGHT';
    const _FEDEX_FREIGHT_ECONOMY = 'FEDEX_FREIGHT_ECONOMY';
    const _FEDEX_FREIGHT_PRIORITY = 'FEDEX_FREIGHT_PRIORITY';
    const _FEDEX_GROUND = 'FEDEX_GROUND';
    const _FEDEX_NEXT_DAY_AFTERNOON = 'FEDEX_NEXT_DAY_AFTERNOON';
    const _FEDEX_NEXT_DAY_EARLY_MORNING = 'FEDEX_NEXT_DAY_EARLY_MORNING';
    const _FEDEX_NEXT_DAY_END_OF_DAY = 'FEDEX_NEXT_DAY_END_OF_DAY';
    const _FEDEX_NEXT_DAY_FREIGHT = 'FEDEX_NEXT_DAY_FREIGHT';
    const _FEDEX_NEXT_DAY_MID_MORNING = 'FEDEX_NEXT_DAY_MID_MORNING';
    const _FIRST_OVERNIGHT = 'FIRST_OVERNIGHT';
    const _GROUND_HOME_DELIVERY = 'GROUND_HOME_DELIVERY';
    const _INTERNATIONAL_ECONOMY = 'INTERNATIONAL_ECONOMY';
    const _INTERNATIONAL_ECONOMY_FREIGHT = 'INTERNATIONAL_ECONOMY_FREIGHT';
    const _INTERNATIONAL_FIRST = 'INTERNATIONAL_FIRST';
    const _INTERNATIONAL_PRIORITY = 'INTERNATIONAL_PRIORITY';
    const _INTERNATIONAL_PRIORITY_EXPRESS = 'INTERNATIONAL_PRIORITY_EXPRESS';
    const _INTERNATIONAL_PRIORITY_FREIGHT = 'INTERNATIONAL_PRIORITY_FREIGHT';
    const _PRIORITY_OVERNIGHT = 'PRIORITY_OVERNIGHT';
    const _SAME_DAY = 'SAME_DAY';
    const _SAME_DAY_CITY = 'SAME_DAY_CITY';
    const _SMART_POST = 'SMART_POST';
    const _STANDARD_OVERNIGHT = 'STANDARD_OVERNIGHT';
}
