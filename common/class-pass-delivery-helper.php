<?php

if (!class_exists('Blue_Pass_Delivery_Helper')) {
    class Blue_Pass_Delivery_Helper
    {
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;
        }

        public function get_settings_url(): string
        {
            return admin_url('admin.php?page=' . $this->get_wc_settings_url() . '&tab=shipping&section=' . PASS_METHOD_ID);
        }

        private function get_wc_settings_url(): bool|string
        {
            return version_compare(WC()->version, '2.1', '>=') ? 'wc-settings' : 'woocommerce_settings';
        }

        public function get_support_url()
        {
            return admin_url( 'admin.php?page=pass-support' );
        }

        public function get_setting_key($key = null, $default = '') {
            $value = $default;
            $setting = get_option('woocommerce_pass_woocommerce_shipping_settings');
            if($setting) {
                if($key) {
                    $value = $setting[$key] ? $setting[$key] : $default;
                } else {
                    $value = $setting ? $setting : [];
                }
            }
            return $value;
        }
    }

    $pdHelper = new Blue_Pass_Delivery_Helper();
}
