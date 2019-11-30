<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['flag']) {

    //get all actors
    if ($_GET['flag'] == 'all') {
        $data = $_REQUEST;
        $url = $base_url . 'people/';
        $result = get_pages_api($url, [], 0, 0);
    } //get single actor
    elseif ($_GET['flag'] == 'single') {
        $id = $_GET['id'];
        $url = $base_url . 'people/' . $id . '/?format=json';
        $result = single_character_api($url, $id);
    }//no flag
    else {
        $result = array(
            'status_code' => 404,
            'status_message' => 'API Not Found'
        );
    }
} else {
    $result = array(
        'status_code' => 404,
        'status_message' => 'API Not Found'
    );
}

echo json_encode($result);


