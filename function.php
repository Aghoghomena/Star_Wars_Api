<?php

//verify the token
include_once 'database_query.php';

function send_to_api($data, $url, $token)
{
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
function get_from_api($url)
{

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
        //check if it has a next
        $result = array(
            'status_code' => 1001,
            'status_message' => 'Success',
            'data' => json_decode($response, true)
        );
    }
    return $result;

}

//format single movie
function format_single_movie($data)
{
    $count_comments = 0;
    //check if movie exists
    $query = new Query();

    //check if movie has comments
    $comment_array = $query->get_movie_comments($data['episode_id']);
    //the movie has comments
    if (is_array($comment_array)) {
        $count_comments = $comment_array['total'];
    }

    return ['id' => $data['episode_id'], 'name' => $data['title'], 'release_date' => $data['release_date'], 'opening_crawl' => $data['opening_crawl'], 'comments' => $count_comments];


}

//format multiple the movies
function format_movie_list($data)
{
    $data_array = [];
    $count = 0;
    foreach ($data as $datum) {
        $count++;
        $comment_array = [];
        $count_comments = 0;
        //check if movie exists
        $query = new Query();
        $check_new_movie = $query->check_duplicate_movie($datum['episode_id']);
        //movie exists in db get the comments
        if (is_array($check_new_movie)) {
            $comment_array = $query->get_movie_comments($datum['episode_id']);
            //the movie has comments
            if (is_array($comment_array)) {
                $count_comments = $comment_array['total'];
            }
        } //movie does not exist and needs to be pushed to the db
        else {
            $query->insert_movie($datum['episode_id'], $datum['title']);
        }
        array_push($data_array, ['id' => $datum['episode_id'], 'name' => $datum['title'], 'release_date' => $datum['release_date'], 'opening_crawl' => $datum['opening_crawl'], 'comments' => $count_comments]);

    }
    $sort_date = sort_array_by_date(array(
        'count' => $count,
        'results' => $data_array
    ));
    return $sort_date;
}

//sort array by date
function sort_array_by_date($data)
{
    $movie_array = $data['results'];
    usort($movie_array, 'date_compare');
    return (array(
        'count' => $data['count'],
        'results' => $movie_array
    ));
}

//this is compare each time
function date_compare($a, $b)
{
    $t1 = strtotime($a['release_date']);
    $t2 = strtotime($b['release_date']);
    return $t2 - $t1;
}

//handle pagination api
function get_pages_api($url, $existing_data, $total)
{

    $data = get_from_api($url);
    if ($data['status_code'] == 1001) {
//       check if it has a nezt;
        $url = $data['data']['next'];
        $format_data = format_pages_data($data['data']['results'], $total, $existing_data);
        if ($url !== null) {
            $loop_data = get_pages_api($url,$format_data['data'], $format_data['count']);
        } else {
            $result =array(
                'status_code' => 200,
                'status_message'=> 'Success',
                'total'=> $format_data['count'],
                'results'=>$format_data['data']
            );
            print_r($result);
        }
    } else {
        return $data;
    }

}

//format people api

function format_pages_data($data, $total, $existing_data){
    $formatted_data =$existing_data;
    foreach ($data as $datum){
        array_push($formatted_data, ['name'=> $datum['name'], 'gender'=>$datum['gender'], 'height'=>$datum['height']]);
        $total ++;
    }
    return ['data'=>$formatted_data, 'count'=>$total];
}
