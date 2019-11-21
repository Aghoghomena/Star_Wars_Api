<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['flag']){
    //get single movie
    if($_GET['flag'] =='single'){
        $movie_id = $_GET['id'];
        $url = $base_url . 'films/'.$movie_id.'/';
        $get_data = get_from_api($url);
        if ($get_data['status_code'] == 1001) {
            $formatted_data = format_single_movie($get_data['data']);
            $result =array(
                'status_code' => 200,
                'status_message'=> 'Success',
                'results'=>$formatted_data
            );
        } else {
            $result = $get_data;
        }
    }
    //an error occurred
    else{
        $result =array(
            'status_code' => 404,
            'status_message'=> 'API Not Found'
        );
    }
}
else{
    //get all movies
    $url = $base_url . 'films/';
    $get_data = get_from_api($url);
    if ($get_data['status_code'] == 1001) {
        $formatted_data = format_movie_list($get_data['data']['results']);
        $result =array(
            'status_code' => 200,
            'status_message'=> 'Success',
            'total'=> $formatted_data['count'],
            'results'=>$formatted_data['results']
        );
    } else {
        $result = $get_data;
    }
}

echo json_encode($result);


