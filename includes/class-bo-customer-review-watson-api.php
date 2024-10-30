<?php

/**
 * API calls to Watson service
 *
 * @link       https://blue-origami-digital.com/
 * @since      1.0.0
 *
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 */

/**

 *
 * @since      1.0.0
 * @package    BO_WC_Customer_Reviews_Watson
 * @subpackage BO_WC_Customer_Reviews_Watson/includes
 * @author     Blue Origami Digital - Renaud Hamelin <renaud@b-o-d.fr>
 */
class BO_WC_Customer_Reviews_Watson_Api extends BO_WC_Customer_Reviews_Watson_Options
{


    protected $apiKey;
    protected $apiEndpoint;

    public function __construct($apiKey, $serverEndpoint = "gateway", $language = "en", $apiEndpoint = 'watsonplatform.net/tone-analyzer/api/v3/tone')
    {
        $this->apiKey = $apiKey;
        $this->apiEndpoint = $apiEndpoint;
        $this->serverEndpoint = $serverEndpoint;
        $this->language = $language;
    }

    public function getApiUrl()
    {
        return "https://" . $this->serverEndpoint . "." . $this->apiEndpoint . '?version=2017-09-21';
    }

    public function getTone($text)
    {
        $options = $this->getOptions();
        $connection_type = $options['bo_wc_customer_reviews_watson_connection_type'];
        $api_key = $options['bo_wc_customer_reviews_watson_api_key'];
        $username = $options['bo_wc_customer_reviews_watson_username'];
        $password = $options['bo_wc_customer_reviews_watson_password'];
        if (is_null($api_key) or $api_key == "") {
            $api_key=false;
        }
        if (is_null($username) or $username == "") {
            $username=false;
        }
        if (is_null($password) or $password == "") {
            $password=false;
        }
        $data = ['text' => $text];
        $data_string = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getApiUrl());
        if ($connection_type=="api_key" && $api_key!==false) {
            curl_setopt($ch, CURLOPT_USERPWD, 'apikey:' . $api_key);
        }else if ($connection_type=="username_password" && $username!==false && $password) {
            curl_setopt($ch, CURLOPT_USERPWD, $username.':' . $password);
        }else{
            return false;
        }
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Language: ' . $this->language,
                'Accept-Language: ' . $this->language,
                // 'Content-Length: ' . strlen($data_string)
            )
        );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, TRUE);
    }


}
