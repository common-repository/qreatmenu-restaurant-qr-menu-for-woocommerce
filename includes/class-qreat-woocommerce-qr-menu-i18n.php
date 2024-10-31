<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://qreatmenu.com
 * @since      1.0.0
 *
 * @package    Qreat_Woocommerce_Qr_Menu
 * @subpackage Qreat_Woocommerce_Qr_Menu/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Qreat_Woocommerce_Qr_Menu
 * @subpackage Qreat_Woocommerce_Qr_Menu/includes
 * @author     Qreat Team <info@qreatmenu.com>
 */
class Qreat_Woocommerce_Qr_Menu_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'qreat-woocommerce-qr-menu',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
