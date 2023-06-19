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
            add_submenu_page(Pass_Delivery_Woocommerce_Admin_Panel::$parent_slug, __('Orders', PASS_TRANSLATE_ID), __('Orders', PASS_TRANSLATE_ID), 'manage_options', 'pass-orders', function () {
                GLOBAL $pdHelper;
                if(!$pdHelper->validate_user()) {
                    echo $pdHelper->error_for_not_found_user();
                    return;
                }


                $api_key = $pdHelper->get_setting_key('api_key');
                require_once(PASS_PLUGIN_DIR . '/common/class-pass-order-library.php');
                $order = new Pass_Order_Library($api_key);
                $response = $order->list();

                echo $this->load_support_template($response);
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
                        </div>
                    </div>
                
                
                    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
                
                    <script>
                        $(document).ready( function () {
                            $("#myTable").DataTable();
                            $("#myTable_filter").addClass("d-none");
                        } );
                    </script>';
            return $msg;
        }
    }
}