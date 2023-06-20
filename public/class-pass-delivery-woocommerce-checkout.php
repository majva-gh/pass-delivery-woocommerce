<?php
if (!class_exists('Pass_Delivery_Woocommerce_Checkout')) {
    class Pass_Delivery_Woocommerce_Checkout
    {

        public function __construct()
        {
            add_filter('woocommerce_get_country_locale', array($this, 'optional_postcode_in_qatar'));

            add_filter('woocommerce_default_address_fields', array($this, 'custom_override_checkout_fields'));

            add_action('woocommerce_after_checkout_validation', array($this, 'action_woocommerce_after_checkout_validation'), 10, 2);

            add_action('woocommerce_after_order_notes', array($this, 'action_woocommerce_after_order_notes'), 10, 1);
        }

        function optional_postcode_in_qatar($locales)
        {
            $locales['QA']['postcode']['required'] = false;
            return $locales;
        }

        function custom_override_checkout_fields($fields)
        {
            $fields['zone_number'] = array(
                'label'     => __('Zone number', 'woocommerce'),
                'placeholder'   => _x('Zone number', 'placeholder', 'woocommerce'),
                'required'  => false,
                'class'     => array('form-row-wide', 'blueplate'),
                'clear'     => true,
                'type'         => 'number',
                'validate'          => array('required'),
                'custom_attributes' => array('min' => 1, 'max' => 999)
            );

            $fields['street_number'] = array(
                'label'     => __('Street number', 'woocommerce'),
                'placeholder'   => _x('Street number', 'placeholder', 'woocommerce'),
                'required'  => false,
                'class'     => array('form-row-wide', 'blueplate'),
                'clear'     => true,
                'type'         => 'number',
                'validate'          => array('required'),
                'custom_attributes' => array('min' => 1, 'max' => 999)
            );

            $fields['building_number'] = array(
                'label'     => __('Bulding number', 'woocommerce'),
                'placeholder'   => _x('Building number', 'placeholder', 'woocommerce'),
                'required'  => false,
                'class'     => array('form-row-wide', 'blueplate'),
                'clear'     => true,
                'type'         => 'number',
                'validate'          => array('required'),
                'custom_attributes' => array('min' => 1, 'max' => 999)
            );

            return $fields;
        }

        private function validate_billing_blue_plate($data, $error)
        {
            if (empty($data['billing_zone_number'])) {
                $error->add('validation', '<strong>Billing Zone Number </strong>is a required field.');
            }
            if (empty($data['billing_street_number'])) {
                $error->add('validation', '<strong>Billing Street Number </strong>is a required field.');
            }
            if (empty($data['billing_building_number'])) {
                $error->add('validation', '<strong>Billing Building Number </strong>is a required field.');
            }
        }

        private function validate_shipping_blue_plate($data, $error)
        {
            if (empty($data['shipping_zone_number'])) {
                $error->add('validation', '<strong>Shipping Zone Number </strong>is a required field.');
            }
            if (empty($data['shipping_street_number'])) {
                $error->add('validation', '<strong>Shipping Street Number </strong>is a required field.');
            }
            if (empty($data['shipping_building_number'])) {
                $error->add('validation', '<strong>Shipping Building Number </strong>is a required field.');
            }
        }

        function action_woocommerce_after_checkout_validation($data, $error)
        {
            if ($data['billing_country'] == 'QA') {
                $this->validate_billing_blue_plate($data, $error);
            }
            if ($data['shipping_country'] == 'QA' && $_POST['ship_to_different_address']) {
                $this->validate_shipping_blue_plate($data, $error);
            }
        }

        function action_woocommerce_after_order_notes($checkout)
        {

?>
            <script>
                (function($) {
                    $(document).ready(function() {

                        billing_required_or_optional(); //this calls it on load
                        shipping_required_or_optional(); //this calls it on load

                        $('#billing_country').change(billing_required_or_optional);
                        $('#shipping_country').change(shipping_required_or_optional);

                        function billing_required_or_optional() {

                            if ($('#billing_country').val() == 'QA') {
                                $('p[id^=billing_].blueplate :input').
                                each((index, element) => {
                                    $("#" + element.id).parent().parent().show();
                                    $("#" + element.id).prop('required', true);
                                    $('label[for="' + element.id + '"]').append('<abbr class="required" title="required">*</abbr>')
                                    $('label[for="' + element.id + '"] .optional').remove();

                                });

                            } else {
                                $('p[id^=billing_].blueplate :input').
                                each((index, element) => {
                                    $("#" + element.id).parent().parent().hide();
                                    $("#" + element.id).removeProp('required');
                                    $('label[for="' + element.id + '"] .required').remove();

                                    // Avoid append this multiple times
                                    if ($('label[for="' + element.id + '"] .optional').length == 0) {
                                        $('label[for="' + element.id + '"]').append('<span class="optional">(optional)</span>');
                                    }

                                });
                            }
                        };

                        function shipping_required_or_optional() {
                            if ($('#shipping_country').val() == 'QA') {
                                $('p[id^=shipping_].blueplate :input').
                                each((index, element) => {
                                    console.log(element);
                                    $("#" + element.id).parent().parent().show();
                                    $("#" + element.id).prop('required', true);
                                    $('label[for="' + element.id + '"]').append('<abbr class="required" title="required">*</abbr>')
                                    $('label[for="' + element.id + '"] .optional').remove();

                                });

                            } else {
                                $('p[id^=shipping_].blueplate :input').
                                each((index, element) => {
                                    $("#" + element.id).parent().parent().hide();
                                    $("#" + element.id).removeProp('required');
                                    $('label[for="' + element.id + '"] .required').remove();

                                    // Avoid append this multiple times
                                    if ($('label[for="' + element.id + '"] .optional').length == 0) {
                                        $('label[for="' + element.id + '"]').append('<span class="optional">(optional)</span>');
                                    }

                                });
                            }
                        }
                    });
                })(jQuery);
            </script>
<?php
        }
    }
}
