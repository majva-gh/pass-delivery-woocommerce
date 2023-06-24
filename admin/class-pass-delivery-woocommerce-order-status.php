<?php
if (!class_exists('Pass_Delivery_Woocommerce_Order_Status')) {
    class Pass_Delivery_Woocommerce_Order_Status
    {

        public function __construct()
        {
            add_filter( 'init', array($this,'filter_wc_register_post_statuses') );
            add_filter( 'wc_order_statuses', array($this,'filter_woocommerce_order_statuses') );
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

        function filter_woocommerce_order_statuses( $order_statuses ) {

            $new_order_statuses = array();
        
            // add new order status after processing
            foreach ( $order_statuses as $key => $status ) {
                $new_order_statuses[ $key ] = $status;
        
                if ( 'wc-processing' === $key ) {
                    $new_order_statuses['wc-shipped-with-pass'] = _x('Shipped With Pass Delivery', 'Order status', 'woocommerce');
        
                }
            }
        
            return $new_order_statuses;
        }
    }
}
