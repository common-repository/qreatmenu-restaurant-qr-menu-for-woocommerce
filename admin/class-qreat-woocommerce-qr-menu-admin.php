<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://qreatmenu.com
 * @since      1.0.0
 *
 * @package    Qreat_Woocommerce_Qr_Menu
 * @subpackage Qreat_Woocommerce_Qr_Menu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Qreat_Woocommerce_Qr_Menu
 * @subpackage Qreat_Woocommerce_Qr_Menu/admin
 * @author     Qreat Team <info@qreatmenu.com>
 */
class Qreat_Woocommerce_Qr_Menu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			add_action( 'admin_notices', [ $this, 'woocommerce_not_available' ] );
			add_action( 'network_admin_notices', [ $this, 'woocommerce_not_available' ] );

		}

			add_action('admin_menu', [$this, 'amc_register_qr_menu_subpage'], 70 );


	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Qreat_Woocommerce_Qr_Menu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Qreat_Woocommerce_Qr_Menu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/qrm-woocommerce-qr-menu-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Qreat_Woocommerce_Qr_Menu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Qreat_Woocommerce_Qr_Menu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/qrm-woocommerce-qr-menu-admin.js', array( 'jquery'), $this->version, true );
		wp_enqueue_script( "qrm-qr-code", plugin_dir_url( __FILE__ ) . 'js/qrm-qrcode.js', array( 'jquery' ), $this->version, false );

	}



	/**
	 * Prints the admin notics when WooCommerce is not installed or activated.
	 */
	public function woocommerce_not_available() {


			// Check user capability.
			if ( ! ( current_user_can( 'activate_plugins' ) && current_user_can( 'install_plugins' ) ) ) {
				return;
			}

			/* TO DO */
			$class = 'notice notice-error';
			/* translators: %s: html tags */
			$message = sprintf( __( 'The %1$s QR Menu for WooCommerce%2$s plugin requires %1$sWooCommerce%2$s plugin installed & activated.', 'amc' ), '<strong>', '</strong>' );

			$plugin = 'woocommerce/woocommerce.php';

			if ( ! _is_woocommerce_installed() ) {

				$action_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
				$button_label = __( 'Install WooCommerce', 'amc' );

			}

			$button = '<p><a href="' . $action_url . '" class="button-primary">' . $button_label . '</a></p><p></p>';

			printf( '<div class="%1$s"><p>%2$s</p>%3$s</div>', esc_attr( $class ), wp_kses_post( $message ), wp_kses_post( $button ) );

	}


public function amc_register_qr_menu_subpage() {

    add_submenu_page( 'woocommerce', esc_html__('QR Menu','qrm'), esc_html__('QR Menu','qrm'), 'manage_options', 'qr-menu', [$this, 'amc_register_qr_menu_subpage_callback'] ); 
}


