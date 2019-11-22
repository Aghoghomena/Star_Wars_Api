<?php

//verify the token
include_once 'database_query.php';

require_once 'vendor/autoload.php';

use Nahid\JsonQ\Jsonq;

//declare  a variable for the ratecursive functions
$output_data =[];


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
            'status_code' => 401,
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
function get_pages_api($url, $existing_data, $total, $total_height)
{
     global $output_data;
    $data = get_from_api($url);
    if ($data['status_code'] == 1001) {
//       check if it has a nezt;
        $url = $data['data']['next'];
        $format_data = format_pages_data($data['data']['results'], $total, $existing_data,$total_height);
        if ($url !== null) {
            $loop_data = get_pages_api($url,$format_data['data'], $format_data['count'],$format_data['height']);
            return $loop_data;
        } else {
            $result =array(
                'status_code' => 200,
                'status_message'=> 'Success',
                'total'=> $format_data['count'],
                'total_height' =>$format_data['height'],
                'results'=>$format_data['data']
            );
            return $result;
        }
    } else {
        return $data;
    }
}

//format people api

function format_pages_data($data, $total, $existing_data,$total_height){
    $formatted_data =$existing_data;
    foreach ($data as $datum){
        if($datum['height'] !== 'unknown'){
            $total_height += $datum['height'];
        }
        array_push($formatted_data, ['name'=> $datum['name'], 'gender'=>$datum['gender'], 'height'=>$datum['height']]);
        $total ++;
    }
    return ['data'=>$formatted_data, 'count'=>$total, 'height'=>$total_height];
}

//sort an array
function sort_array($value, $order,$data){
    $jsonq = new Jsonq();
    $json = $jsonq->collect($data);
    $res = $json->from('results')
        ->sortBy($value, $order)
        ->get();
    return $res;
}
//filter through an array
function filter_array($value,$key, $data){
    $jsonq = new Jsonq();
    $json = $jsonq->collect($data);
    $res = $json->from('results')
        ->where($key, '=', $value)
        ->get();
    return $res;
}
//format people array
function format_people_array($data){
    $jsonq = new Jsonq();
    $json = $jsonq->collect($data);
    $sum_height = $json->from('results')
        ->sum('height');
    $data['total'] = count($data['results']);
    $height_in_feet = floor(($sum_height/30.48));
    $height_in_inches =round(($sum_height/2.54),2);
    $data['total_height'] = $sum_height .'cm makes '. $height_in_feet. 'ft'. ' and '. $height_in_inches. ' inches';
    return $data;

}

//insert comments
function insert_comment($comment, $ip_address, $episode_id){
    $query = new Query();
    $insert = $query->create_comments($comment, $ip_address, $episode_id);
    //insert was successfull
    if($insert > 0){
        $result = array(
            'status_code' => 200,
            'status_message' => 'Comment Successfully Created',
        );
        return $result;
    }
    //insert failed
    else{
        $result = array(
            'status_code' => 401,
            'status_message' => 'An Error Occurred',
        );
        return $result;
    }
}

//list comment
function get_all_comments(){
    $query = new Query();
    $get = $query->get_all_comments();
    //success
    if(is_array($get)){
        $result = array(
            'status_code' => 200,
            'status_message' => 'Comment Successfully Created',
            'total' => $get['total'],
            'results'=>$get['data']
        );
        return $result;
    }
    else{
        $result = array(
            'status_code' => 401,
            'status_message' => 'An Error Occurred',
        );
        return $result;
    }

}
//validate the date being sent
function validate($data)
{
    $counterror = 0;
    $array_error = array();

    //check if data sent is empty
    foreach ($data as $value => $key) {
        $data_type = $key['data_type'];
        $value = $key['value'];
        $dataname = $key['name'];
        if ($data_type == 'number') {
            if ($value == '' || $value == null) {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " Cannot be empty"]);

            } else {
                if (!is_numeric($value)) {
                    $counterror++;
                    array_push($array_error, ['error_message' => $dataname . " is not a number"]);
                }
            }
        }
        else if ($data_type == 'date') {
            if ($value == '') {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " Cannot be empty"]);
            } else {
                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value)) {
                } else {
                    $counterror++;
                    array_push($array_error, ['error_message' => $dataname . " Invalid date sent"]);
                }
            }

        }
        elseif ($data_type == 'status') {

            if ($value == '' || $value == null) {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " Cannot be empty"]);

            } else {
                if (!is_numeric($value)) {
                    $counterror++;
                    array_push($array_error, ['error_message' => $dataname . " is not a number"]);
                } else {
                    if ($value > 1) {
                        $counterror++;
                        array_push($array_error, ['error_message' => $dataname . " status nust be 1 or 0"]);
                    }
                }
            }

        }
        else if ($data_type == 'array') {
            $value = json_decode($value, true);
            if (is_array($value)) {
                if (count($value) == 0) {
                    $counterror++;
                    array_push($array_error, ['error_message' => $dataname . " Array is empty"]);
                }
            } else {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " is not an array"]);
            }

        }
        else if ($data_type == 'date2') {
            if ($value == '') {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " Cannot be empty"]);
            } else {
                if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $value)) {
                } else {
                    $counterror++;
                    array_push($array_error, ['error_message' => $dataname . " Invalid date sent"]);
                }
            }

        }
        else if ($data_type == 'str_length'){
            if ($value == '' || $value == null) {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " Cannot be empty"]);

            } else {
                if (strlen($value) > 500) {
                    $counterror++;
                    array_push($array_error, ['error_message' => $dataname . "length is greater than 500"]);
                }
            }
        }
        else {
            if (empty($value)) {
                $counterror++;
                array_push($array_error, ['error_message' => $dataname . " Cannot be empty"]);
            }
        }

    }
    if ($counterror > 0) {
        return ['status' => 505, 'status_message' => 'Validation Error', 'result_data' => $array_error];
    } else {
        return 1;
    }


}

