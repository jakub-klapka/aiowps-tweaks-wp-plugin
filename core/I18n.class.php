<?php


namespace Lumi\AIOWPSTweaks;


class I18n {

	public function __construct() {

		global $lumi_aiowps_tweaks;
		load_plugin_textdomain( $lumi_aiowps_tweaks['config']['textdomain'], false, $lumi_aiowps_tweaks['config']['plugin_basename'] . '/lang' );
	
	}

}