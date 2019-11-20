<?php
/**
 * Created by PhpStorm.
 * User: aghogho pc
 * Date: 11/20/2019
 * Time: 5:31 PM
 */

include_once 'database_class.php';
include_once 'constant.php';


//insert new movie
function insert_movie($movie_id, $movie_name){

}

//check if movie exists
function check_duplicate_movie($movie_id){
    $columns = array("id");

    $o_where['column_name'] = "movie_id";
    $o_where['sign'] = "=";
    $o_where['value'] = $movie_id;
    $movie_where[] = $o_where;

    $get_movie = $this->select_tb($this->order_table . ' rot', $columns, $order_where, "", "", "", "", "", $left_join);

}
