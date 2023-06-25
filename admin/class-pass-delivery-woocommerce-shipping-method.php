<?php
if (!class_exists('Pass_Delivery_Woocommerce_Shipping_Method')) {
    class Pass_Delivery_Woocommerce_Shipping_Method extends WC_Shipping_Method
    {
        /**
         * Constructor for your shipping class
         *
         * @access public
         * @return void
         */
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;

            $this->enabled            = "yes";
            $this->title              = PASS_METHOD_TITLE;

            /*$this->supports = array_merge($this->supports, array(
                'shipping-zones',
                'instance-settings',
                'instance-settings-modal',
            ));*/

            $this->init();
        }

        private function init() {
            $this->init_settings();
            $this->init_form_fields();
            $this->init_actions();
        }

        function init_form_fields() {
            $settings_base = array(
                'enabled' => array(
                    'title'     => __( 'Enable/Disable', PASS_TRANSLATE_ID ),
                    'description' => __( 'Show or hide pass delivery shipping method', PASS_TRANSLATE_ID ),
                    'id'       => $this->id . '_enable_disable',
                    'type'     => 'checkbox',
                    'label'     => __( 'Enable Pass Delivery shipping', PASS_TRANSLATE_ID ),
                    'default' => 'no',
                ),
                'api_key' => array(
                    'title'       => __( 'API Key', PASS_TRANSLATE_ID ),
                    'type'        => 'text',
                    'default'     => '',
                    'id'       => $this->id . '_api_key',
                    'description' => PASS_GET_KEY_HELP,
                    'custom_attributes' => array(
                        'required' => 'required',
                        'minlength' => '900',
                    )
                )
            );

            $settings_extend = (strlen($this->settings['api_key']) < 900) ? array() : array(
                'store_name' => array(
                    'title'       => __( 'Store Name', PASS_TRANSLATE_ID ),
                    'type'        => 'text',
                    'default'     => '',
                    'id'       => $this->id . '_store_name',
                    'description' => sprintf( __( 'Store name use for sender name in %s order', PASS_TRANSLATE_ID ), PASS_METHOD_TITLE),
                    'custom_attributes' => array(
                        'required' => 'required'
                    )
                ),
                'store_phone' => array(
                    'title'       => __( 'Store Phone', PASS_TRANSLATE_ID ),
                    'type'        => 'text',
                    'default'     => '',
                    'id'       => $this->id . '_store_phone',
                    'description' => sprintf( __( 'Store phone use for sender phone in %s order', PASS_TRANSLATE_ID ), PASS_METHOD_TITLE),
                    'custom_attributes' => array(
                        'required' => 'required'
                    )
                ),
                'store_zone_number' => array(
                    'title'       => __( 'Zone Number', PASS_TRANSLATE_ID ),
                    'type'        => 'number',
                    'default'     => '',
                    'id'       => $this->id . '_zone_number',
                    'description' => __( 'Zone Number (Blue Plate / Qatar national address)', PASS_TRANSLATE_ID ),
                    'custom_attributes' => array(
                        'required' => 'required',
                        'min' => '1',
                        'max' => '999',
                    )
                ),
                'store_street_number' => array(
                    'title'       => __( 'Street Number', PASS_TRANSLATE_ID ),
                    'type'        => 'number',
                    'default'     => '',
                    'id'       => $this->id . '_street_number',
                    'description' => __( 'Street Number (Blue Plate / Qatar national address)', PASS_TRANSLATE_ID ),
                    'custom_attributes' => array(
                        'required' => 'required',
                        'min' => '1',
                        'max' => '999',
                    )
                ),
                'store_building_number' => array(
                    'title'       => __( 'Building Number', PASS_TRANSLATE_ID ),
                    'type'        => 'number',
                    'default'     => '',
                    'id'       => $this->id . '_building_number',
                    'description' => __( 'Building Number (Blue Plate / Qatar national address)', PASS_TRANSLATE_ID ),
                    'custom_attributes' => array(
                        'required' => 'required',
                        'min' => '1',
                        'max' => '999',
                    )
                ),
            );

            if(!empty($settings_extend) && isset($this->settings['address'])) {
                $address = array(
                    'address' => array(
                        'title'       => __( 'Address', PASS_TRANSLATE_ID ),
                        'type'        => 'text',
                        'default'     => $this->settings['address'],
                        'id'       => $this->id . '_address',
                        'css' => 'direction: rtl; text-align: right; padding: 5px 10px; border: 0; background-color: #dddde1;',
                        'custom_attributes' => array(
                            'readonly' => 'readonly',
                            'style' => 'direction: rtl; text-align: right;',
                        ))
                );
                $settings_extend = array_merge($settings_extend, $address);
            }

            $form_fields = array_merge($settings_base, $settings_extend);

            $this->form_fields = $form_fields;
        }

        function init_actions() {
            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

            add_action( 'woocommerce_admin_billing_fields',
                array( $this,
                    'action_woocommerce_admin_order_fields' ),
                10, 1 );
            add_action( 'woocommerce_admin_shipping_fields',
                array( $this,
                    'action_woocommerce_admin_order_fields' ),
                10, 1 );

            add_action('woocommerce_checkout_order_created', array( $this, 'action_woocommerce_checkout_order_created' ));
        }

        /**
         * Get setting form fields for instances of this shipping method within zones.
         *
         * @return array
         */
        public function get_instance_form_fields() {
            return parent::get_instance_form_fields();
        }

        /**
         * calculate_shipping function.
         *
         * @access public
         * @param array $package
         * @return void
         */
        public function calculate_shipping( $package = array() ) {
            $rate = array(
                'id' => $this->id . '_' . $this->instance_id,
                'label' => $this->title,
                'cost' => 'Not Calculated',
                'cost_symbol' => 'undefined',
                'calc_tax' => 'per_item'
            );

            $blue_plate = $this->fetch_blue_plate($_POST);
            require_once(PASS_PLUGIN_DIR . '/common/class-blue-plate-library.php');
            $blue_plate_library = new Blue_Plate_Library();
            $destination = $blue_plate_library->get_coordinates_from_blue_plate(
                $blue_plate['zone_number'],
                $blue_plate['street_number'],
                $blue_plate['building_number']
            );

            if(!empty($destination)) {

                $this->init_settings();
                $priceData = [
                    "pickup" => [
                        "lat" => $this->settings['lat'],
                        "long" => $this->settings['lng']
                    ],
                    "dropoffs" => [
                        [
                            "lat" => $destination['lat'],
                            "long" => $destination['lng']
                        ]
                    ]
                ];
                require_once(PASS_PLUGIN_DIR . '/common/class-pass-order-library.php');
                $order = new Pass_Order_Library($this->settings['api_key']);
                $response = $order->price($priceData);
                if (!empty($response)) {
                    $rate['cost'] = $response['price'];
                    $rate['cost_symbol'] = $response['symbol'];                
                }

            }

            // Register the rate
            $this->add_rate( $rate );
        }

        private function fetch_blue_plate($data) {
            if(isset($data['post_data'])) {
                $post_data = explode('&', $data['post_data']);
                $data = [];
                foreach ($post_data as $key => $value) {
                    $value = explode('=', $value);
                    $data[$value[0]] = $value[1];
                }
            }

            return isset($data['ship_to_different_address']) ?
                ['zone_number' => $data['shipping_zone_number'],
                    'street_number' => $data['shipping_street_number'],
                    'building_number' => $data['shipping_building_number']] :
                ['zone_number' => $data['billing_zone_number'],
                    'street_number' => $data['billing_street_number'],
                    'building_number' => $data['billing_building_number']];
        }

        /**
         * Processes and saves global shipping method options in the admin area.
         *
         * This method is usually attached to woocommerce_update_options_x hooks.
         *
         * @since 2.6.0
         * @return bool was anything saved?
         */
        public function process_admin_options()
        {
            $this->init_settings();
            $data = $this->get_post_data();

            if($this->is_new_location($this->settings, $data)){
                require_once(PASS_PLUGIN_DIR . '/common/class-blue-plate-library.php');
                $blue_plate_library = new Blue_Plate_Library();
                $address = $blue_plate_library->get_address(
                    $data['store_zone_number'],
                    $data['store_street_number'],
                    $data['store_building_number']
                );

                if(empty($address)){
                    return false;
                }

                $data = array_merge($data, $address);
            }

            $update = update_option(
                $this->get_option_key(),
                apply_filters(
                    'woocommerce_settings_api_sanitized_fields_' . $this->id,
                    array_merge($this->settings, $data) ),
                'yes'
            );

            if($update) {
                echo '<script>window.location = window.location;</script>';
            }

            return $update;
        }

        public function get_post_data(): array
        {
            $values = array();
            $fields = $this->get_form_fields();

            foreach ( $fields as $key => $field ) {
                if ( 'title' != $this->get_field_type( $field ) ) {
                    try {
                        $values[ $key ] = $this->get_field_value( $key, $field, $_POST );
                    } catch ( Exception $e ) {
                        $this->add_error( $e->getMessage() );
                    }
                }
            }

            return $values;
        }

        private function is_new_location($last_values, $new_values): bool
        {
            $list = ['store_zone_number', 'store_street_number', 'store_building_number'];
            foreach ($list as $key) {
                if ($last_values[$key] ?? '' != $new_values[$key] ?? '') {
                    return true;
                }
            }

            return false;
        }

        // Display on the order edit page (backend)
        function action_woocommerce_admin_order_fields( $fields ) {


            $fields_name = [
                'zone_number' => 'Zone Number',
                'street_number' => 'Street Number',
                'building_number' => 'Building Number',
            ];

            foreach($fields_name as $filed => $title) {
                $fields[$filed] = array(
                    'label'     => __($title, PASS_TRANSLATE_ID),
                    'placeholder'   => _x($title, 'placeholder', PASS_TRANSLATE_ID),
                    'required'  => false,
                    'class'     => array('form-row-wide', 'blueplate'),
                    'clear'     => true,
                    'type'         => 'number',
                    'validate'          => array('required'),
                    'custom_attributes' => array('min' => 1, 'max' => 999)
                );
            }

            return $fields;
        }

        function action_woocommerce_checkout_order_created ( $order ) {
            $meta = get_post_meta($order->id);

            if(!isset($meta['pass_delivery_order_id'])) {
                $this->init_settings();


                require_once(PASS_PLUGIN_DIR . '/common/class-blue-plate-library.php');
                $blue_plate_library = new Blue_Plate_Library();
                $address = $blue_plate_library->get_address(
                    $meta['_shipping_zone_number'][0],
                    $meta['_shipping_street_number'][0],
                    $meta['_shipping_building_number'][0]
                );

                $orderData = [
                    "addresses" => [
                        "pickup" => [
                            "lat" => $this->settings['lat'],
                            "long" => $this->settings['lng'],
                            "name" => $this->settings['store_name'],
                            "phone" => $this->settings['store_phone'],
                            "address" => $this->settings['address'],
                        ],
                        "dropoffs" => [
                            [
                                "lat" => $address['lat'],
                                "long" => $address['lng'],
                                "name" => $meta['_shipping_first_name'][0] . ' ' . $meta['_shipping_last_name'][0],
                                "phone" => $meta['_billing_phone'][0],
                                "address" => $address['address']
                            ]
                        ]
                    ]
                ];

                require_once(PASS_PLUGIN_DIR . '/common/class-pass-order-library.php');
                $passOrder = new Pass_Order_Library($this->settings['api_key']);
                $response = $passOrder->store($orderData);
                if (empty($response)) {
                    $this->add_error(__('Can not crate the order in shipping method', PASS_TRANSLATE_ID));
                    die();
                }


                update_post_meta($order->id, '_shipping_address_latitude', $address['lat']);
                update_post_meta($order->id, '_shipping_address_longitude', $address['lng']);
                add_post_meta($order->id, 'pass_delivery_order_id', $response['order_id']);
            }
        }
    }
}