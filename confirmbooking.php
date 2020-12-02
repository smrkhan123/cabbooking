<?php
session_start();
include("Locations.php");
include("Rides.php");
if(isset($_SESSION['id'])){
  if(!isset($_SESSION['booking'])){
    header("location: index.php");
  } elseif($_SESSION['usertype'] != '0') {
    header("location:admin/admindashboard.php");
}
} else {
  header("location:index.php");
}
// $loc = new Locations();
// $db = new config();
// $sql = $loc->select_loc($db->conn);
    $from = $_SESSION['booking']['from'];
    $to = $_SESSION['booking']['to'];
    $luggage = $_SESSION['booking']['luggage'];
    $fare = $_SESSION['booking']['fare'];
    $distance = $_SESSION['booking']['total_distance'];
    $cabtype = $_SESSION['booking']['cabtype'];
    $user_id = $_SESSION['id'];
    $status = '1';
    if(isset($_GET['action'])){
      $obj = new Rides();
      $db = new config();
      $sql = $obj->insert($from, $to, $luggage, $fare, $distance, $cabtype, $user_id, $status, $db->conn);
      unset($_SESSION['booking']);
    } 

    if(isset($_GET['cancel'])) {
      unset($_SESSION['booking']);
      header("location:userdashboard.php");
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
            <a class="navbar-brand" href="index.php"><img src="logo.png" width="100" alt="CedCab" class="logoimage"></a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li><a href='userdashboard.php'>Home</a></li>
            <li><a href="index.php">Book Cab</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="previousrides.php">Rides
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="previousrides.php">Completed Rides</a></li>
                <li><a href="pendingrides.php">Pending Rides</a></li>
                <li><a href="cancelledrides.php">Cancelled Rides</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="previousrides.php">Account
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="updateprofile.php">Update Profile</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
              </ul>
            </li>
            <li><a>Hey, &nbsp;<?php echo $_SESSION['username']; ?></a></li>
            <!-- <li><a></a></li> -->
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
                        <?php echo "<a href='confirmbooking.php?action=booked' class='btn btn-success'>Confirm Booking</a>&nbsp;&nbsp;<a href='confirmbooking.php?cancel=1' class='btn btn-danger'>Cancel Booking</a>" ; ?>
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