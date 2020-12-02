<?php
//  include("config.php");

include("Users.php");
if(isset($_SESSION['id'])){
	if($_SESSION['usertype'] != '0') {
		header("location:admin/admindashboard.php");
		}
	} else {
	header("location:../index.php");
	}
 $error = "";
 if(isset($_POST['submit'])) {
    $name = $_POST['name'];
	$phone = $_POST['phone'];
    if($name == '' || $phone == ''){
        $error = 'Please complete the form and then submit';
    } 
    else {
		$obj = new Users();
		$db = new config();
		$sql1 = $obj->select_user_id($_SESSION['id'], $db->conn);
		$data = mysqli_fetch_assoc($sql1);
		$username = $data['user_name'];
		$isblock = $data['isblock'];
		$pass = $data['password'];
		$role = $data['isadmin'];
        $register = new Users();
        $sql = $register->update($_SESSION['id'], $username, $name, $phone, $role, $pass, $isblock, $db->conn);
        echo $sql;
    }
 }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style type="text/css">
	body{
		margin: 0;
		padding: 0;
		font-family:century gothic;
		color:white;
	}
	#main{
		background-image:linear-gradient(#b5b72ecf,grey,black);
		background-size:100% 100%;
	}
	#jumb{
		position:relative;
		background-color: rgba(0,0,0,0);
		color:white;
	}
	a{
		color:white;
	}
	#abc{
		background-color: rgba(0,0,0,0.1);
		padding: 50px;
		margin-bottom:100px;
    }
    .form-group {
        padding: 5px 0px;
    }
    .pfooter {
        font-size:16px;
        font-style:bold;
        color:white;
        text-align: center;
    }
	</style>
</head>
<body>
<div class="container-fluid" id='main'>
	<header>
      <nav class="navbar navbar-default" style="background: bottom; border: 0px;">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="logo.png" width="100" alt="CedCab" class="logoimage" style="margin-top:-40px;"></a>
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
                <li class="active"><a href="previousrides.php">Completed Rides</a></li>
                <li><a href="pendingrides.php">Pending Rides</a></li>
                <li><a href="cancelledrides.php">Cancelled Rides</a></li>
              </ul>
            </li>
            <li class="dropdown" style="background-color:#e7e7e7;">
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
	<div class="jumbotron" id='jumb'>
		<div class="col-md-3 col-lg-3 col-sm-1">
		</div>
		<div class="col-md-6 col-lg-6 col-sm-10" id='abc'>
			<center>
				<a href="index.php"><img style="margin-bottom: -40px;" src="logo.png" alt="" width="100" height="100"/></a>
			</center>
            <h2 style="text-align: center;">Update Your Profile Here</h2>
            <?php
                if($error) {
                    ?>
                        <p style="color:red; text-align:center !important;"><?php echo $error; ?></p>
                    <?php
                }
            ?>
			<form action="" method="POST">
				<?php
				$obj = new Users();
				$db = new config();
				$sql = $obj->select_user_id($_SESSION['id'], $db->conn);
				$data = mysqli_fetch_assoc($sql);
				?>
				<div class="form-group">
					<label for='name'>Name:</label>
					<input type="text" class='form-control' name="name" value="<?php echo $data['name']; ?>">
				</div>
				<div class="form-group ">
					<label for='phone'>Phone:</label>
					<input type="text" class='form-control' name="phone" value="<?php echo $data['mobile']; ?>" pattern="[1-9]{1}[0-9]{9}">
                </div>
				<div class="form-group " style="padding: 10px 0px;">
					<input type="submit" class="btn btn-success form-control"  name="submit" value="Update" style="padding: 5px 30px;">
				</div>
				<!-- <p class="pfooter">Already have account? <a href="login.php"> Click Here</a></p> -->
			</form>
	</div>
</div>
</body>
</html>