<?php

class geoip_rulesModelWcu extends modelWcu {

    public function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        $part = explode(':', $ip);
        return $part[0];
    }

    // not used if WC_Geolocation class is included
	public function getCountryCodeByIp( $ip ) {
		if ( ! empty( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) {
			$countryCode = $_SERVER['HTTP_CF_IPCOUNTRY'];
		} else {
			$ip = ! empty( $ip ) ? $ip : '78.8.53.5';
			importClassWcu( 'SxGeo', WCU_HELPERS_DIR . 'SxGeo.php' );
			importClassWcu( 'CountryCodes', WCU_HELPERS_DIR . 'CountryCodes.php' );
			$sxGeo       = new SxGeo( WCU_FILES_DIR . 'SxGeo.dat' );
			$countryCode = $sxGeo->getCountry( $ip );
		}

		return $countryCode;
	}

}
