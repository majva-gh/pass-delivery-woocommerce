<?php
if(!class_exists('Pass_Delivery_Woocommerce_Admin_Panel')) {
    class Pass_Delivery_Woocommerce_Admin_Panel {
        public function __construct()
        {
            add_action( 'admin_menu', array($this, 'admin_menu_items') );
        }

        /**
         * @since 1.0.0
         */
        public function admin_menu_items() {
            $mainTitle = 'Pass delivery';

            add_menu_page( $mainTitle, $mainTitle, 'manage_options', 'passqa', null, plugins_url( 'pass-delivery-woocommerce/admin/assets/img/icon.png'), '55.6' );
        }
    }
}