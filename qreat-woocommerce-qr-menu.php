<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://qreatmenu.com
 * @since             1.0.0
 * @package           Qreat_Woocommerce_Qr_Menu
 *
 * @wordpress-plugin
 * Plugin Name:       Qreatmenu - Restaurant QR Menu for WooCommerce
 * Plugin URI:        http://qreatmenu.com
 * Description:       This plugins helps you to create a Restaurant Menu from WooCommerce products. And generate a QR code for your menu. 
 * Version:           1.0.0
 * Author:            Qreat Team
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qreat-woocommerce-qr-menu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'QREAT_WOOCOMMERCE_QR_MENU_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-qreat-woocommerce-qr-menu-activator.php
 */
function activate_qreat_woocommerce_qr_menu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qreat-woocommerce-qr-menu-activator.php';
	Qreat_Woocommerce_Qr_Menu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-qreat-woocommerce-qr-menu-deactivator.php
 */
function deactivate_qreat_woocommerce_qr_menu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qreat-woocommerce-qr-menu-deactivator.php';
	Qreat_Woocommerce_Qr_Menu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_qreat_woocommerce_qr_menu' );
register_deactivation_hook( __FILE__, 'deactivate_qreat_woocommerce_qr_menu' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-qreat-woocommerce-qr-menu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_qreat_woocommerce_qr_menu() {

	$plugin = new Qreat_Woocommerce_Qr_Menu();
	$plugin->run();

}
run_qreat_woocommerce_qr_menu();



/**
 * Is elementor plugin installed.
 */
if ( ! function_exists( '_is_woocommerce_installed' ) ) {

	/**
	 * Check if WooCommerce is installed
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function _is_woocommerce_installed() {
		return defined( 'WooCommerce' ) ? true : false;
	}
}




	// Show WooCommerce Categories On Shop Page
	update_option( 'woocommerce_shop_page_display', 'subcategories' );



//  Change WooCommerce Shop Title


add_filter( 'woocommerce_page_title', 'qrm_shop_page_title');
    function qrm_shop_page_title( $page_title ) {
        if( 'Shop' == $page_title) {
            return esc_html__("Categories","qrm");
        }
    }
		

		// Add Unique Class

		add_filter( 'body_class','qrm_add_unique_body_class' );
		function qrm_add_unique_body_class( $classes ) {
			$classes[] = 'qrm';
			return $classes;
		}

		// Remvoe Breadcrumb

	add_action('template_redirect', 'qrm_remove_shop_breadcrumbs' );
	function qrm_remove_shop_breadcrumbs(){

			if( _is_woocommerce_installed() ){
				if (is_shop() ){
					remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );			
				}
			}

		}

		// Remove Breadcrumb

	add_action('init', 'qrm_remove_actions' );
	function qrm_remove_actions(){
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );	
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );	
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );	
		}


		add_action( 'woocommerce_before_shop_loop', 'qrm_add_shop_button', 50 );

		add_action( 'woocommerce_before_shop_loop_item', 'qrm_open_div_for_thumbnail', 9 );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item', 'qrm_close_div_for_thumbnail', 11 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'qrm_open_div__title', 9 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 11 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'qrm_close_div_title', 12 );


		function qrm_open_div_for_thumbnail(){
			echo "<div class='qrm-product-left'>";
		}

		function qrm_close_div_for_thumbnail(){
			echo "</div>";
		}

		function qrm_open_div__title(){
			echo "<div class='qrm-product-right'>";
			echo "<div class='qrm-product-top'>";
		}

		function qrm_close_div_title(){

			global $product;

			echo "</div>";

			echo '<div class="qrm-product-summarize" itemprop="description">';
			echo 		apply_filters( 'woocommerce_short_description', $product->post->post_excerpt );
			echo '</div>';

			echo "</div>";

		}

		// Customize Thumbnail Size for Category Single Product Image
		add_filter('single_product_archive_thumbnail_size', 'qrm_product_thumb_size');
		function qrm_product_thumb_size(){
				return array(620, 620,true);
		}
		

		function qrm_add_shop_button(){
			if( is_product_category() ){
				echo "<div class='qrm-shop-button'><h6><a href='" . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . "'>". esc_html__("MENU","qrm") ."</a></h6></div>";
			}
		}