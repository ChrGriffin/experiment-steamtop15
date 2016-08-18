<?php
    class Steam_api {

        private $api_key = '';
        private $user_id = '';
        private $format = 'json';

/**
 * Basic constructor function.
 */
        public function __construct()
        {

        }

/**
 * Set the API key to access the API.
 */
        public function setAPIKey($k = '')
        {
            $this->api_key = $k;
        }

/**
 * Set the user ID we want to query.
 */
        public function setUserID($u = '')
        {
            $this->user_id = $u;
        }

/**
 * Set the format the API should return data in.
 */
        public function setFormat($f = 'json')
        {
            $this->format = $f;
        }

/**
 * This function makes the API request to Steam.
 */
        public function makeRequest()
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=' . $this->api_key . '&steamid=' . $this->user_id . '&format=' . $this->format . '&include_appinfo=1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                )
            ));

            $response = curl_exec($curl);
            // $err = curl_error($curl);
            curl_close($curl);

            if($this->format == 'json'){
                return json_decode($response);
            } else {
                return $response;
            }
        }

/**
 * This function sorts the API results by their time played.
 */
        public function sortAPIResults($object = NULL, $key = 'playtime')
        {
            if($object === NULL){
                return FALSE;
            }

            if(!isset($object->response)){
                return FALSE;
            }

            if(!isset($object->response->games)){
                return FALSE;
            }

            if($key == 'playtime'){
                usort($object->response->games, array($this, '_usort_by_playtime_forever'));
                return $object;
            }
        }

/**
 * This function is called via usort to sort the API results by their time played.
 */
        private static function _usort_by_playtime_forever($a, $b)
        {
            return $b->playtime_forever - $a->playtime_forever;
        }

    }
?>