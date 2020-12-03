<?php
//  include("config.php");
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '0') {
        header("location:admin/index.php");
    }
} 

include("Users.php");
 $error = "";
 $check = new Users();
 $db = new config();
 $checksql = $check->select($db->conn);
 if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
	$confirmpassword = $_POST['confirmpassword'];
	if(preg_match('/^[a-zA-Z0-9]{5,30}+$/', $username) == false ) {
		$error = "Please enter valid username";
	} else {
		foreach($checksql as $chk) {
			if($chk['user_name'] == $username) {
				$error = "Username Already exists";
			}
		}
		if($password != $confirmpassword) {
			$error = "Password and Confirm Password did not matched!";
		} elseif($username == '' || $name == '' || $password == '' || $phone == ''){
			$error = 'Please complete the form and then submit';
		}
		else {
			$pass = md5($password);
			$register = new Users();
			$db = new config();
			$sql = $register->signup($username, $name, $phone, '0', $pass, '0', $db->conn);
			echo $sql;
		}
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
		body {
			margin: 0;
			padding: 0;
			font-family: century gothic;
			color: white;
		}

		#main {
			background-image: linear-gradient(#b5b72ecf, grey, black);
			background-size: 100% 100%;
		}

		#jumb {
			position: relative;
			background-color: rgba(0, 0, 0, 0);
			color: white;
		}

		a {
			color: white;
		}

		#abc {
			background-color: rgba(0, 0, 0, 0.1);
			padding: 50px;
			margin-bottom: 100px;
		}

		.form-group {
			padding: 5px 0px;
		}

		.pfooter {
			font-size: 16px;
			font-style: bold;
			color: white;
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
						<a class="navbar-brand" href="index.php"><img src="logo.png" width="100" alt="CedCab"
								class="logoimage" style="margin-top:-40px;"></a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="index.php">Book Cab</a></li>
							<li><a href='login.php'>Login</a></li>
							<li class="active"><a href='signup.php'>Sign Up</a></li>
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
					<a href="index.php"><img style="margin-bottom: -40px;" src="logo.png" alt="" width="100"
							height="100" /></a>
					<!-- <a href="#" onclick="goBack()" class="btn btn-info btn-xs">Back</a> -->
				</center>
				<h2 style="text-align: center;">Register Here</h2>
				<?php
                if($error) {
                    ?>
				<p style="color:red; text-align:center !important;"><?php echo $error; ?></p>
				<?php
                }
            ?>
				<form action="" method="POST">
					<div class="form-group">
						<label for='name'>Name:</label>
						<input type="text" class='form-control' name="name" pattern="[a-zA-Z]+[a-zA-Z\s]*">
					</div>
					<div class="form-group ">
						<label for='username'>Username:</label>
						<input type="text" class='form-control' name="username" pattern="[a-zA-Z][a-zA-Z0-9-_\.]{1,20}">
					</div>
					<div class="form-group ">
						<label for='phone'>Phone:</label>
						<input type="text" class='form-control' name="phone" pattern="[1-9]{1}[0-9]{9}">
					</div>
					<div class="form-group">
						<label for='password'>Password:</label>
						<input type="password" class='form-control' name="password">
					</div>
					<div class="form-group">
						<label for='confirmpassword'>Confirm Password:</label>
						<input type="password" class='form-control' name="confirmpassword">
					</div>
					<div class="form-group " style="padding: 10px 0px;">
						<input type="submit" class="btn btn-success form-control" name="submit" value="Register"
							style="padding: 5px 30px;">
					</div>
					<p class="pfooter">Already have account? <a href="login.php"> Click Here</a></p>
				</form>
			</div>
		</div>
</body>

</html>