<?php
/**
 * @link            https://pass.qa
 * @since           1.0.0
 * @package         Pass_WooCommerce_Shipping
 *
 * @wordpress-plugin
 * Plugin Name:     Pass WooCommerce Shipping
 * Plugin URI:      https://pass.qa/developers/
 * Description:     Pass delivery plugin for WooCommerce shipping
 * Version:         1.0.0
 * Author:          Mostafa Sharami, Majid Vahidkhoo
 * Author URI:      https://pass.qa/
 * Author URI:      http://MostafaSharami.com/
 * Author URI:      http://Majva.com/
 *
 * Copyright:             © 2018 https://Peyk.uk/.
 * License:               GNU General Public License v3.0
 * License URI:           http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH'))
    exit;

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
    return;

if (!class_exists('Pass_Delivery')) {

    define( 'PASS_PLUGIN_DIR', __DIR__ );
    define( 'PASS_PLUGIN_VERSION', '1.0.0' );
    define( 'PASS_METHOD_ID', 'pass_woocommerce_shipping');
    define( 'PASS_TRANSLATE_ID', 'pass-woocommerce-shipping');
    define( 'PASS_INTEGRATE_URL', 'https://www.pass.qa/integrations/' );
    define( 'PASS_DOCUMENT_URL', 'https://passdelivery.readme.io/reference/get-api-token' );
    define( 'PASS_METHOD_TITLE', __('Pass Delivery', PASS_TRANSLATE_ID));
    define( 'PASS_METHOD_DESC', sprintf( __('<a href="%s" target="_blank">Pass.qa</a> delivery plugin for WooCommerce shipping', PASS_TRANSLATE_ID), PASS_INTEGRATE_URL));
    define( 'PASS_GET_KEY_HELP', sprintf( __('Go to the <a href="%s" target="_blank">Pass.qa API document</a> for help to how to can get an api key and use', PASS_TRANSLATE_ID), PASS_DOCUMENT_URL));
    define( 'PASS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
    define( 'PASS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

    require_once __DIR__ . '/admin/class-pass-delivery-woocommerce-admin-panel.php';
    require_once __DIR__ . '/public/class-pass-delivery-woocomerce-checkout.php';

    class Pass_Delivery
    {
        /**
         * Constructor for your shipping class
         *
         * @access public
         * @return void
         */
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;
            $this->enabled = "yes";

            new Pass_Delivery_Woocommerce_Admin_Panel();
            new Pass_Delivery_Woocommerce_Checkout();
        }
    }

    new Pass_Delivery();

    // -------------------------------------------------------------------------------- Define Shipping Method
    add_action( 'woocommerce_shipping_init', 'pass_delivery_shipping_method_init' );
    function pass_delivery_shipping_method_init() {
        require_once PASS_PLUGIN_DIR . '/admin/class-pass-delivery-woocommerce-shipping-method.php';
    }

    add_filter( 'woocommerce_shipping_methods', 'add_pass_delivery_shipping_method' );
    function add_pass_delivery_shipping_method( $methods ) {
        $methods[] = 'Pass_Delivery_Woocommerce_Shipping_Method';
        return $methods;
    }
}