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
        }
    }
}