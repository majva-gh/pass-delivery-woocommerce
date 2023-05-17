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
            $this->add_support_submenu();

        }

        private function manage_settings()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-setting.php';
            new Pass_Delivery_Woocommerce_Menuitem_Setting();
        }

        //<editor-fold desc="=============================================== Settings submenu ===============================================">
        private function add_support_submenu()
        {
            add_submenu_page('passqa', __('Support', PASS_TRANSLATE_ID), __('Support', PASS_TRANSLATE_ID), 'manage_options', 'pass-support', function () {
                /*echo get_local_template_part('pass-woocommerce-shipping-admin-support-page', array(
                    'log_url' => $this->helpers->get_log_url(),
                    'chat_url' => $this->helpers->get_chat_url(),
                    'dev_email' => $this->helpers->get_config('devEmail'),
                    'support_tel' => $this->helpers->get_support_tel(),
                ));*/
                echo $this->load_support_template();
            });
        }

        private function load_support_template(): string
        {
            return '
                        <style>
                            .pass-shipping-wc-card-box{
                                  margin-top: 30vh;
                            }
                            .pass-shipping-wc-card {
                                  background-color: beige;
                                  width: fit-content;
                                  padding: 20px 40px;
                                  border-radius: 9px;
                                  box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
                            }
                        </style>
                        <div class="pass-shipping-wc-card-box">
                            <div class="pass-shipping-wc-card">
                                <h3>Hello, this is <a href="https://pass.qa" target="_blank">Pass</a> support</h3>
                            </div>
                        </div>';
        }
        //</editor-fold>
    }
}