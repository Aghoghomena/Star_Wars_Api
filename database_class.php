<?php
/**
 * Created by PhpStorm.
 * User: aghogho pc
 * Date: 11/20/2019
 * Time: 5:25 PM
 */

include_once 'constant.php';

class Database
{

    protected $connect;
    protected $query;
    protected $nocount;
    protected $sql;
    protected $row;
    public static $type;


    public function __construct()
    {
        global $connect;
        $this->connect = $connect;
    }

    public function connect_db($type = "r")
    {


    }

    public function auto_commit_off()
    {
        mysqli_autocommit($this->connect, FALSE);

    }

    public function rollback_now()
    {
        mysqli_rollback($this->connect);

    }

    public function commit_now()
    {
        mysqli_commit($this->connect);

    }

    public function disconnect_db()
    {
        mysqli_close($this->connect);
    }

    public function query_tb()
    {
        //echo $this->sql;
        $this->query = mysqli_query($this->connect, $this->sql);

        if ($this->query) {
            //echo "true";
            //echo "<br>";
            return 1;
        } else {
            //echo "false";
            //echo "<br>";
            return 0;
        }
    }

    public function count_tb()
    {
        return $this->nocount = mysqli_num_rows($this->query);
    }

    public function row_tb()
    {
        //return $this->row = mysqli_fetch_all($this->query, MYSQLI_ASSOC);
        $query_array = array();
        while ($row = mysqli_fetch_assoc($this->query)) {
            $query_array[] = $row;
        }
        //print_r($query_array);
        //echo "<br>";
        return $this->row = $query_array;
    }

    public function escape_string($norm_string)
    {
        return mysqli_real_escape_string($this->connect, $norm_string);
    }

    public function adjust_columns($columns)
    {

        $columnlength = count($columns);
        for ($x = 0; $x < $columnlength; $x++) {
            if ($x == 0) {
                $scolumns = $this->escape_string($columns[$x]);
            } else {
                $scolumns = $scolumns . "," . $this->escape_string($columns[$x]);
            }
        }

        return $scolumns;
    }

    public function adjust_array($columns)
    {

        $columnlength = count($columns);
        $array_data = array();
        for ($x = 0; $x < $columnlength; $x++) {

            $acolumns = $this->escape_string($columns[$x]);

            $array_data[] = $acolumns;
        }

        return $array_data;
    }

    public function check_sign($sign)
    {

        if ($sign == "=" || $sign == "!=" || $sign == "NOT IN" || $sign == "IN" || $sign == "<=" || $sign == ">=" || $sign == "<=" || $sign == "<" || $sign == ">" || $sign == "LIKE" || $sign == "BETWEEN") {
            return $sign;
        }
    }

    public function adjust_where($where)
    {
        //print_r($where);
        //echo "<br>";
        $wherelength = count($where);
        for ($x = 0; $x < $wherelength; $x++) {
            if ($x == 0) {
                $swhere = $this->break_where($where[$x]);
            } else {
                $swhere = $swhere . " AND " . $this->break_where($where[$x]);
            }
        }

        return $swhere;
    }

    public function adjust_where_or($where)
    {
        //print_r($where);
        //echo "<br>";
        $swhere = "";
        $wherelength = count($where);
        for ($x = 0; $x < $wherelength; $x++) {
            if ($x == 0) {
                $swhere = $this->break_where($where[$x]);
            } else {
                $swhere = $swhere . " OR " . $this->break_where($where[$x]);
            }
        }

        return $swhere;
    }

    public function adjust_set_update($set)
    {
        //print_r($where);
        //echo "<br>";
        $setlength = count($set);
        for ($x = 0; $x < $setlength; $x++) {
            if ($x == 0) {
                $swhere = $this->break_where($set[$x]);
            } else {
                $swhere = $swhere . " , " . $this->break_where($set[$x]);
            }
        }

        return $swhere;
    }

    public function break_where($single_where)
    {
//print_r($single_where);
//echo "<br>";
        $where_name = $this->escape_string($single_where["column_name"]);
        $where_value = $single_where['value'];

        if (isset($single_where['sign']) && $single_where['sign'] != "") {
            $where_sign = $this->check_sign($single_where['sign']);
        } else {
            $where_sign = "=";
        }

        if (is_array($where_value)) {
            if ($where_sign == "BETWEEN") {
                $where_value = $this->adjust_array($single_where['value']);
                //print_r($where_value);
            } else {
                $where_value = $this->adjust_columns($single_where['value']);
            }
            //print_r($where_value);
        } else {
            $where_value = $this->escape_string($single_where['value']);
        }


        if ($where_sign == "NOT IN" || $where_sign == "IN") {
            return $where_string = $where_name . " " . $where_sign . " (" . $where_value . ")";
        } elseif ($where_sign == "LIKE") {
            return $where_string = $where_name . " " . $where_sign . " '%" . $where_value . "%'";
        } elseif ($where_sign == "BETWEEN") {

            return $where_string = $where_name . " " . $where_sign . " " . $where_value[0] . " AND " . $where_value[1];
        } else {

            if ($where_value == 'CURDATE()') {
                return $where_string = $where_name . " " . $where_sign . " " . $where_value . "";
            } else {

                return $where_string = $where_name . " " . $where_sign . " '" . $where_value . "'";
            }
        }
    }

