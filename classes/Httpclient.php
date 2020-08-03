<?php
namespace CoreDNA;

use Exception;


/**
 * Class Httpclient
 * @package CoreDNA
 * Httpclient class has two methods, One to get the token and another to post the json data to the api endpoint
 */
class Httpclient
{

    /**
     * @param $url
     * Expects an URL which is a API endpoint to get the Authentication token
     * @param $method
     * Expects an method type to be send in the header example OPTIONS, GET, POST.
     * @param $header
     * Custom header which can be set to send with the request
     * @return false|string
     * Returns Authentication token in form of string if the request is successful
     * @throws Exception
     * if the request is not successful, throws an exception.
     */
    public function getToken($url, $method, $header){
        $options = array(
            'http' => array(
                'header' => $header,
                'method'  => $method
            )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        if (intval(explode(" ", $http_response_header[0])[1]) != 200){
            throw new Exception("$method"." is not supported with this request");
        }
        return $response;
    }


    /**
     * @param $url
     * Expects an URL which is a API endpoint where the data can be posted
     * @param $method
     * Expects a method which can be sent along the header in request to send the data;
     * @param $header
     * Custom header which requres Authentication Bearer token
     * @param $data
     * Associative which will be converted to json string when POSTING the data
     * @return string
     * if successful and we receive 202 status, we receive string saying that the data is posted
     * @throws Exception
     * Throws an error if the request has other status code returned
     */
    public function httpPost($url, $method, $header, $data){

        $jsonData = json_encode($data);
        if (!isset($jsonData)){
            throw new Exception('Data cannot be converted to JSON');
        }

        $options = array(
            'http' => array(
                "method"  => $method,
                "header"  => $header,
                'content' => $jsonData
            )
        );
        $context  = stream_context_create($options);
        $response = fopen($url, "rb", false, $context);
        if (intval(explode(" ", $http_response_header[0])[1]) != 202){
            throw new Exception("$method"." is not supported with this request");
        }
        return "Your Json Data is Sucessfully Posted";
    }

}