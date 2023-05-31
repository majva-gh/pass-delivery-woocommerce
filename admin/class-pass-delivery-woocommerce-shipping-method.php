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

            $this->init();
        }


        private function init() {
            $this->init_settings();
            $this->init_form_fields();
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
    }
}