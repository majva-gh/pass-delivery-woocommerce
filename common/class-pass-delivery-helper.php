<?php

if (!class_exists('Blue_Pass_Delivery_Helper')) {
    class Blue_Pass_Delivery_Helper
    {
        public function get_support_url()
        {
            return admin_url( 'admin.php?page=pass-support' );
        }
    }

    $pdHelper = new Blue_Pass_Delivery_Helper();
}