    public function adjust_left_join($join)
    {
        $joinlength = count($join);
        for ($x = 0; $x < $joinlength; $x++) {
            if ($x == 0) {
                $sjoin = $this->break_left_join($join[$x]);
            } else {
                $sjoin = $sjoin . $this->break_left_join($join[$x]);
            }
        }

        return $sjoin;
    }

    public function break_left_join($single_join)
    {

        $table_name = $this->escape_string($single_join['table_name']);
        $first_column = $this->escape_string($single_join['first_column']);
        $second_column = $this->escape_string($single_join['second_column']);

        return $join_string = " LEFT JOIN " . $table_name . " ON " . $first_column . " = " . $second_column;

    }

    public function adjust_order($order)
    {
        $order_name = $this->escape_string($order[0]);

        if (isset($order[1]) && $order[1] != "") {

            if ($order[1] == "DESC" || $order[1] == "ASC") {
                $ordertype = $order[1];
            } else {
                $ordertype = "RAND()";
            }
        } else {
            $ordertype = "RAND()";
        }


        if (isset($order_name) || $order_name != "") {

            return $order_name . " " . $ordertype;
        } else {
            return $ordertype;
        }
    }

    public function adjust_limit($limit)
    {
        if (isset($limit[0]) && $limit[0] != "" && is_numeric($limit[0])) {
            $offset = $this->escape_string($limit[0]);
        } else {
            $offset = 0;

        }

        if (isset($limit[1]) && $limit[1] != "" && is_numeric($limit[1])) {
            $norecords = $this->escape_string($limit[1]);
        } else {
            $norecords = 1;
        }

        return $offset . "," . $norecords;
    }

    public function select_tb($table, $columns = '*', $where = null, $where_adjust_sign = null, $group = null, $order = null, $limit = null, $distinct = null, $leftjoin = null)
    {
        //print_r($where);
        //echo "<br>";
        if ($distinct != null || $distinct != "") {
            $this->sql = "SELECT DISTINCT";
        } else {
            $this->sql = "SELECT";
        }

        $scolumns = "";
        if ($columns != '*') {
            $scolumns = $this->adjust_columns($columns);

        } else {
            $scolumns = $columns;
        }


        $this->sql = $this->sql . " " . $scolumns . " FROM " . $table;

        if ($leftjoin != null || $leftjoin != "") {

            $this->sql = $this->sql . $this->adjust_left_join($leftjoin);
        }

        if ($where != null || $where != "") {
            //print_r($where);
            if ($where_adjust_sign == "OR") {
                $this->sql = $this->sql . ' WHERE ' . $this->adjust_where_or($where);
                //echo "<br>";
            } else {

                $this->sql = $this->sql . ' WHERE ' . $this->adjust_where($where);

            }
        }

        if ($group != null || $group != "") {
            $this->sql = $this->sql . ' GROUP BY ' . $this->adjust_columns($group);
            //echo "<br>";
        }
        if ($order != null || $order != "") {
            $this->sql = $this->sql . ' ORDER BY ' . $this->adjust_order($order);
            //echo "<br>";
        }
        if ($limit != null || $limit = "") {
            $this->sql = $this->sql . ' LIMIT ' . $this->adjust_limit($limit);
            //echo "<br>";
        }

        //echo $this->sql;
        //	echo "<br>";
        if ($this->query_tb() == 1) {

            $total_count = $this->count_tb();
            if ($total_count > 0) {

                $data_array['total'] = $total_count;
                $data_array['data'] = $this->row_tb();
                return $data_array;
            } else {

                return 0;
            }
        } else {
            return 0;
        }
    } // end function select_tb


    public function insert_query_tb()
    {
        $this->query = mysqli_query($this->connect, $this->sql);

        if ($this->query) {

            $lastid = $this->connect->insert_id;
            return $lastid;
        } else {

            return 0;
        }
    }


