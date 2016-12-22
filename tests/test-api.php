<?php

class ApiTest extends WP_UnitTestCase {

	function testConnectionWithoutKey() {
		global $vrp;
		$check = $vrp->testAPI();
		$this->assertTrue( isset( $check->Error ) );
	}

	function testConnectionWithKey() {
		global $vrp;
		$vrp->load_demo_key();
		$check = $vrp->testAPI();
		$this->assertTrue( ((isset( $check->Status )) && ( 'Online' == $check->Status ) ) );
	}

	function testCache() {
		global $vrp;
		$vrp->load_demo_key();
		$cache_key	 = md5( 'getunit/8440-Jake-Teeter-Lahontan-Family-Retreat' . implode( '_', array() ) );
		$data		 = $vrp->call( 'getunit/8440-Jake-Teeter-Lahontan-Family-Retreat' );
		$cache		 = wp_cache_get( $cache_key, 'vrp' );
		if ( false != $cache ) {
			$cache = true;
		}
		$this->assertTrue( $cache );
	}

}
