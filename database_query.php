<?php
/**
 * Created by PhpStorm.
 * User: aghogho pc
 * Date: 11/20/2019
 * Time: 5:31 PM
 */

include_once 'database_class.php';
include_once 'constant.php';

class Query extends Database{

    public $movie_table = 'movies';
    public $comments_table = 'movie_comments';
    //insert new movie
    function insert_movie($movie_id, $movie_name){

        $column = array('episode', 'movie_name');
        $values = array($movie_id, $movie_name);
        $this->insert_data($this->movie_table, $column, $values);
    }

//check if movie exists
    function check_duplicate_movie($movie_id){
        $columns = array("id");

        $o_where['column_name'] = "episode_id";
        $o_where['sign'] = "=";
        $o_where['value'] = $movie_id;
        $movie_where[] = $o_where;

        $get_movie = $this->select_tb( $this->movie_table, $columns, $movie_where);
        return $get_movie;

    }

    //get movie comments
    function get_movie_comments($movie_id){
        $columns = array("comment", "ip_address", "mc.date_added");

        $l_join['table_name'] = $this->movie_table. ' m';
        $l_join['first_column'] = "m.id";
        $l_join['second_column'] = "movie_id";
        $left_join[] = $l_join;

        $o_where['column_name'] = "episode_id";
        $o_where['sign'] = "=";
        $o_where['value'] = $movie_id;
        $movie_where[] = $o_where;


        $get_comments = $this->select_tb( $this->comments_table. ' mc', $columns, $movie_where, '', '', '', '', '', $left_join);
        return $get_comments;
    }

    //insert comments
    public function create_comments($comments, $ip_address, $episode_id){
        $column = array('comment', 'ip_address', 'movie_id');
        $values = array($comments, $ip_address, $episode_id);;
        $insert_table = $this->insert_data($this->comments_table, $column, $values);
        return $insert_table;
    }

    //get all comments
    function get_all_comments(){
        $columns = array("comment", "ip_address", "date_added");

        $get_comments = $this->select_tb( $this->comments_table, $columns, '', '', '', ['date_added', 'DESC'], '', '', '');
        return $get_comments;
    }

}

