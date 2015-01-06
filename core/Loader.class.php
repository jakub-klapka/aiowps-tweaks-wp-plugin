<?php


namespace Lumi\AIOWPSTweaks;


class Loader {

	public function __construct() {
	
		add_action( 'init', array( $this, 'init' ) );
	
	}

	public function init() {
		global $lumi_aiowps_tweaks;

		//Basic Firewall rules options
		if( is_admin() ) { //no reason to load it on frontend
			include_once( __DIR__ . '/Settings.class.php' );
			include_once( __DIR__ . '/BasicFWRules.class.php' );
			$lumi_aiowps_tweaks['BasicFWRules'] = new BasicFWRules();
		}

	}

}