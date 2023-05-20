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
            add_filter( 'woocommerce_get_sections_shipping', array($this, 'add_section_to_woo_setting_shipping_tab') );
        }

        //<editor-fold desc="=============================================== Settings submenu ===============================================">
        /**
         * @since 1.0.0
         */
        private function add_settings_to_admin_menu_item()
        {
            add_submenu_page('passqa', __('Settings', PASS_TRANSLATE_ID), __('Settings', PASS_TRANSLATE_ID), 'manage_options', 'pass-shipping-settings', function () {
                wp_redirect($this->get_settings_url(), 301);
                exit;
            });

        }

        /**
         * @return string
         * @since  1.0.0
         */
        private function get_settings_url(): string
        {

            return admin_url('admin.php?page=' . $this->get_wc_settings_url() . '&tab=shipping&section=' . PASS_METHOD_ID);

        }

        /**
         * @return boolean
         * @since  1.0.0
         */
        private function get_wc_settings_url(): bool|string
        {

            return version_compare(WC()->version, '2.1', '>=') ? 'wc-settings' : 'woocommerce_settings';

        }
        //</editor-fold>

        //<editor-fold desc="=============================================== Settings section ===============================================">
        public function add_section_to_woo_setting_shipping_tab( $sections ) {
            $sections[$this->id] = __( 'Pass Delivery', 'text-domain' );
            return $sections;
        }
        //</editor-fold>
    }
}