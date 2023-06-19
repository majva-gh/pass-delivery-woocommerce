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

        private function load_support_template($data)
        {
            $msg = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
                
                    <div class="container">
                        <div class="row my-5">
                            <div class="col-12 mb-3">
                                <h3>Pass delivery orders list</h3>
                                <hr />
                            </div>
                
                            <div class="col-12">
                                <table id="myTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Receiver name</th>
                                            <th>Receiver phone</th>
                                            <th>Receiver address</th>
                                            <th>price</th>
                                            <th>status</th>
                                            <th>date</th>
                                            <th>time</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

            $counter = 1;
            foreach ($data as $row) {
                $date = explode(' ', $row['date']);
                $msg .= "<tr>
                        <td>{$counter}</td>
                        <td>{$row['dropoffs'][0]['name']}</td>
                        <td>
                            <a href='tel:{$row['dropoffs'][0]['phone']}'>{$row['dropoffs'][0]['phone']}</a>
                        </td>
                        <td>{$row['dropoffs'][0]['address']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['order_status']}</td>
                        <td>{$date[0]}</td>
                        <td>{$date[1]}</td>
                    </tr>";
                $counter++;
            }

            $msg.= '
                                    </tbody>
                                </table>
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