<?php
/*
  Plugin Name: Pass WooCommerce Shipping
  Plugin URI: https://pass.qa/developers/
  Description: Pass delivery plugin for wooCommerce shipping
  Version: 1.0
  Author: Mostafa Sharami, Majid Vahidkhoo
  Author URI: https://pass.qa/
  Author URI: http://MostafaSharami.com/
  Author URI: http://Majva.com/
 */

if ( !defined( 'ABSPATH' ) )
    exit;

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
    return;

if(!class_exists('Pass_Delivery')) {
    class Pass_Delivery {

    }

    new Pass_Delivery();
}