public function amc_register_qr_menu_subpage_callback() {

	echo '<div class="qrm-admin-page qrm-wrapper">';	
	echo '	<h1>' . esc_html__("QR Menu","qrm") . '</h1>';
	echo '	<div class="qrm-header-section">';
	echo '		<ul class="qrm-anchor-menu">';
	echo '			<li><a href="#qrm-quick-quide">'. esc_html__("Quick Quide","qrm") . '</a></li>';
	echo '			<li><a href="#qrm-generate">' . esc_html__("QR Code Generate","qrm") . '</a></li>';
	echo '		</ul>';
	echo '	</div>';



	echo '	<div id="qrm-quick-quide" class="qrm-content-section">';
	echo '		<div class="qrm-section-title">';
	echo '			<h2>' . esc_html__("Quick Quide","qrm") . '</h2>';
	echo '		</div>';
	echo '		<div class="quick-quide-content">';
	echo '			<div class="qrm-step qrm-step-1">';
	echo '				<div class="qrm-guide-circle"><img src="'. plugin_dir_url( __FILE__ ) .'img/step-1.png"><h3><a href="post-new.php?post_type=page">' . esc_html__("Create Page","qrm") . '</a></h3><h4>'. esc_html__("Step 1","qrm") .'</h4></div>';
	echo '			</div>';
	echo '			<div class="qrm-step qrm-step-2">';
	echo '				<div class="qrm-guide-circle"><img src="'. plugin_dir_url( __FILE__ ) .'img/step-2.png"><h3><a href="admin.php?page=wc-settings&tab=products">' . esc_html__("Set The Page as Menu","qrm") . '</a></h3><h4>'. esc_html__("Step 2","qrm") .'</h4></div>';
	echo '			</div>';
	echo '			<div class="qrm-step qrm-step-3">';
	echo '				<div class="qrm-guide-circle"><img src="'. plugin_dir_url( __FILE__ ) .'img/step-3.png"><h3><a href="post-new.php?post_type=product">' . esc_html__("Add Your First Product","qrm") . '</a></h3><h4>'. esc_html__("Step 3","qrm") .'</h4></div>';
	echo '			</div>';
	echo '			<div class="qrm-step qrm-step-4">';
	echo '				<div class="qrm-guide-circle"><img src="'. plugin_dir_url( __FILE__ ) .'img/step-4.png"><h3><a href="#qrm-generate">' . esc_html__("Generate the QR","qrm") . '</a></h3><h4>'. esc_html__("Step 4","qrm") .'</h4></div>';
	echo '			</div>';
	echo '		</div>';
  echo '	</div>';

	
	echo '	<div id="qrm-generate" class="qrm-content-section">';
	echo '		<div class="qrm-section-title">';
	echo '			<h2>' . esc_html__("QR Code Generate","qrm") . '</h2>';
	echo '			<p>' . esc_html__("The QR Code forward your Customer to the WooCommerce Shop Page","qrm") . '</p>';
	echo '		</div>';
	echo '		<div class="qrm-fields">';
	echo '			<div class="qrm-field">';
	echo '			<table class="form-table" role="presentation">';
	echo '				<tbody>';
	echo '					<tr>';
	echo '						<th scope="row"><label for="qrm_menu_page">'. esc_html__("Restaurant Page URL","qrm") .'</label></th>';
	echo '						<td>';
	echo '							<input name="qrm_menu_page" type="text" id="qrmUrl" class="regular-text" value="'. esc_url( wc_get_page_permalink( "shop" ) ) .'" >';
	echo '							<input type="submit" name="submit" id="generateQrCode" class="button button-primary" value="' . esc_html__("Generate","qrm") . '">';
	echo '							<p class="description">' . sprintf('Generate QR Code. Set the page as a Restaurant Menu <a href="%s"> %s</a>', esc_url( 'http://qreat.local/wp-admin/admin.php?page=wc-settings&tab=products' ), esc_html__("here","qrm")  ) . '</p>';
	echo '						</td>';
	echo '					</tr>';
	echo '					<tr>';
	echo '					<td></td>';
	echo '					<td>';	
  echo '						<div id="qrcodePNG"></div>';	
	echo '						<div class="qrm-svg-code">';
	echo '								<svg id="qrmQR" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';
  echo '								 <g id="qrCodeSVG"/>';
  echo '							</svg>';
  echo '							<div class="qr-buttons">';
  echo '								<span><h4>' . esc_html__("Download","qrm") . '</h4></span>';
  echo '								<a id="qrm-download-svg" class="button is-secondary" download="' . esc_html__("QR Menu SVG Code","qrm") . '" download>' . esc_html__("SVG","qrm") . '</a>';
  echo '							</div>';
  echo '						</div>';
	echo '					</td>';
	echo '					</tr>';
	echo '				</tbody>';
	echo '			</table>';
	echo '			</div>';
	echo '		</div>';
  echo '	</div>';



  echo '</div>';

}


}