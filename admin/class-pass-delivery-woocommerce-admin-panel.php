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
            add_filter('plugin_action_links_' . PASS_PLUGIN_BASENAME, array($this, 'action_links'));
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
         * @since  1.0.0
         * @param  array $links
         * @return array
         */
        public function action_links( $links ) {

            $plugin_links[] = '<a href="' . $this->get_settings_url() . '">' . __('Settings', PASS_TRANSLATE_ID) . '</a>';
            $plugin_links[] = '<a href="' . $this->get_support_url() . '">' . __('Support', PASS_TRANSLATE_ID) . '</a>';
            $plugin_links[] = '<a href="https://passdelivery.readme.io/reference/getting-started">Documentation</a>';

            return array_merge( $plugin_links, $links );

        }
    }
}