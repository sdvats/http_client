<?php

require_once('classes/httpclient.php');

use CoreDNA\HttpClient as HttpClient;

//API endPoint for getting Token and Posting Data
$url = 'https://www.coredna.com/assessment-endpoint.php';
//Data to be Posted
$data = array("name" => "Subodh Sharma", "email" => "subodhsharma2605@gmail.com", "url" => "https://github.com/sdvats/http_client.git");

//Initializing Httpclient Object
$client = new HttpClient;

//Setting custom header token for getting token
$headerToken = "Content-type: application/x-www-form-urlencoded\r\n";

// executing getToken method to get the token and catching the exception
try {
    $token = $client -> getToken($url, "OPTIONS", $headerToken);
}catch (Exception $exception){
    echo 'Message: ' . $exception -> getMessage();
    echo '<br/>';
    echo 'File: ' . $exception -> getFile();
    echo '<br/>';
    echo 'Line: ' . $exception -> getLine();
    echo '<br/>';
    echo 'Trace: ' . $exception -> getTraceAsString();
    return false; // Stopping the script if exception occured
}

//Setting custom header for POST data query
$headerPost = "Content-type: application/json\r\n".
              "Authorization: Bearer ".$token."\n";

// Posting data with httpPost method and catching any exception which can occur
try {
    $response = $client -> httpPost($url, 'POST', $headerPost , $data);
}catch (Exception $exception){
    echo 'Message: ' . $exception -> getMessage();
    echo '<br/>';
    echo 'File: ' . $exception -> getFile();
    echo '<br/>';
    echo 'Line: ' . $exception -> getLine();
    echo '<br/>';
    echo 'Trace: ' . $exception -> getTraceAsString();
    return false; // Stopping the execution in case of exception
}

//Final response in String Getting 202 Status Code
echo $response;






