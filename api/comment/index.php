<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['flag']) {
    //get all actors
    if ($_GET['flag'] == 'all') {
        $result = get_all_comments();
    } //get single comments
    elseif ($_GET['flag'] == 'single') {
        $id = $_GET['id'];
        $result = get_single_comment($id);
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


