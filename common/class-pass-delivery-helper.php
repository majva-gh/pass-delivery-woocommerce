<?php

if (!class_exists('Blue_Pass_Delivery_Helper')) {
    class Blue_Pass_Delivery_Helper
    {
        private function get_wc_settings_url(): bool|string
        {
            return version_compare(WC()->version, '2.1', '>=') ? 'wc-settings' : 'woocommerce_settings';
        }

        public function get_support_url()
        {
            return admin_url( 'admin.php?page=pass-support' );
        }
    }

    $pdHelper = new Blue_Pass_Delivery_Helper();
}
