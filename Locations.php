<?php
include_once('config.php');
class Locations {
    public $id;
    public $name;
    public $distance;
    public $is_available;

    function select_loc($conn) {
        $sql = "SELECT * FROM location";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        }
    }

    function select_loc_difference($from, $to, $conn) {
        $sql = "SELECT * FROM location WHERE ";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        }
    }
    
}

?>