<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['flag']) {
    //get all movies
    if ($_GET['flag'] == 'all') {
        $url = $base_url . 'films/';
        $get_data = get_from_api($url);
        if ($get_data['status_code'] == 1001) {
            $formatted_data = format_movie_list($get_data['data']['results']);
            $result = array(
                'status_code' => 200,
                'status_message' => 'Success',
                'total' => $formatted_data['count'],
                'data' => $formatted_data['results']
            );
        } else {
            $result = $get_data;
        }
    } //get single movie
    elseif ($_GET['flag'] == 'single') {
        $movie_id = $_GET['id'];
        $url = $base_url . 'films/' . $movie_id . '/';
        $get_data = get_from_api($url);
        if ($get_data['status_code'] == 1001) {
            $formatted_data = format_single_movie($get_data['data']);
            $result = array(
                'status_code' => 200,
                'status_message' => 'Success',
                'data' => $formatted_data
            );
        } else {
            $result = $get_data;
        }
    } //get movie charaacters
    else if ($_GET['flag'] == 'list_characters') {

        $movie_id = $_GET['movie_id'];
        $fetch_movie_url = $base_url . 'films/';
        //get information about the movie
        $get_list = get_from_api($fetch_movie_url);
        $character_array = $get_list['data']['results'][0]['characters'];
        //loop through the characters api
        $get_data = loop_characters_api($character_array);
        //is there a filter
        if (isset($_GET['filter'])) {
            //filter by
            $filter = $_GET['filter'];
            if ($filter == 'male' || $filter == 'female' || $filter == 'unknown') {
                $get_data['data'] = filter_array($filter, 'attributes.gender', $get_data);
            }
        }
        //sort by
        if (isset($_GET['sort'])) {
            //ascending order
            $sort = $_GET['sort'];
            if ($_GET['sort'] == 'age' || $_GET['sort'] == 'name' || $_GET['sort'] == 'height') {
                $get_data['data'] = sort_array('attributes' . $sort, 'asc', $get_data);
            }//descending order
            elseif ($_GET['sort'] == '-age' || $_GET['sort'] == '-name' || $_GET['sort'] == '-height') {
                $get_data['data'] = sort_array('attributes' . $sort, 'desc', $get_data);
            }
        }
        $result = format_people_array($get_data);
    } //get movie comments
    else if ($_GET['flag'] == 'comments') {
        //create movie comments
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movie_id = $_GET['movie_id'];
            $data = $_REQUEST;
            $array_validate = [];
            array_push($array_validate, ['value' => $data['comment'], 'data_type' => 'str_length', 'name' => 'Comment']);
            $validate_result = validate($array_validate);
            //data sent is correct
            if ($validate_result == 1) {
                $comment = $data['comment'];
                $episode_id = $movie_id;
                $ip_address = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
                $result = insert_comment($comment, $ip_address, $episode_id);
            } else {
                $result = $validate_result;
            }

        }//get movie comments
        else {
            $movie_id = $_GET['movie_id'];
            $result = get_movie_comments($movie_id);
        }
    } //an error occurred
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


