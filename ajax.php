<?php

session_start();
include('Locations.php');
$obj = new Locations();
$db = new config();
$sql = $obj->select_loc($db->conn);
$arr = array();
while($dt=mysqli_fetch_assoc($sql)){
    $arr = $arr + array($dt['name']=>$dt['distance']);
}
// $arr = array("charbagh"=>0, "indiranagar"=>10,"bbd"=>30, "barabanki"=>60, "faizabad"=>100, "basti"=>150, "gorakhpur"=>210);

$pick = $_POST['pickup'];
$drop = $_POST['drop'];
$cab = $_POST['cab'];
$luggage = $_POST['luggage'];
$myarr = array($pick, $drop, $cab, $luggage);
$pickup_distance;
$drop_distance;
foreach($arr as $key => $value) {
    if($key==$pick){
        $pickup_distance = $arr[$key];
    } else if($key==$drop) {
        $drop_distance = $arr[$key];
    }
}
$final_distance = abs($pickup_distance-$drop_distance);


$_SESSION['distance']=$final_distance;
//calculating luggage price

$l_price;
if($luggage<=10 && $luggage > 0){
    $l_price = 50;
} else if($luggage >10 && $luggage <= 20) {
    $l_price = 100;
} else if($luggage > 20) {
    $l_price = 200;
} else {
    $l_price = 0;
}

// fare calculation

$fare = 0;
if($cab=='cedmicro') {
    if($final_distance <=10) {
        $fare = $fare + 50 + $final_distance*13.5;
    } else if($final_distance > 10 && $final_distance <= 60) {
        $fare = $fare + 50 + (10*13.5) + (($final_distance - 10)*12);
    } else if($final_distance > 60 && $final_distance <= 160) {
        $fare = $fare + 50 + (10*13.5) + (50*12) + (($final_distance - 60)*10.20) ;
    } else if($final_distance > 160) {
        $fare = $fare + 50 + (10*13.5) + (50*12) + (100*10.20) + (($final_distance - 160)*8.50);
    }
} else if($cab=='cedmini') {
    if($final_distance <=10) {
        $fare = $fare + 150 + $final_distance*14.5;
    } else if($final_distance > 10 && $final_distance <= 60) {
        $fare = $fare + 150 + (10*14.5) + (($final_distance - 10)*13);
    } else if($final_distance > 60 && $final_distance <= 160) {
        $fare = $fare + 150 + (10*14.5) + (50*13) + (($final_distance - 60)*11.20) ;
    } else if($final_distance > 100) {
        $fare = $fare + 150 + (10*14.5) + (50*13) + (100*11.20) + (($final_distance - 160)*9.50) ;
    }
    $fare = $fare + $l_price;
} else if($cab=='cedroyal') {
    if($final_distance <=10) {
        $fare = $fare + 200 + $final_distance*15.5;
    } else if($final_distance > 10 && $final_distance <= 60) {
        $fare = $fare + 200 + (10*15.5) + (($final_distance - 10)*14);
    } else if($final_distance > 60 && $final_distance <= 160) {
        $fare = $fare + 200 + (10*15.5) + (50*14) + (($final_distance - 60)*12.20) ;
    } else if($final_distance > 100) {
        $fare = $fare + 200 + (10*15.5) + (50*14) + (100*12.20) + (($final_distance - 160)*10.50) ;
    }
    $fare = $fare + $l_price;
} else if($cab=='cedsuv') {
    if($final_distance <=10) {
        $fare = $fare + 250 + $final_distance*16.5;
    } else if($final_distance > 10 && $final_distance <= 60) {
        $fare = $fare + 250 + (10*16.5) + (($final_distance - 10)*15);
    } else if($final_distance > 60 && $final_distance <= 160) {
        $fare = $fare + 250 + (10*16.5) + (50*15) + (($final_distance - 60)*13.20) ;
    } else if($final_distance > 160) {
        $fare = $fare + 250 + (10*16.5) + (50*15) + (100*13.20) + (($final_distance - 160)*11.50) ;
    }
    $fare = $fare + (2*$l_price);
}
$_SESSION['fare']=$fare;
$arr = array($fare, $final_distance);
echo json_encode($arr);
?>