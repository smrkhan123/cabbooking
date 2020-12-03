<?php
//  include("config.php");

include("Users.php");
if(isset($_SESSION['id'])){
	if($_SESSION['usertype'] != '0') {
		header("location:admin/index.php");
		}
	} else {
	header("location:../index.php");
	}
 $error = "";
 if(isset($_POST['submit'])) {
	$password = $_POST['password'];
	$confirm_password = $_POST['confirmpassword'];
	if($password != $confirm_password){

        $error = "Password and Confirm Password did not matched!";
	} else {
		$obj = new Users();
		$db = new config();
		$sql1 = $obj->select_user_id($_SESSION['id'], $db->conn);
		foreach($sql1 as $data){
            $username = $data['user_name'];
            $name = $data['name'];
            $phone = $data['mobile'];
            $isblock = $data['isblock'];
            $oldpassword = $data['password'];
            $pass = md5($password);
            $role = $data['isadmin'];
        }
        if($pass == $oldpassword){
          echo "<script>alert('Old Password and New Password cannot be same');</script>";
          echo "<script>window.location.href = 'changepassword.php';</script>";
        } else {
          $register = new Users();
          $sql = $register->update_password($_SESSION['id'], $username, $name, $phone, $isblock, $pass, $role, $db->conn);
          if($sql == '1') {
          session_start();
          session_destroy();
          echo "<script>alert('Your password is successfully Changed!');</script>";
          echo "<script>window.location.href = 'login.php';</script>";
        }   
		  }
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
  <link rel="stylesheet" href="formstyle.css">
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
            <ul class="nav navbar-nav navbar-right">
                <li><a href='userdashboard.php'>Home</a></li>
                <li><a href="index.php">Book Cab</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="previousrides.php">Rides
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="active"><a href="previousrides.php">Completed Rides</a></li>
                        <li><a href="pendingrides.php">Pending Rides</a></li>
                        <li><a href="cancelledrides.php">Cancelled Rides</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="previousrides.php">Account
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="active"><a href="updateprofile.php">Update Profile</a></li>
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
        <div class="row" id='jumb'>
        <div class="col-md-3 col-lg-3 col-sm-1">
      </div>
      <div class="col-md-6 col-lg-6 col-sm-10" id='abc'>
        <center>
          <a href="index.php"><img style="margin-bottom: -40px;" src="logo.png" alt="" width="100" height="100" /></a>
        </center>
        <h2 style="text-align: center;">Update Password Here</h2>
        <?php
                if($error) {
                    ?>
        <p style="color:red; text-align:center !important;"><?php echo $error; ?></p>
        <?php
                }
            ?>
        <form action="" method="POST">
          <div class="form-group">
            <label for='password'>Password:</label>
            <input type="password" class='form-control' name="password">
          </div>
          <div class="form-group">
            <label for='confirmpassword'>Confirm Password:</label>
            <input type="password" class='form-control' name="confirmpassword">
          </div>
          <div class="form-group " style="padding: 10px 0px;">
            <input type="submit" class="btn btn-success form-control" name="submit" value="Update"
              style="padding: 5px 30px;">
          </div>
          <!-- <p class="pfooter">Already have account? <a href="login.php"> Click Here</a></p> -->
        </form>
      </div>
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