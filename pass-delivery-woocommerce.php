<?php
/**
 * @link            https://pass.qa
 * @since           1.0.0
 * @package         Pass_WooCommerce_Shipping
 *
 * @wordpress-plugin
 * Plugin Name:     Pass WooCommerce Shipping
 * Plugin URI:      https://pass.qa/developers/
 * Description:     Pass delivery plugin for wooCommerce shipping
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
    require_once __DIR__ . '/admin/class-pass-delivery-woocommerce-admin-panel.php';

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
            $this->id = 'pass_woocommerce_shipping';
            $this->title = __('Pass WooCommerce Shipping');
            $this->method_description = __('Pass.qa delivery plugin for WooCommerce shipping');
            $this->enabled = "yes";
            new Pass_Delivery_Woocommerce_Admin_Panel();
        }
    }

    new Pass_Delivery();
}