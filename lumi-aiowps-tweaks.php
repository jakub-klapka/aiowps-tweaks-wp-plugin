<?php
/*
 * Plugin name: All In One WP Security tweaks
 * Author: Jakub Klapka
 * Author URI: http://www.lumiart.cz
 * Description: Add some more options for All In One WP Security plugin.
 * Version: 1.0
 * License: GPL
 * Textdomain: lumi-aiowps-tweaks
 */

if( !defined( 'ABSPATH' ) ) die();

global $lumi_aiowps_tweaks;

$lumi_aiowps_tweaks['config'] = array(
	'statics_version' => 1,
	'textdomain' => 'lumi-aiowps-tweaks',
	'plugin_basename' => 'lumi-aiowps-tweaks'
);

include_once( 'core/Loader.class.php' );
$lumi_aiowps_tweaks['Loader'] = new \Lumi\AIOWPSTweaks\Loader();