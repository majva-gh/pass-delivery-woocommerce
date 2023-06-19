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

        public function price($priceData)
        {
            return $this->send_request($priceData, '/price/calc', 'POST');
        }

        public function list()
        {
            return $this->send_request();
        }

        private function send_request($data = [], $attachUrl = '', $method = 'GET')
        {
            $curl = curl_init();

            $this->curlOptions[CURLOPT_URL] = "https://api.pass.qa/business/v1/orders{$attachUrl}";
            $this->curlOptions[CURLOPT_CUSTOMREQUEST] = $method;

            if(!empty($data)) {
                $this->curlOptions[CURLOPT_POSTFIELDS] = json_encode($data);
            }

            curl_setopt_array($curl, $this->curlOptions);


            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);


            if ($err) {
                return [];
            }

            $response = json_decode($response, true);
            if($response['status'] !== 'success') {
                return [];
            }

            return $response['data'];
        }
    }
}
