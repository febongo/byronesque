<?php

namespace FedExVendor\Octolize\ShippingExtensions;

/**
 * .
 */
trait AdminPage
{
    /**
     * @return bool
     */
    public function is_shipping_extensions_page() : bool
    {
        return (\get_current_screen()->id ?? '') === \FedExVendor\Octolize\ShippingExtensions\Page::SCREEN_ID;
    }
}
