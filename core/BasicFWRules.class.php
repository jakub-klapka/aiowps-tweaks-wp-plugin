<?php


namespace Lumi\AIOWPSTweaks;


class BasicFWRules {

	/** @var array */
	private $rules_to_remove = false;

	/*
	 * Loaded if is_admin() === true
	 */
	public function __construct() {

		$this->handle_admin_options();
		$this->handle_aiowps_behavior();

	}

	private function handle_admin_options() {

		if( !current_user_can( 'manage_options' ) ) return;

		if( isset( $_GET['page'] ) && $_GET['page'] === 'aiowpsec_firewall' ) {

			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_js_cb' ) );

			add_action( 'admin_menu', array( $this, 'check_for_settings_change' ), 1, 5 ); //Do it before aiowps - which runs on admin_menu with prio 10

		}

	}


	public function load_admin_js_cb() {

		global $lumi_aiowps_tweaks;
		$settings = Settings::getSettings();

//		wp_enqueue_script( 'lumi_aiowps_tweaks_basicfw', plugin_dir_url( __DIR__ ) . 'src_js/basic_fw.js', array( 'jquery' ), $lumi_aiowps_tweaks['config']['statics_version'], true );

		wp_enqueue_script( 'lumi_aiowps_tweaks_basicfw', plugin_dir_url( __DIR__ ) . 'assets/basic_fw.js', array( 'jquery' ), $lumi_aiowps_tweaks['config']['statics_version'], true );

		wp_localize_script( 'lumi_aiowps_tweaks_basicfw', 'LumiAIOWPSTweaksBasicFW', array(
			'dont_use_server_signature_status' => $settings->get( 'dont_use_serversignature' ),
			'dont_limit_upload_size' => $settings->get( 'dont_limit_upload_size' ),
			'__dont_use_server_signature' => __( 'Don\'t use ServerSignature:', $lumi_aiowps_tweaks['config']['textdomain'] ),
			'__server_signature_desc' => __( 'Use this option if your server don\'t allow for ServerSignature directive.', $lumi_aiowps_tweaks['config']['textdomain'] ),
			'__dont_limit_upload_size' => __( 'Don\'t limit upload size:', $lumi_aiowps_tweaks['config']['textdomain'] ),
			'__limit_upload_size_desc' => __( 'Use this option if you don\'t want to limit upload file size to 10MB.', $lumi_aiowps_tweaks['config']['textdomain'] )
		) );

	}

	public function check_for_settings_change() {

		if( !isset( $_POST['aiowps_apply_basic_firewall_settings'] ) ) return;

		$dont_use_serversignature = ( isset( $_POST['lumi_aiowps_tweaks_basicfw_dont_use_serversignature'] ) ) ? true : false;
		$dont_limit_upload_size = ( isset( $_POST['lumi_aiowps_tweaks_basicfw_dont_use_upload_limit'] ) ) ? true : false;

		$settings = Settings::getSettings();
		$settings->save( 'dont_use_serversignature', $dont_use_serversignature );
		$settings->save( 'dont_limit_upload_size', $dont_limit_upload_size );

	}

	private function handle_aiowps_behavior() {

		if( !isset( $_GET['page'] ) || strpos( 'aiowpsec', $_GET['page'] ) !== false || !current_user_can( 'manage_options' ) ) return;

		$settings = Settings::getSettings();
		$dont_use_serversignature = $settings->get( 'dont_use_serversignature' );
		$dont_limit_upload_size = $settings->get( 'dont_limit_upload_size' );

		if( $dont_use_serversignature ) {
			$this->rules_to_remove[] = 'ServerSignature Off';
		}

		if( $dont_limit_upload_size ) {
			$this->rules_to_remove[] = 'LimitRequestBody 10240000';
		}

		if( !empty( $this->rules_to_remove ) ) {
			add_filter( 'aiowps_htaccess_rules_before_writing', array( $this, 'remove_rules' ) );
		}

	}

	public function remove_rules( $rules ) {
		foreach( $this->rules_to_remove as $rule_to_remove ) {
			$key = array_search( $rule_to_remove, $rules );
			if( $key ) {
				unset( $rules[ $key ] );
			}
		}

		return $rules;

	}

}