<?php

namespace FedExVendor\Octolize\ShippingExtensions\Tracker;

use Exception;
use FedExVendor\Octolize\ShippingExtensions\Tracker\DataProvider\ShippingExtensionsDataProvider;
use FedExVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FedExVendor\WPDesk_Tracker;
/**
 * .
 */
class Tracker implements \FedExVendor\WPDesk\PluginBuilder\Plugin\Hookable
{
    /**
     * @var ViewPageTracker
     */
    private $tracker;
    /**
     * @param ViewPageTracker $tracker
     */
    public function __construct(\FedExVendor\Octolize\ShippingExtensions\Tracker\ViewPageTracker $tracker)
    {
        $this->tracker = $tracker;
    }
    /**
     * Hooks.
     */
    public function hooks() : void
    {
        try {
            $tracker = $this->get_tracker();
            $tracker->add_data_provider(new \FedExVendor\Octolize\ShippingExtensions\Tracker\DataProvider\ShippingExtensionsDataProvider($this->tracker));
        } catch (\Exception $e) {
            // phpcs:ignore
            // Do nothing.
        }
    }
    /**
     * @return WPDesk_Tracker
     * @throws Exception
     */
    protected function get_tracker() : \FedExVendor\WPDesk_Tracker
    {
        $tracker = \apply_filters('wpdesk_tracker_instance', null);
        if ($tracker instanceof \FedExVendor\WPDesk_Tracker) {
            return $tracker;
        }
        throw new \Exception('Tracker not found');
    }
}
