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

    function select_ride($conn) {
        $sql = "SELECT * FROM ride WHERE status = '2'";
        $run = mysqli_query($conn, $sql);
        if(mysqli_num_rows($run)>0){
            return $run;
        }
    }
    
}

?>