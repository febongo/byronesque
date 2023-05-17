<?php
// Define the USPS shipping method class
class Custom_USPS_Shipping_Method extends WC_Shipping_Method {
    
    // Constructor
    public function __construct() {
        $this->id                 = 'custom_usps'; // Unique ID for the shipping method
        $this->method_title       = 'USPS'; // Name of the shipping method displayed to users
        $this->method_description = 'USPS shipping method'; // Description of the shipping method
        $this->enabled            = 'yes'; // Enable the shipping method
        
        $this->init(); // Initialize the shipping method settings
    }
    
    // Initialize the shipping method settings
    // ...

    // Initialize the shipping method settings
    public function init() {
        $this->title = 'USPS Shipping'; // Title of the shipping method displayed to users
        
        // Add the shipping method settings
        $this->init_form_fields();
        $this->init_settings();
        
        // Define the shipping method options
        $this->instance_form_fields = array(
            'title' => array(
                'title'       => 'Title',
                'type'        => 'text',
                'description' => 'Title of the shipping method',
                'default'     => 'USPS Shipping',
                'desc_tip'    => true,
            ),
            // Add more options here as needed
        );
        
        // Register the shipping method
        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    // Calculate shipping rates
    public function calculate_shipping($package = array()) {
        // Retrieve the shipping method settings
        $settings = $this->get_option('instance_settings');

        // USPS API endpoint
        $api_endpoint = 'http://production.shippingapis.com/ShippingAPI.dll';
        
        // USPS API credentials
        $username = 'YOUR_API_USERNAME';
        $password = 'YOUR_API_PASSWORD_OR_API_KEY';
        
        // Package dimensions and weight
        $weight = floatval($this->get_package_weight($package)); // Get the weight of the package
        $length = floatval($this->get_package_length($package)); // Get the length of the package
        $width  = floatval($this->get_package_width($package));  // Get the width of the package
        $height = floatval($this->get_package_height($package)); // Get the height of the package
        
        // Origin and destination addresses
        $origin      = 'YOUR_ORIGIN_ADDRESS'; // Set the origin address
        $destination = $package['destination']; // Get the destination address from the package
        
        // USPS API request parameters
        $params = array(
            'API'      => 'RateV4',
            'XML'      => '<RateV4Request USERID="' . $username . '">
                            <Package ID="1">
                                <Service>PRIORITY</Service>
                                <ZipOrigination>' . $origin . '</ZipOrigination>
                                <ZipDestination>' . $destination['postcode'] . '</ZipDestination>
                                <Pounds>' . floor($weight) . '</Pounds>
                                <Ounces>' . fmod($weight, 1) * 16 . '</Ounces>
                                <Container>VARIABLE</Container>
                                <Size>REGULAR</Size>
                                <Width>' . $width . '</Width>
                                <Length>' . $length . '</Length>
                                <Height>' . $height . '</Height>
                                <Girth>0</Girth>
                                <Machinable>true</Machinable>
                            </Package>
                        </RateV4Request>'
        );
        
        // Send the API request
        $response = wp_remote_post($api_endpoint, array(
            'method'    => 'POST',
            'timeout'   => 45,
            'headers'   => array('Content-Type' => 'application/x-www-form-urlencoded'),
            'body'      => http_build_query($params)
        ));
    }

}   

// Register the USPS shipping method
function add_custom_usps_shipping_method($methods) {
    // $methods['custom_usps'] = 'custom_usps';
    $methods['custom_usps']->enabled = 'yes';
    return $methods;
}
add_filter('woocommerce_shipping_methods', 'add_custom_usps_shipping_method');
?>
