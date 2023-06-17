<?php
if (!class_exists('Pass_Delivery_Woocommerce_Admin_Panel')) {
    class Pass_Delivery_Woocommerce_Admin_Panel
    {
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;

            add_action('admin_menu', array($this, 'admin_menu_items'));
        }

        /**
         * @since 1.0.0
         */
        public function admin_menu_items()
        {
            $mainTitle = 'Pass delivery';

            add_menu_page($mainTitle, $mainTitle, 'manage_options', 'passqa', null, plugins_url('pass-delivery-woocommerce/admin/assets/img/icon.png'), '55.6');

            $this->manage_settings();
            $this->manage_support();

        }

        private function manage_settings()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-setting.php';
            new Pass_Delivery_Woocommerce_Menuitem_Setting();
        }

        private function manage_support()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-support.php';
            new Pass_Delivery_Woocommerce_Menuitem_Support();
        }

        /**
         * @return string
         * @since  1.0.0
         */
        public function get_settings_url(): string
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
    }
}