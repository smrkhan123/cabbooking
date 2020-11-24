<?php
if(isset($_POST['submit'])){
    if(!isset($_SESSION['id'])) {
      header("location: login.php");
    } else {
      $from = $_POST['pickup'];
      $to = $_POST['drop'];
      $luggage = $_POST['luggage'];
  
    }
  
}
public function calculateFare($username,$pickup,$drop,$cabtype,$weight)
{

$intialdistance=mysqli_query($this->dbh,"SELECT distance From tbl_location where `name`='$pickup'");
while($ridedata=mysqli_fetch_array($intialdistance)) {
    $pickupDistance=$ridedata['distance'];
}
$finaldistance=mysqli_query($this->dbh,"SELECT distance From tbl_location where `name`='$drop'");
while($ridedata=mysqli_fetch_array($finaldistance)) {
    $dropDistance=$ridedata['distance'];
}
$totaldistance=abs($pickupDistance- $dropDistance);
    switch($totaldistance)
{
    case $totaldistance<=10: 
        switch($cabtype)
        {
           case 'CedMicro': $bill=50+($totaldistance*13.50); break; 
           case  'CedMini': $bill=150+($totaldistance*14.50); break;
           case 'CedRoyal': $bill=200+($totaldistance*15.50); break;
           case 'CedSUV': $bill=250+($totaldistance*16.50); break;
        }
    break;
    
    case $totaldistance<=60:
        switch($cabtype)
        {
           case 'CedMicro': $bill=50+(10*13.50)+(($totaldistance-10)*12); break; 
           case  'CedMini':  $bill=150+(10*14.50)+(($totaldistance-10)*13); break;
           case 'CedRoyal': $bill=200+(10*15.50)+(($totaldistance-10)*14); break;
           case 'CedSUV':$bill=250+(10*16.50)+(($totaldistance-10)*15); break;
        }
    break;
    
    case $totaldistance<=160:
        switch($cabtype)
        {
           case 'CedMicro': $bill=50+(10*13.50)+(50*12)+(($totaldistance-60)*10.20); break; 
           case  'CedMini': $bill=150+(10*14.50)+(50*13)+(($totaldistance-60)*11.20); break;
           case 'CedRoyal': $bill=200+(10*15.50)+(50*14)+(($totaldistance-60)*12.20); break;
           case 'CedSUV':$bill=250+(10*16.50)+(50*15)+(($totaldistance-60)*13.20); break;
        }
    break;

    case $totaldistance>160:
        switch($cabtype)
        {
           case 'CedMicro':  $bill=50+(10*13.50)+(50*12)+(100*10.20)+(($totaldistance-160)*8.50); break; 
           case  'CedMini': $bill=150+(10*14.50)+(50*13)+(100*11.20)+(($totaldistance-160)*9.50); break;
           case 'CedRoyal': $bill=200+(10*15.50)+(50*14)+(100*12.20)+(($totaldistance-160)*10.50); break;
           case 'CedSUV':$bill=250+(10*16.50)+(50*15)+(100*13.20)+(($totaldistance-160)*11.50); break;
        }
    break;  
}

/*-----Condition To Check Cab And Weight----------*/
if($cabtype!=='CedMicro' && $weight!=0)
{
switch($weight)
{
    case $weight<=10: $charge=50; break;
    case $weight<=20: $charge=100; break;
    case $weight>20: $charge=200; break;
}
switch($cabtype)
{
    case 'CedSUV': $bill=$bill+(($charge)*2); break;
    default:  $bill=$bill+$charge;
}
}
$date=date("Y/m/d");
$fetchuserId =mysqli_query($this->dbh,"SELECT * From tbl_user WHERE `user_name`='$username'");
        $userId = mysqli_fetch_array($fetchuserId);
        $user= $userId['user_id'];
$insertCabdetail=mysqli_query($this->dbh,"insert into tbl_ride(`ride_date`,`tripstart`,`tripend`,`total_distance`,`luggage`,`total_fare`,`status`,`customer_user_id`) values('$date','$pickup','$drop','$totaldistance','$weight','$bill','1','$user')");
if($insertCabdetail)
{
    echo "<script>alert('PLEASE WAIT WHILE YOUR REQUEST IS BEEN SEND')</script>";
}
}
}
 


?>