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
        $flag = 0;
        $loc = "SELECT * FROM location";
        $check = mysqli_query($conn, $loc);
        while($data = mysqli_fetch_assoc($check)){
            if($data['name'] == $name) {
                $flag = 1;
            }
        }
        if($flag == 0) {
            $sql = "INSERT INTO location (`name`, `distance`, `is_available`) VALUES ('".$name."','".$distance."',1)";
            $run = mysqli_query($conn, $sql);
            if($run){
                return $run;
            }
        } else {
            echo "<script>alert('Data already exists');</script>";
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
        $sql = "UPDATE `location` SET `name` = '".$name."', `distance` = '".$distance."', `is_available` = '".$isavail."' WHERE `id` = '".$id."'";
        $run = mysqli_query($conn, $sql);
       if($run) {
        echo "<script>alert('Location Updated successfully');</script>";
        echo "<script>window.location.href = 'alllocations.php';</script>";
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