<?php

//verify the token

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
        $result = array(
            'status_code' => 1001,
            'status_message' => 'Success',
            'data' => json_decode($response, true)
        );;
    }
    return $result;

}

//format the movies
function format_movie_list($data)
{
    $data_array = [];
    $count = 0;
    foreach ($data as $datum) {
        $count++;
        array_push($data_array, ['id' => $datum['episode_id'], 'name' => $datum['title'], 'release_date' => $datum['release_date'], 'opening_crawl' => $datum['opening_crawl']]);
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