<?php

if (!class_exists('Pass_Order_Library')) {
    class Pass_Order_Library
    {
        private array $curlOptions;

        public function __construct($token)
        {
            $this->curlOptions = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_FAILONERROR => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer ". $token,//$token is your token created in dashboard.
                    "Content-Type: application/json; charset=utf-8",
                    "Accept: application/json"
                ]
            ];
        }
    }
}
