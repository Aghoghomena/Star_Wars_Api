<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['API_flag']){

}
else{
    //get all movies
    $url = $base_url . 'films/?format=json';
    $get_data = get_from_api($url);
    if ($get_data['status_code'] == 1001) {
        $result = $get_data;

    } else {
        $result = $get_data;
    }
}

echo json_encode($result);


