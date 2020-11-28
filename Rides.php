<?php
include_once('config.php');
class Rides {
    public $from;
    public $to;
    public $distance;
    public $luggage;
    public $total_fare;
    public $status;
    public $customer_id;

    function select_allrides($conn) {
        $sql = "SELECT * FROM ride";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        } else {
            return '0';
        }
    
    }
    function select_ride($data, $conn) {
        $sql = "SELECT * FROM ride WHERE status = '".$data."'";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        } else {
            return '0';
        }
    }

    function select_confirmed_ride($conn) {
        $sql = "SELECT * FROM ride WHERE `is_delete` = 0 AND `status` = 2";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        } else {
            return 0;
        }
    }

    function select_previous_rides($id, $conn) {
        $sql = "SELECT * FROM ride WHERE `customer_user_id` = '".$id."'";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        } else {
            return 0;
        }
    }
    
    function insert($from, $to, $luggage, $fare, $distance, $cabtype, $user_id, $status, $conn) {
        $sql = "INSERT INTO ride(`ride_date`, `from`, `to`, `total_distance`, `cabtype`, `luggage`, `total_fare`, `status`, `customer_user_id`, `is_delete`) VALUES (NOW(), '".$from."', '".$to."', '".$distance."', '".$cabtype."', '".$luggage."', '".$fare."', '".$status."', '".$user_id."',0)";
        // echo $sql;
        // die();
        $run = mysqli_query($conn, $sql);
        if(!$run){
            echo "Some error occured! ".mysqli_error($conn);
        } else {
            echo "<script>alert('Your ride is booked! We make sure to get in touch with you shortly.'); window.location.href = 'previousrides.php';</script>";
        }
    }

    function remove($id, $conn) {
        $final = "UPDATE `ride` SET `is_delete` = 1 WHERE `ride_id` = $id";
        $runqry = mysqli_query($conn, $final);
        if(!$runqry){
            echo "Some error occured!".mysqli_error($conn);
        }
    }

    function update($id, $data, $conn) {
        $status = "";
        if($data == "cancel") {
            $status = '0';
        } elseif($data == "approve") {
            $status = '2';
        }
        $final = "UPDATE `ride` SET `status` = $status WHERE `ride_id` = $id";
        $runqry = mysqli_query($conn, $final);
        if(!$runqry){
            echo "Some error occured!".mysqli_error($conn);
        }
    }

    function sort_col($id, $sort, $order, $conn) {
        $sql = "SELECT * FROM `ride` WHERE `customer_user_id` = '".$id."' ORDER BY cast(`$sort` AS unsigned) $order";
        // return $sql;
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            echo "Some error occured!".mysqli_error($conn);
        } else {
            return $runqry;
        }
    }

    function sort_allrides($sort, $order, $conn) {
        $sql = "SELECT * FROM `ride` ORDER BY cast(`$sort` AS unsigned) $order";
        // return $sql;
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }

    function sort_statuswise($status, $sort, $order, $conn) {
        $sql = "SELECT * FROM `ride` WHERE `status` = $status ORDER BY cast(`$sort` AS unsigned) $order";
        // return $sql;
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }

    function sort_past($sort, $order, $conn) {
        $sql = "SELECT * FROM `ride` WHERE (`is_delete` = 0 AND `status` = 2) ORDER BY cast(`$sort` AS unsigned) $order";
        // return $sql;
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            echo "Some error occured!".mysqli_error($conn);
        } else {
            return $runqry;
        }
    }

    function filter_datewise($id, $date1, $date2, $conn) {
        $sql = "SELECT * FROM `ride` WHERE `customer_user_id` = '".$id."' AND DATE(`ride_date`) BETWEEN '".$date1."' AND '".$date2."'";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            echo "Some error occured!".mysqli_error($conn);
        } else {
            return $runqry;
        }
    }

    function filter_weekwise($id, $week, $conn) {
        $wk = (substr($week,-2)-1);
        $sql = "SELECT * FROM `ride` WHERE `customer_user_id` = '".$id."' AND WEEK(`ride_date`) = '".$wk."'";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            echo "Some error occured!".mysqli_error($conn);
        } else {
            return $runqry;
        }
    }

    function select_invoice($id, $conn) {
        $sql = "SELECT * FROM ride WHERE `ride_id` = '".$id."'";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        } else {
            return 0;
        }
    }
}
?>