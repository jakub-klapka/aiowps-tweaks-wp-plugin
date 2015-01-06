<?php


namespace Lumi\AIOWPSTweaks;


class Settings {

	/**
	 * Make sure, that SettingsAPI is constructed only, if Settings is needed.
	 * In any other new request for Settings, return already constructed class.
	 */

	public static function getSettings() {

		global $lumi_aiowps_tweaks;
		if( isset( $lumi_aiowps_tweaks['Settings'] ) ) {
			return $lumi_aiowps_tweaks['Settings'];
		} else {
			include_once( __DIR__ . '/SettingsAPI.class.php' );
			$lumi_aiowps_tweaks['Settings'] = new SettingsAPI();
			return $lumi_aiowps_tweaks['Settings'];
		}

	}

}