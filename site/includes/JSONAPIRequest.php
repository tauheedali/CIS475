<?php

class JSONAPIRequest
{
    private static $curl;
    
    public function __construct()
    {
    }
    
    public static function get($url)
    {
        try {
            $curl = curl_init();
            //CURL code generated by Postman
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => TRUE,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    private static function init()
    {
        //        self::$curl =
    }
}