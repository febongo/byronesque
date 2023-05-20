<?php
// Add USPS shipping method
function add_usps_shipping_method($methods) {
    $methods['usps'] = 'WC_Shipping_USPS';
    return $methods;
}
add_filter('woocommerce_shipping_methods', 'add_usps_shipping_method');

// Initialize USPS shipping method
function init_usps_shipping_method() {
    if (!class_exists('WC_Shipping_USPS')) {
        class WC_Shipping_USPS extends WC_Shipping_Method {
            /**
             * Constructor for your shipping class
             */
            public function __construct() {
                $this->id                 = 'usps';
                $this->method_title       = 'USPS';
                $this->method_description = 'USPS Shipping here';
    
                // Enable debug mode if needed
                $this->debug              = 'yes';
    
                $this->enabled            = 'yes';
                $this->title              = 'USPS Shipping';
                $this->init();
            }
    
            /**
             * Initialize shipping method settings
             */
            public function init() {
                $this->init_form_fields();
                $this->init_settings();
    
                add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
            }
    
            /**
             * Define shipping method settings fields
             */
            public function init_form_fields() {
                $this->instance_form_fields = array(
                    'enabled' => array(
                        'title'   => 'Enable/Disable',
                        'type'    => 'checkbox',
                        'label'   => 'Enable USPS Shipping',
                        'default' => 'yes',
                    )
                );
            }
    
            /**
             * Calculate shipping rates
             *
             * @param array $package Package details
             */
            public function calculate_shipping($package = array()) {
                // $settings = $this->get_option('instance_settings');

                // USPS API endpoint
                $api_endpoint = 'http://production.shippingapis.com/ShippingAPI.dll';
                
                $api_key = $this->get_option('api_key');
                // USPS API credentials
                $username = $api_key;
                $password = '9520TC20AQ0272M';
                
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
    }
}
add_action('woocommerce_shipping_init', 'init_usps_shipping_method');


?>
