<?php
session_start();
include("Locations.php");
include("Rides.php");
if(isset($_SESSION['id'])){
  if($_SESSION['usertype'] != '0') {
      header("location:admin/admindashboard.php");
  }
}
// $loc = new Locations();
// $db = new config();
// $sql = $loc->select_loc($db->conn);
if(isset($_GET['booking'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $luggage = $_GET['luggage'];
    $fare = $_GET['fare'];
    $cabtype = $_GET['cabtype'];
    $distance = $_GET['distance'];
} elseif(isset($_GET['booked'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $luggage = $_GET['luggage'];
    if($luggage == ""){
      $luggage = '0';
    }
    $fare = $_GET['fare'];
    $fare = $_GET['fare'];
    $distance = $_GET['distance'];
    $cabtype = $_GET['cabtype'];
    $user_id = $_SESSION['id'];
    $status = '1';
    $obj = new Rides();
    $db = new config();
    $sql = $obj->insert($from, $to, $luggage, $fare, $distance, $cabtype, $user_id, $status, $db->conn);
} else {
    header("location:index.php");
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab fare</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
  <style>
  .caret {
    margin:2px;
    margin-left:5px;
  }
    .caret-dropup {
      transform: rotate(180deg);
    }
  table th, table td {
    text-align: center !important;
  }
  </style>
</head>
<body>
  <div id="wrapper">
    <!-- Header Section -->
    <header>
      <nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="logo.png" width="100" alt="CedCab" class="logoimage"></a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Book Cab</a></li>
            <li class="active"><a href='previousrides.php'>Previous Rides</a></li>
            <li><a href='updateprofile.php'>Update Profile</a></li>
            <li><a href='changepassword.php'>Change Password</a></li>
            <li><a><?php echo "Hey, &nbsp".$_SESSION['username']; ?></a></li>
            <li><a href='logout.php'>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- Main Section/ Landing Page -->
    <section id="main">
    <div class="text-center">
        <h2>Confirm your Booking Here</h2>
        <!-- <p>Here previous rides include Completed as well as Cancelled rides</p>  -->
    </div>
      <div class="container text-center">
        <table class="table table-striped">
            <tbody>
                <tr>
                <?php
                    if(isset($_GET['book'])) {
                        $from = $_GET['pickup'];
                        $to = $_GET['drop'];
                        $luggage = $_GET['luggage'];
                        $fare = $_GET['fare'];
                        $cabtype = $_GET['cabtype'];
                        $distance = $_GET['distance'];
                        
                    }
                ?>
                    <tr> 
                      <th><h4>From</h4></th><td><h4><?php echo ucfirst($from); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>To</h4></th><td><h4><?php echo ucfirst($to); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>Luggage</h4></th><td><h4><?php if($luggage == "") { echo "0"; } else { echo $luggage; } ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>CabType</h4></th><td><h4><?php echo ucfirst($cabtype); ?></td>
                    </tr>
                    <tr>
                      <th><h4>Distance</h4></th><td><h4><?php echo ucfirst($distance); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>Fare</h4></th><td><h4><?php echo ucfirst($fare); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>Action</h4></th><td>
                        <?php echo "<a href='confirmbooking.php?booked=1&from=$from&to=$to&luggage=$luggage&fare=$fare&distance=$distance&cabtype=$cabtype' class='btn btn-success'>Confirm Booking</a>&nbsp;&nbsp;<a href='index.php' class='btn btn-danger'>Cancel Booking</a>" ; ?>
                      </td>
                    </tr>
            </tbody>
        </table>
      </div>
    </section>
    <footer>
      <div class="sect10">
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 socialIcons text-center">
              <img src="logo.png" width="100" alt="CedCab">
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 socialIcons text-center"></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 socialIcons text-center links">
              <a href="#">Requested Rides</a>
              <a href="#">Past Rides</a>
              <a href="#">Locations</a>
            </div>
          </div>
        </div>
      </div>
      <div class="container text-center">
        <p class="footer_cp">Designed & Developed By Sameer Khan</p>
      </div>
    </footer>
  </div>
  <script src="action.js"></script>
</body>
</html>