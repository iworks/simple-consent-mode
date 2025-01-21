<?php
/*
Plugin Name: Simple Consent Mode
Text Domain: simple-consent-mode
Plugin URI: http://iworks.pl/simple-consent-mode/
Description:
Version: PLUGIN_VERSION
Author: Marcin Pietrzak
Author URI: http://iworks.pl/
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Copyright 2023-PLUGIN_TILL_YEAR Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * static options
 */
$base   = dirname( __FILE__ );
$vendor = $base . '/includes';

/**
 * require: Iworkssimple-consent-mode Class
 */
if ( ! class_exists( 'iworks_simple_consent_mode' ) ) {
	require_once $vendor . '/iworks/class-simple-consent-mode.php';
}
/**
 * configuration
 */
require_once $base . '/etc/options.php';
/**
 * require: IworksOptions Class
 */
if ( ! class_exists( 'iworks_options' ) ) {
	require_once $vendor . '/iworks/options/options.php';
}
/**
 * load options
 */
global $iworks_simple_consent_mode_options;
$iworks_simple_consent_mode_options = new iworks_options();
$iworks_simple_consent_mode_options->set_option_function_name( 'iworks_simple_consent_mode_options' );
$iworks_simple_consent_mode_options->set_option_prefix( IWORKS_SIMPLE_CONSENT_MODE_PREFIX );

function iworks_simple_consent_mode_get_options() {
	global $iworks_simple_consent_mode_options;
	return $iworks_simple_consent_mode_options;
}

function iworks_simple_consent_mode_options_init() {
	global $iworks_simple_consent_mode_options;
	$iworks_simple_consent_mode_options->options_init();
}

function iworks_simple_consent_mode_activate() {
	$iworks_simple_consent_mode_options = new iworks_options();
	$iworks_simple_consent_mode_options->set_option_function_name( 'iworks_simple_consent_mode_options' );
	$iworks_simple_consent_mode_options->set_option_prefix( IWORKS_SIMPLE_CONSENT_MODE_PREFIX );
	$iworks_simple_consent_mode_options->activate();
}

function iworks_simple_consent_mode_deactivate() {
	global $iworks_simple_consent_mode_options;
	$iworks_simple_consent_mode_options->deactivate();
}

$iworks_simple_consent_mode = new iworks_simple_consent_mode();

/**
 * install & uninstall
 */
register_activation_hook( __FILE__, 'iworks_simple_consent_mode_activate' );
register_deactivation_hook( __FILE__, 'iworks_simple_consent_mode_deactivate' );
