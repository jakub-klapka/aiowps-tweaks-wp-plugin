<?php


namespace Lumi\AIOWPSTweaks;


class SettingsAPI {

	private $plugin_settings = null;
	private $settings_slug = 'lumi_aiowps_tweaks_settings';

	public function __construct() {

		$this->get_options();

	}

	private function get_options() {
		$options = get_option( $this->settings_slug );
		$this->plugin_settings = ( is_array( $options ) ) ? $options : array();
	}

	public function save( $key, $value ) {

		if( empty( $this->plugin_settings ) ) {
			//No settings in db yet
			add_option( $this->settings_slug, true, null, 'no' );
		}

		$this->plugin_settings[$key] = $value;

		update_option( $this->settings_slug, $this->plugin_settings );

	}

	public function get( $key ) {
		if( isset( $this->plugin_settings[$key] ) ){
			return $this->plugin_settings[$key];
		}
		return false;
	}

}