    public function adjust_insert_columns($columns)
    {

        $columnlength = count($columns);
        for ($x = 0; $x < $columnlength; $x++) {
            if ($x == 0) {
                $scolumns = "'" . $this->escape_string($columns[$x]) . "'";
            } else {
                $scolumns = $scolumns . ",'" . $this->escape_string($columns[$x]) . "'";
            }
        }

        return $scolumns;
    }


    public function insert_data($table, $columns, $values)
    {

        $table = $this->escape_string($table);
        $scolumns = $this->adjust_columns($columns);
        $this->sql = "INSERT INTO " . $table . "(" . $scolumns . ")";
//echo $this->sql;
        $svalues = $this->adjust_insert_columns($values);
        $this->sql = $this->sql . " VALUES (" . $svalues . ")";
        //echo $this->sql;
//echo "<br>";
        $lastid = $this->insert_query_tb();
        if ($lastid > 0) {
            return $lastid;

        } else {
            return 0;
        }

    }

    public function check_duplicate_entry($table, $where_data, $combine)
    {
        $check_column = array();
        if ($combine == 0) {
            $sign = "OR";

        } else {
            $sign = "AND";
        }
        $wherelength = count($where_data);
        //echo json_encode ($where_data);
        //echo "<br>";
        if ($wherelength > 0) {
            $duplicate_check = array();
            foreach ($where_data as $key => $where_check) {
                //$where_check['sign'] = "OR";
                //$duplicate_check[] = $where_check;
                $check_column[] = $where_check['column_name'];
            }
            //return $check_column;
            $select_data = $this->select_tb($table, $check_column, $where_data, $sign);
            //echo $select_data;
            if (is_array($select_data)) {

                return $select_data;

            } else {

                return 1;
            }
        } else {
            return 0;
        }

    }

    public function insert_check_duplicate($table, $columns, $values, $whereduplicate, $combine_duplicate = 0)
    {

        $duplicate_check = $this->check_duplicate_entry($table, $whereduplicate, $combine_duplicate);

        if ($duplicate_check == 1) {

            $insert_data = $this->insert_data($table, $columns, $values);

            if ($insert_data > 0) {
                return $insert_data;
            } else {
                return 0;
            }

        } else {
            return -1;
        }

    }


    public function update_data($table, $set, $where)
    {
        //print_r($where);
        $table = $this->escape_string($table);
        $this->sql = "UPDATE " . $table;
        $this->sql = $this->sql . ' SET ' . $this->adjust_set_update($set);
        $this->sql = $this->sql . ' WHERE ' . $this->adjust_where($where);

        //echo $this->sql;
        //echo "<br>";
        if ($this->query_tb() == 1) {

            return 1;
        } else {

            return 0;
        }

    }


    public function update_check_duplicate($table, $set, $where, $whereduplicate, $key)
    {

        $check_column = array($key);
        //print_r($whereduplicate);
        //echo "<br>";
        $check_exists = $this->select_tb($table, $check_column, $where);
        //print_r($check_exists);
        if (is_array($check_exists)) {

            $key_id = $check_exists['data'][0][$key];
            //print_r($whereduplicate);
            //echo "<br>";

            $duplicate_check = $this->check_duplicate_entry($table, $whereduplicate);
            //echo $duplicate_check;

            if ($duplicate_check == 1) {

                $update_where = array();
                $update_where['column_name'] = $key;
                $update_where['sign'] = "=";
                $update_where['value'] = $key_id;

                $update_where_data[] = $update_where;
                //print_r($update_where_data);
                //echo "<br>";
                $update_data = $this->update_data($table, $set, $update_where_data);
                if ($update_data > 0) {
                    return 1;
                } else {
                    return 0;
                }

            } else {
                return -1;
            }

        }


    }

    public function delete_data($table, $where)
    {
        $table = $this->escape_string($table);
        $this->sql = "DELETE FROM " . $table;
        $this->sql = $this->sql . ' WHERE ' . $this->adjust_where($where);
        //echo $this->sql;
        //echo "<br>";
        if ($this->query_tb() == 1) {

            return 1;
        } else {
            return 0;
        }
    }

//"UPDATE reset_password SET status = 0, update_date = '$currentdate' WHERE r_id = '$rid' AND status = 1";


    public function insert_log($data)
    {
        foreach ($data as $key => $title) {
            $values[] = "'$title'";
            $columns[] = $key;
        }
        $values = implode(",", $values);
        $columns = implode(",", $columns);
        $this->sql = "Insert into rims_third_logs ( " . $columns . " ) VALUES " . '(' . $values . ' )';
//        echo $this->sql;
        if ($this->query_tb() == 1) {

            return 1;
        } else {
            return 0;
        }
    }

}
