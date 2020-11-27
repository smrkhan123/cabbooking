<?php
include_once('config.php');
class Locations {
    public $id;
    public $name;
    public $distance;
    public $is_available;

    function select($conn) {
        $sql = "SELECT * FROM location WHERE `is_available` = 1";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        }
    }

    function select_loc($conn) {
        $sql = "SELECT * FROM location";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        }
    }

    function select_loc_difference($from, $to, $conn) {
        $sql = "SELECT * FROM location WHERE name = '".$from." AND name = '".$to."'";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0){
            return $run;
        }
    }  
    function insert($name, $distance, $conn) {
        $sql = "INSERT INTO location (`name`, `distance`, `is_available`) VALUES ('".$name."','".$distance."',1)";
        $run = mysqli_query($conn, $sql);
        if($run>0){
            return $run;
        }
    }
    function select_loc_id($id, $conn){
        $sql = "SELECT * FROM location WHERE `id` = '".$id."'";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0){
            $data = mysqli_fetch_assoc($run);
            return $data;
        }
    }
    function update_loc($id, $name, $distance, $isavail, $conn) {
        $sql = "UPDATE `location` SET `name` = '".$name."', `distance` = '".$distance."', `is_available` = 1 WHERE `id` = '".$id."'";
        $run = mysqli_query($conn, $sql);
       if($run) {
           return true;
       } else{
           return false;
       }
    }
    function enable_loc($id, $conn) {
        $isavai = "";
        $qry = "SELECT * FROM location WHERE `id` = $id";
        $run = mysqli_query($conn, $qry);
        if(mysqli_num_rows($run)>0){
            $data = mysqli_fetch_assoc($run);
            if($data['is_available']=="0"){
                $isavai = "1";
            } else {
                $isavai = "0";
            }
            $final = "UPDATE `location` SET `is_available` = $isavai WHERE `id` = $id";
            $runqry = mysqli_query($conn, $final);
            if(!$runqry){
                echo "Some error occured!".mysqli_error($conn);
            }
        }
    }

    function delete_loc($id, $conn) {
        $sql = "DELETE FROM `location` WHERE `id` = $id";
        $run = mysqli_query($conn, $sql);
        if(!$run) {
            echo "Some error occured! ".mysqli_error($conn);
        }
    }
    function sort_loc($sort, $order, $conn) {
        if($sort == "distance"){
            $sort = "cast(`$sort` AS unsigned)";
        }
        $sql = "SELECT * FROM `location` ORDER BY $sort $order";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }
}

?>