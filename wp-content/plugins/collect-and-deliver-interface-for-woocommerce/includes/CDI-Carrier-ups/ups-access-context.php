<?php
	$upsaccessLicenseNumber = get_option( 'cdi_o_settings_ups_accessLicenseNumber' );
	$upsuserId = get_option( 'cdi_o_settings_ups_userid' );
	$upspassword = get_option( 'cdi_o_settings_ups_password' );
	$upscomptenumber = get_option( 'cdi_o_settings_ups_comptenumber' );
if ( get_option( 'cdi_o_settings_ups_modetestprod' ) == 'yes' ) {
	// Prod
	$urlconfirm = 'https://onlinetools.ups.com/ups.app/xml/ShipConfirm';
	$urlaccept = 'https://onlinetools.ups.com/ups.app/xml/ShipAccept';
	$urlvoid = 'https://onlinetools.ups.com/ups.app/xml/Void';
	$urllabel = 'https://onlinetools.ups.com/ups.app/xml/LabelRecovery';
	$urltrack = 'https://onlinetools.ups.com/ups.app/xml/Track';
	$urllocator = 'https://onlinetools.ups.com/ups.app/xml/Locator';
} else {
	// Test
	$urlconfirm = 'https://wwwcie.ups.com/ups.app/xml/ShipConfirm';
	$urlaccept = 'https://wwwcie.ups.com/ups.app/xml/ShipAccept';
	$urlvoid = 'https://wwwcie.ups.com/ups.app/xml/Void';
	$urllabel = 'https://wwwcie.ups.com/ups.app/xml/LabelRecovery';
	$urltrack = 'https://wwwcie.ups.com/ups.app/xml/Track';
	$urllocator = 'https://wwwcie.ups.com/ups.app/xml/Locator';
}
