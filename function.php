<?php

//verify the token

function send_to_api($data, $url,$token){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: multipart/form-data',
            'token: ' . $token)
    );
    $result = curl_exec($ch);
    return $result;
}

//get from api
function get_from_api($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/json')
    );
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {

        $result = array(
            'status_code' => 404,
            'status_message' => $err
        );

    } else {
        $result = array(
            'status_code' => 1001,
            'status_message' => 'Success',
            'data'=> json_decode($response,true)
        );;
    }
    return $result;

}