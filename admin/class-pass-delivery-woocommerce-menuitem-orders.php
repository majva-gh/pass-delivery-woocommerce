<?php
if (!class_exists('Pass_Delivery_Woocommerce_Menuitem_Orders')) {
    class Pass_Delivery_Woocommerce_Menuitem_Orders
    {
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;

            $this->add_support_to_admin_menu_item();
        }

        private function add_support_to_admin_menu_item()
        {
            add_submenu_page('passqa', __('Orders', PASS_TRANSLATE_ID), __('Orders', PASS_TRANSLATE_ID), 'manage_options', 'pass-orders', function () {
                GLOBAL $pdHelper;
                echo $pdHelper->template_or_error_for_not_found_user($this->load_support_template());
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
    }
}