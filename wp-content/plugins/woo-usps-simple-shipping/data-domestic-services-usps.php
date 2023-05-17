<?php /** @noinspection PackedHashtableOptimizationInspection */
return [

	'EXPRESS_MAIL' => [
		'name'  => __('Priority Mail Express', 'woo-usps-simple-shipping'),
		'services' => [
            '3'  => __('Priority Mail Express', 'woo-usps-simple-shipping'),
            '2'  => __('Priority Mail Express, Hold for Pickup', 'woo-usps-simple-shipping'),
            '23' => __('Priority Mail Express, Sunday/Holiday', 'woo-usps-simple-shipping'),
        ]
    ],

	'PRIORITY_MAIL' => [
		'name'  => __('Priority Mail', 'woo-usps-simple-shipping'),
		'services' => [
			'1'  => __('Priority Mail', 'woo-usps-simple-shipping'),
			'33' => __('Priority Mail, Hold For Pickup', 'woo-usps-simple-shipping'),
			'18' => __('Priority Mail Keys and IDs', 'woo-usps-simple-shipping'),
			'47' => __('Priority Mail Regional Rate Box A', 'woo-usps-simple-shipping'),
			'48' => __('Priority Mail Regional Rate Box A, Hold For Pickup', 'woo-usps-simple-shipping'),
			'49' => __('Priority Mail Regional Rate Box B', 'woo-usps-simple-shipping'),
			'50' => __('Priority Mail Regional Rate Box B, Hold For Pickup', 'woo-usps-simple-shipping'),
        ]
    ],

	'FIRST_CLASS' => [
		'name'  => __('First-Class Mail', 'woo-usps-simple-shipping'),
		'services' => [
			'0A'  => __('First-Class Mail Postcards', 'woo-usps-simple-shipping'),
			'0B'  => __('First-Class Mail Letter', 'woo-usps-simple-shipping'),
			'0C'  => __('First-Class Mail Large Envelope', 'woo-usps-simple-shipping'),
			'0D'  => __('First-Class Mail Parcel', 'woo-usps-simple-shipping'),
			'12' => __('First-Class Postcard Stamped', 'woo-usps-simple-shipping'),
			'15' => __('First-Class Large Postcards', 'woo-usps-simple-shipping'),
			'19' => __('First-Class Keys and IDs', 'woo-usps-simple-shipping'),
			'0E' => __('First-Class Package Service – Retail', 'woo-usps-simple-shipping'),
			'61' => __('First-Class Package Service', 'woo-usps-simple-shipping'),
			'53' => __('First-Class Package Service, Hold For Pickup', 'woo-usps-simple-shipping'),
			'78' => __('First-Class Mail Metered Letter', 'woo-usps-simple-shipping'),
        ]
    ],

	'STANDARD_POST' => [
		'name'  => __('USPS Retail Ground', 'woo-usps-simple-shipping'),
		'services' => [
			'4'  => __('USPS Retail Ground', 'woo-usps-simple-shipping'),
        ]
    ],

	'MEDIA_MAIL' => [
		'name'  => __('Media Mail', 'woo-usps-simple-shipping'),
		'services' => [
			'6'  => __('Media Mail', 'woo-usps-simple-shipping'),
        ]
    ],

	'LIBRARY_MAIL' => [
		'name'  => __('Library Mail', 'woo-usps-simple-shipping'),
		'services' => [
			'7'  => __('Library Mail', 'woo-usps-simple-shipping'),
        ]
    ]
];