<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


echo $_GET['flag'];
//if a flag was attached
if ($_GET['flag']){
    //get all actors
    if ($_GET['flag'] == 'all'){
        $url = $base_url . 'people/';
        $get_data = get_pages_api($url,[], 0);
    }

}
else{
    $result =array(
        'status_code' => 404,
        'status_message'=> 'API Not Found'
    );
}

echo json_encode($result);


