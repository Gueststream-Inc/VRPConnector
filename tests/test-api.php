<?php

class ApiTest extends WP_UnitTestCase {

	function testConnectionWithoutKey() {
		global $vrp;
		$check = $vrp->testAPI();
		$this->assertTrue( isset( $check->Error ) );
	}

	function testConnectionWithKey() {
		global $vrp;
        $vrp->setAPIKey('1533020d1121b9fea8c965cd2c978296'); //Demo key
		$this->assertTrue( $vrp->getPluginStatus()->apiAvailable );
	}

	function testCache() {
		global $vrp;
        $vrp->setAPIKey('1533020d1121b9fea8c965cd2c978296'); //Demo key
		$cache_key	 = md5( 'getunit/8440-Jake-Teeter-Lahontan-Family-Retreat' . implode( '_', array() ) );
		$data		 = $vrp->api->call( 'getunit/8440-Jake-Teeter-Lahontan-Family-Retreat' );
		$cache		 = wp_cache_get( $cache_key, 'vrp' );
		if ( false != $cache ) {
			$cache = true;
		}
		$this->assertTrue( $cache );
	}

}
