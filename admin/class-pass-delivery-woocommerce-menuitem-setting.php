<?php
if (!class_exists('Pass_Delivery_Woocommerce_Menuitem_Setting')) {
    class Pass_Delivery_Woocommerce_Menuitem_Setting
    {
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;

            $this->add_settings_to_admin_menu_item();
        }

        /**
         * @since 1.0.0
         */
        private function add_settings_to_admin_menu_item()
        {
            add_submenu_page('passqa', __('Settings', PASS_TRANSLATE_ID), __('Settings', PASS_TRANSLATE_ID), 'manage_options', 'pass-shipping-settings', function () {
                GLOBAL $passWooShippingAdmin;
                wp_redirect($passWooShippingAdmin->get_settings_url(), 301);
                exit;
            });

        }
    }
}