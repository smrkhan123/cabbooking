<?php
session_start();
include("Locations.php");
include("Rides.php");
if(isset($_SESSION['id'])){
  if($_SESSION['usertype'] != '0') {
      header("location:admin/index.php");
  } elseif(isset($_SESSION['booking'])) {
    header("location:confirmbooking.php");
  }
}
if(isset($_POST['submit'])){
    $from = $_POST['pickup'];
    $to = $_POST['drop'];
    $luggage = isset($_POST['luggage'])?$_POST['luggage']:"";
    $fare = $_POST['fare'];
    $cabtype = $_POST['cab_type'];
    $distance = $_POST['distance'];
  if(!isset($_SESSION['id'])) {
    header("location: login.php");
  } else {
    $user_id = $_SESSION['id'];
    $status = '1';
    $obj = new Rides();
    $db = new config();
    $sql = $obj->insert($from, $to, $luggage, $fare, $distance, $cabtype, $user_id, $status, $db->conn);
  }
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
              <?php 
                if(isset($_SESSION['id'])) { 
                  ?>
              <li><a href='userdashboard.php'>Home</a></li>
              <li class="active"><a href="#main">Book Cab</a></li>
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
              <li><a href='logout.php'>Logout</a></li>
              <?php } else {
                  echo "<li class='active'><a href='#main'>Book Cab</a></li><li><a href='login.php'>Login</a></li><li><a href='signup.php'>Sign Up</a></li>";
                }
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- Main Section/ Landing Page -->
    <section id="main">
      <div style="position: relative;">
        <img src="a.jpg" class='bg' alt="">
        <div class="container content">
          <div class="heading"></div>
          <h1 class="heading1">Book a Taxi to a destination in a Town</h1>
          <p class="para1">Choose from range of categories and prices</p>
          <div class="row">
            <div class="col-sm-2 col-md-1 col-lg-1"></div>
            <div class="col-sm-8 col-md-5 col-lg-5">
              <div class="formlogo">
                <div class="text-center"><img src="logo.png" width="100" alt="CedCab"></div>
              </div>
              <h3 class="heading3"><strong>Your Everyday travel Partner</strong></h3>
              <p class="para2">AC Cabs for time to time travel</p>
              <form class="form-horizontal myform" action="" method="POST">
                <div class="form-group ">
                  <div class="col-sm-10">
                    <select name="pickup" id="pickup" class="form-control" onchange="loc()">
                      <option value="">Select Your Pickup Location</option>
                      <?php
                        $loc = new Locations();
                        $db = new config();
                        $sql = $loc->select($db->conn);
                        while($data = mysqli_fetch_assoc($sql)){
                          ?>
                      <option value="<?php echo $data['name']; ?>"><?php echo ucfirst($data['name']); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-10">
                    <select name="drop" id="drop" class="form-control" onchange="droploc()">
                      <option value="">Select Your Drop Location</option>
                      <?php
                        $loc = new Locations();
                        $sql = $loc->select($db->conn);
                        while($data = mysqli_fetch_assoc($sql)){
                          ?>
                      <option value="<?php echo $data['name']; ?>"><?php echo ucfirst($data['name']); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-10">
                    <select name="cab_type" id="cab_type" class="form-control" onchange="cabType()">
                      <option value="">Drop Down To Select Cab Type</option>
                      <option value="cedmicro">CedMicro</option>
                      <option value="cedmini">CedMini</option>
                      <option value="cedroyal">CedRoyal</option>
                      <option value="cedsuv">CedSuv</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="luggage" id="luggage"
                      placeholder="Enter luggage weight In KG">
                  </div>
                </div>
                <input type="hidden" name="fare" id="buttonfare">
                <input type="hidden" name="distance" id="distanceinput">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" id="calculatedFare" class="btn btn-default form-control sub_btn"
                      onclick="farecalc()">Calculate Fare</button>
                  </div>
                  <div class="col-sm-offset-2 col-sm-10 subButton" style="margin-top:10px;">
                    <button type="submit" id="booknow" name="submit" class="btn btn-default form-control sub_btn">Book
                      Now</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-sm-2 col-md-6 col-lg-6"></div>
          </div>
        </div>
      </div>
      <div class="bg_overlay"></div>
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
              <a href="#">About Us</a>
              <a href="#">Contact Us</a>
              <a href="#">Help</a>
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