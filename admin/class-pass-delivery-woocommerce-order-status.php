<?php
if (!class_exists('Pass_Delivery_Woocommerce_Order_Status')) {
    class Pass_Delivery_Woocommerce_Order_Status
    {

        public function __construct()
        {
        }

        // Register New Order Statuses
        function filter_wc_register_post_statuses()
        {
            register_post_status('wc-shipped-with-pass', array(
                'label'                     => _x('Shipped With Pass', 'Order status', 'default'),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Shipped With Pass (%s)', 'Shipped With Pass (%s)')
            ));
        }
    }
}
