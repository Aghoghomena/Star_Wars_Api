<?php

//include all external files
include_once '../../constant.php';
include_once '../../function.php';


//if a flag was attached
if ($_GET['flag']){
    //get all actors
    if ($_GET['flag'] == 'all'){
        $data= $_REQUEST;
        $url = $base_url . 'people/';
        $sort = strtolower($data['sort']);
        $order = strtolower($data['order']);
        $filter = strtolower($data['filter']);
        $get_data = get_pages_api($url,[], 0, 0);
        //filter
        if($filter == 'male' || $filter == 'female' || $filter == 'none'| $filter == 'n/a' ){
           $get_data['results']= filter_array($filter,'gender', $get_data);
        }
        //sort and arrange the data
        if($sort == 'name' || $sort == 'gender' || $sort =='height' && $order == 'desc' || $order == 'asc'){
            $get_data['results']= sort_array($sort, $order,$get_data);
        }
        $result = format_people_array($get_data);
    }
}
else{
    $result =array(
        'status_code' => 404,
        'status_message'=> 'API Not Found'
    );
}

echo json_encode($result);


