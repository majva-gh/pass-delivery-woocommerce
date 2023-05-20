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
            $this->add_section_to_woo_setting_shipping_tab();
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
        private function add_section_to_woo_setting_shipping_tab() {
            add_filter( 'woocommerce_get_sections_shipping', array($this, 'add_section_to_shipping_tab') );
            add_filter( 'woocommerce_get_settings_shipping', array($this, 'add_section_fields'), 10, 2 );
        }

        public function add_section_to_shipping_tab( $sections ) {
            $sections[$this->id] = __( 'Pass Delivery', PASS_TRANSLATE_ID );
            return $sections;
        }

        function add_section_fields( $settings, $current_section ) {
            /**
             * Check the current section is what we want
             **/
            if ( $current_section !== $this->id ) {
                return $settings;
            }

            $settings_base = array(
                array(
                    'name' => $this->method_title,
                    'type' => 'title',
                    'desc' => $this->method_description,
                    'id'   => $this->id . '_title'
                ),
                array(
                    'name'     => __( 'Enable/Disable', PASS_TRANSLATE_ID ),
                    'desc_tip' => __( 'Show or hide pass delivery shipping method', PASS_TRANSLATE_ID ),
                    'id'       => $this->id . '_enable_disable',
                    'type'     => 'checkbox',
                    'css'      => 'min-width:300px;',
                    'desc'     => __( 'Enable Pass Delivery shipping', PASS_TRANSLATE_ID ),
                ),
                array(
                    'title'       => __( 'API Key', PASS_TRANSLATE_ID ),
                    'type'        => 'text',
                    'default'     => '',
                    'id'       => $this->id . '_api_key',
                    'desc' => PASS_GET_KEY_HELP,
                    'custom_attributes' => array(
                        'required' => 'required'
                    )
                )
            );

            $settings_extend = array();
            if(false) {
                $settings_extend = array(
                    array(
                        'name'     => __( 'Enable/Disable', PASS_TRANSLATE_ID ),
                    )
                );
            }

            return array_merge($settings_base, $settings_extend);
        }
        //</editor-fold>
    }
}