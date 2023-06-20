<?php

if (!class_exists('Blue_Plate_Library')) {
    class Blue_Plate_Library
    {
        public function get_address($zone_number, $street_number, $building_number)
        {
            $coordinates = $this->get_coordinates_from_blue_plate($zone_number, $street_number, $building_number);

            if (count($coordinates)) {
                return $this->get_address_from_coordinates($coordinates['lat'], $coordinates['lng']);
            }

            return [];
        }

        public function get_coordinates_from_blue_plate($zone_number, $street_number, $building_number)
        {
            $url = "https://services.gisqatar.org.qa/server/rest/services/Vector/QARS_wgs84/MapServer/0/query?";
            $url .= "where=zone_no={$zone_number}+and+street_no={$street_number}and+building_no={$building_number}&f=json";
            $response = $this->send_request($url);

            if (isset($response['features']) && count($response['features'])) {
                if (isset($response['features'][0]['geometry']['x'])) {
                    return [
                        'lat' => $response['features'][0]['geometry']['y'],
                        'lng' => $response['features'][0]['geometry']['x']
                    ];
                }
            }

            return [];
        }

        private function get_address_from_coordinates($lat, $lng)
        {
            $url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?";
            $url .= "f=pjson&featureTypes=&location={$lng},{$lat}";
            $response = $this->send_request($url);

            if (count($response)) {
                if (!empty($response['address']['CountryCode']) && ($response['address']['CountryCode'] === 'QAT')) {
                    return [
                        'address' => $response['address']['LongLabel'],
                        'lat'     => $lat,
                        'lng'     => $lng,
                    ];
                }
            }

            return [];
        }

        private function send_request($url)
        {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_FAILONERROR => true,
            ]);


            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);


            if ($err) {
                return [];
            } else {
                return json_decode($response, true);
            }
        }
    }
}
