<?php
if (!class_exists('Pass_Delivery_Woocommerce_Order_Status')) {
    class Pass_Delivery_Woocommerce_Order_Status
    {

        public function __construct()
        {
            add_filter( 'init', array($this,'filter_wc_register_post_statuses') );
            add_filter( 'wc_order_statuses', array($this,'filter_woocommerce_order_statuses') );
            add_filter('bulk_actions-edit-shop_order', array($this,'status_orders_bulk_actions'));
            add_filter('handle_bulk_actions-edit-shop_order', array($this,'status_bulk_action_edit_shop_order',), 10, 3);
        }

        // Register New Order Statuses
        function filter_wc_register_post_statuses()
        {
            register_post_status('wc-shipped-with-pass', array(
                'label'                     => _x('Shipped with pass delivery', 'Order status', 'default'),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Shipped with pass delivey (%s)', 'Shipped with pass delivey (%s)')
            ));
        }

        function filter_woocommerce_order_statuses( $order_statuses ) {

            $new_order_statuses = array();
        
            // add new order status after processing
            foreach ( $order_statuses as $key => $status ) {
                $new_order_statuses[ $key ] = $status;
        
                if ( 'wc-processing' === $key ) {
                    $new_order_statuses['wc-shipped-with-pass'] = _x('Shipped with pass delivery', 'Order status', 'woocommerce');
        
                }
            }
        
            return $new_order_statuses;
        }

        // Add a bulk action to Orders bulk actions dropdown


function status_orders_bulk_actions($bulk_actions) {
    $bulk_actions['wc-shipped-with-pass'] = __('Change status to shipped with pass delivery');
    return $bulk_actions;
}

// Process the bulk action from selected orders


function status_bulk_action_edit_shop_order($redirect_to, $action, $post_ids) {
    if ($action === 'wc-shipped-with-pass') {

        foreach ($post_ids as $post_id) {
            $order = wc_get_order($post_id);
            $order->update_status('wc-shipped-with-pass');
        }
    }
    return $redirect_to;
}
    }
}
