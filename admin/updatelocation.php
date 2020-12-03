<?php
include("../Users.php");
include("../Locations.php");
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '1') {
        header("location:../index.php");
    }
} else {
    header("location:../index.php");
}
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $distance = $_POST['distance'];
    $isavailable = $_POST['isavailable'];
    $obj = new Locations();
    $db = new config();
    $sql = $obj->update_loc($id, $name, $distance, $isavailable, $db->conn);
    if($sql){
      header("location: alllocations.php");
    } else {
        echo "<script>alert('error')</script>";
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
  <link rel="stylesheet" href="../style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
  <style>
    .form-group {
      text-align: left;
    }
  </style>
</head>

<body>
  <div id="wrap">
    <!-- Sidebar Section -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand" style="background-color:white;">
          <a class="" href="#"><img src="../logo.png" width="100" alt="CedCab" class="logoimage"
              style="margin-bottom:-40px"></a>
        </li>
        <li>
          <h4><a style="color:white;" href="index.php">Home</a></h4>
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
          <a class="active" href='addlocation.php'>Add New Locations</a>
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
    <!-- Main Section/ Landing Page -->
    <section id="main">
      <div>
        <div class="panel-body text-right">
          <h4> Hey, <?php echo $_SESSION['username']; ?>
            <a href='../logout.php'>Logout</a></h4>
        </div>
      </div>
      <div class="text-center">
        <h2>Edit Location</h2>
        <p>Here you can Edit Location</p>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <form class="form" action="updatelocation.php" method="POST">
              <?php
                    $obj = new Locations();
                    $db = new config();
                    $id = $_GET['id'];
                    $val = $obj->select_loc_id($id, $db->conn);
                ?>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="hidden" class="form-control" name="id" value="<?php echo $val['id']; ?>">
                <input type="text" class="form-control" name="name" value="<?php echo $val['name']; ?>">
              </div>
              <div class="form-group">
                <label for="distance">Distance From Charbagh</label>
                <input type="number" class="form-control" name="distance" value="<?php echo $val['distance']; ?>">
              </div>
              <div class="form-group">
                <label for="isavailable">Availibility</label>
                <select name="isavailable" id="isavailable" class="form-control">
                  <option value="1" <?php if($val['is_available']=='1'){?>selected<?php ;} ?>>Available</option>
                  <option value="0" <?php if($val['is_available']=='0'){?>selected<?php ;} ?>>Unavailable</option>
                </select>
              </div>
              <div class="form-group">
                <input type="submit" class="form-control btn btn-success" name="update" value="Update">
              </div>
            </form>
          </div>
          <div class="col-md-3"></div>
        </div>
        <div class="text-center">
          <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
        </div>
      </div>
    </section>
    <footer>
      <div class="sect10 text-center">
        <div class="container" style="width:80%;">
          <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 socialIcons text-center">
              <img src="../logo.png" width="100" alt="CedCab">
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
  <script src="../action.js"></script>
</body>

</html>