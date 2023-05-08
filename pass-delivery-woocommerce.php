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

if ( !defined( 'ABSPATH' ) )
    exit;

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
    return;

if(!class_exists('Pass_Delivery')) {
    class Pass_Delivery {
        public function __construct()
        {
            add_action( 'admin_menu', array($this, 'admin_menu_items') );
        }

        /**
         * @since 1.0.0
         */
        public function admin_menu_items() {
            $mainTitle = 'Pass delivery';

            add_menu_page( $mainTitle, $mainTitle, 'manage_options', 'passqa', null, plugins_url( 'pass-delivery-woocommerce/admin/assets/img/icon.png'), '55.7' );

        }
    }

    new Pass_Delivery();
}