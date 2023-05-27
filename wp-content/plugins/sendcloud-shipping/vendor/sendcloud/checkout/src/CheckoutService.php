<?php

namespace SendCloud\Checkout;

use Exception;
use SendCloud\Checkout\API\Checkout\Checkout;
use SendCloud\Checkout\Contracts\Facades\CheckoutService as BaseService;
use SendCloud\Checkout\Contracts\Proxies\Proxy;
use SendCloud\Checkout\Contracts\Services\DeliveryMethodService;
use SendCloud\Checkout\Contracts\Services\DeliveryMethodSetupService;
use SendCloud\Checkout\Contracts\Services\DeliveryZoneService;
use SendCloud\Checkout\Contracts\Services\DeliveryZoneSetupService;
use SendCloud\Checkout\Domain\Delivery\DeliveryMethod;
use SendCloud\Checkout\Domain\Delivery\DeliveryZone;
use SendCloud\Checkout\Domain\Search\Query;
use SendCloud\Checkout\Exceptions\Domain\FailedToDeleteCheckoutConfigurationException;
use SendCloud\Checkout\Exceptions\Domain\FailedToUpdateCheckoutConfigurationException;
use SendCloud\Checkout\Exceptions\HTTP\HttpException;

/**
 * Class CheckoutService
 *
 * @package SendCloud\Checkout\Facades
 */
class CheckoutService implements BaseService
{
    /**
     * @var DeliveryZoneService
     */
    protected $zoneService;
    /**
     * @var DeliveryZoneSetupService
     */
    protected $zoneSetupService;
    /**
     * @var DeliveryMethodService
     */
    protected $methodService;
    /**
     * @var DeliveryMethodSetupService
     */
    protected $methodSetupService;
    /**
     * @var Proxy
     */
    protected $proxy;

    /**
     * CheckoutService constructor.
     *
     * @param DeliveryZoneService $zoneService
     * @param DeliveryZoneSetupService $zoneSetupService
     * @param DeliveryMethodService $methodService
     * @param DeliveryMethodSetupService $methodSetupService
     * @param Proxy $proxy
     */
    public function __construct(
        DeliveryZoneService $zoneService,
        DeliveryZoneSetupService $zoneSetupService,
        DeliveryMethodService $methodService,
        DeliveryMethodSetupService $methodSetupService,
        Proxy $proxy
    )
    {
        $this->zoneService = $zoneService;
        $this->methodService = $methodService;
        $this->methodSetupService = $methodSetupService;
        $this->zoneSetupService = $zoneSetupService;
        $this->proxy = $proxy;
    }

    /**
     * Updates checkout configuration.
     *
     * @param Checkout $checkout
     *
     * @return void
     *
     * @throws FailedToUpdateCheckoutConfigurationException
     */
    public function update(Checkout $checkout)
    {
        $deliveryZones = array();
        $deliveryMethods = array();

        foreach ($checkout->getDeliveryZones() as $zone) {
            $deliveryZones[] = DeliveryZone::fromDTO($zone);
            $deliveryMethods = array_merge($deliveryMethods, $this->extractDeliveryMethods($zone));
        }

        $this->methodService->deleteObsoleteConfigs();
        $this->zoneService->deleteObsoleteConfigs();

        $methodDiff = $this->methodService->findDiff($deliveryMethods);
        $zoneDiff = $this->zoneService->findDiff($deliveryZones);

        try {
            $this->methodSetupService->deleteSpecific($methodDiff['deleted']);
            $this->methodService->deleteSpecific($methodDiff['deleted']);

            $this->zoneSetupService->deleteSpecific($zoneDiff['deleted']);
            $this->zoneService->deleteSpecific($zoneDiff['deleted']);

            $this->methodSetupService->update($methodDiff['changed']);
            $this->methodService->update($methodDiff['changed']);

            $this->zoneSetupService->update($zoneDiff['changed']);
            $this->zoneService->update($zoneDiff['changed']);

            $this->zoneSetupService->create($zoneDiff['new']);
            $this->zoneService->create($zoneDiff['new']);

            $this->methodSetupService->create($methodDiff['new']);
            $this->methodService->create($methodDiff['new']);
        } catch (Exception $e) {
            throw new FailedToUpdateCheckoutConfigurationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Deletes locally saved configuration.
     *
     * @return void
     *
     * @throws FailedToDeleteCheckoutConfigurationException
     */
    public function delete()
    {
        try {
            $this->zoneSetupService->deleteAll();
            $this->methodSetupService->deleteAll();
            $this->zoneService->deleteAll();
            $this->methodService->deleteAll();
        } catch (Exception $e) {
            throw new FailedToDeleteCheckoutConfigurationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Deletes all data when the uninstall is called.
     *
     * @return void
     *
     * @throws FailedToDeleteCheckoutConfigurationException
     * @throws HttpException
     */
    public function uninstall()
    {
        $this->delete();

        $this->methodService->deleteAllData();
        $this->proxy->delete();
    }

    /**
     * Provides delivery method matching the
     *
     * @param Query $query
     *
     * @return DeliveryMethod[]
     */
    public function search(Query $query)
    {
        $zones = $this->zoneService->search($query);
        $zoneIds = array_map(function (DeliveryZone $zone) {
            return $zone->getId();
        }, $zones);

        return $this->methodService->findInZones($zoneIds);
    }

    /**
     * Extracts delivery methods from a delivery zone.
     *
     * @param API\Checkout\Delivery\Zone\DeliveryZone $zone
     *
     * @return DeliveryMethod[]
     */
    private function extractDeliveryMethods(API\Checkout\Delivery\Zone\DeliveryZone $zone)
    {
        $result = array();
        foreach ($zone->getDeliveryMethods() as $method) {
            $deliveryMethod = DeliveryMethod::fromDTO($method);
            $deliveryMethod->setDeliveryZoneId($zone->getId());
            $result[] = $deliveryMethod;
        }

        return $result;
    }
}