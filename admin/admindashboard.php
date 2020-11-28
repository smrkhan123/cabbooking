<?php
include("../Users.php");
include("../Rides.php");
$conn = new config();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '1') {
        header("location:../index.php");
    }
} else {
    header("location:../index.php");
}
$confirmed_ride = new Rides();
$db = new config();
$comp = $confirmed_ride->select_confirmed_ride($db->conn);
if($comp == '0') {
  $completedrides = 0;
} else {
  $completedrides = 0;
  foreach($comp as $completed) {
    ++$completedrides;
  }
  $total = 0;
  foreach($comp as $price) {
    $total = $total + $price['total_fare'];
  }
}

$pend = $confirmed_ride->select_ride('1', $db->conn);
if($pend == '0') {
  $pendingrides = 0;
} else {
  $pendingrides = 0;
  foreach($pend as $pending) {
    ++$pendingrides;
  }
}
$cancell = $confirmed_ride->select_ride('0', $db->conn);
if($cancell == '0') {
  $cancelledrides = 0;
} else {
  $cancelledrides = 0;
  foreach($cancell as $cancelled) {
  ++$cancelledrides;
  }
}
$obj2 = new Users();
$blockedusers = $obj2->select_pending_users('0', $db->conn);
$pendingusers = 0;
foreach($blockedusers as $blocked) {
  ++$pendingusers;
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
  <link rel="stylesheet" href="../style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>
  <div id="wrap">
        <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand" style="background-color:white;">
          <a class="" href="#"><img src="../logo.png" width="100" alt="CedCab" class="logoimage" style="margin-bottom:-40px"></a>
        </li>
        <li>
            <h4><a class="active" style="color:white;" href="admindashboard.php">Home</a></h4>
        </li>
        <li>
          <h4><a href="#" style="color:white;">Rides</a></h4>
          <a href='requestedrides.php'>Pending Rides</a>
          <a href='pastrides.php'>Compeleted Rides</a>
          <a href='cancelledrides.php'>Cancelled Rides</a>
          <a href='allrides.php'>All Rides</a>
        </li>
        <li>
          <h4><a href="#" style="color:white;">Locations</a></h4>
          <a href='alllocations.php'>All Locations</a>
          <a href='addlocation.php'>Add New Locations</a>
        </li>
        <li>
          <h4><a href="#" style="color:white;">Users</a></h4>
          <a href='pendingusers.php'>Pending User Requests</a>
          <a href='approvedusers.php'>Approved User Requests</a>
          <a href='allusers.php'>All Users</a>
        </li>
        <li>
          <a href='../logout.php'>Logout</a>
        </li>   
      </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div>
        <div class="panel-body text-right">
        <h4> Hey, <?php echo $_SESSION['username']; ?>
          <a href='../logout.php'>Logout</a></h4>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-lg-4">
            <div class="panel" style="background-color:dodgerblue !important;">
              <div class="panel-heading text-center">
                <h3>Pending Rides</h3>
                <h1><?php echo $pendingrides; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="requestedrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel" style="background-color:orange !important;">
              <div class="panel-heading text-center">
                <h3>Pending User Requests</h3>
                <h1><?php echo $pendingusers; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="pendingusers.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel" style="background-color:red !important;">
              <div class="panel-heading  text-center">
                <h3>Cancelled Rides</h3>
                <h1><?php echo $cancelledrides; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="cancelledrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel" style="background-color:green !important;">
              <div class="panel-heading text-center">
                <h3>Total Earning</h3>
                <h1><?php echo $total; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="allrides.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-primary text-center">
              <div class="panel-heading">
                <h3>Completed Rides</h3>
                <h1><?php echo $completedrides; ?></h1>
              </div>
              <div class="panel-footer text-ecnter"><a href="pastrides.php">Click</a> to see more..</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../action.js"></script>
</body>
</html>