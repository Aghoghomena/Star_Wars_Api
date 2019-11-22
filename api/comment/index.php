<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['flag']){
    //get all actors
    if ($_GET['flag'] == 'create'){
        $data= $_REQUEST;
        $array_validate = [];
        array_push($array_validate, ['value' => $data['comment'], 'data_type' => 'str_length', 'name' => 'Comment'], ['value' => $data['episode_id'], 'data_type' => 'number', 'name' => 'EpisodeID']);
        $validate_result = validate($array_validate);
        //data sent is correct
        if ($validate_result == 1) {
            $comment = $data['comment'];
            $episode_id = $data['episode_id'];
            $ip_address = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
            $result = insert_comment($comment, $ip_address, $episode_id);
        }
        else{
            $result = $validate_result;
        }
    }
    elseif ($_GET['flag'] == 'list'){
        //list comments
        $result = get_all_comments();

    }
    else{
        $result =array(
            'status_code' => 404,
            'status_message'=> 'API Not Found'
        );
    }
}
else{
    $result =array(
        'status_code' => 404,
        'status_message'=> 'API Not Found'
    );
}

echo json_encode($result);


