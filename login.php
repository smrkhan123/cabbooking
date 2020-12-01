<?php
include('Users.php');
$error = '';
if (isset($_SESSION['id'])) {
    header("location:index.php");
} else {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
		$pass = $_POST['password'];
		$remember = isset($_POST['rememberme'])?$_POST['rememberme']:"";
		$user = new Users();
		$db = new config();
		$sql = $user->login($username, $pass, $remember, $db->conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
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
		padding: 40px;
		margin-bottom:100px;
	}
	</style>
</head>
<body>
<div class="container-fluid" id='main'>
	<div class="container jumbotron" id='jumb'>
		<div class="col-md-4 col-lg-4 col-sm-1">
		</div>
		<div class="col-md-4 col-lg-4 col-sm-10" id='abc'>
			<center>
				<img src="logo.png" alt="" style="margin-bottom: -40px;" width="100" height="100"/>
			</center>
			<h2 style="text-align: center;">Account Login</h2>
			<?php
				if($error) {
                    ?>
                        <p style="color:red; text-align:center !important;"><?php echo $error; ?></p>
                    <?php
                }
			?>
			<form action="login.php" method="POST">
				<?php 
					// 
				?>
				<div class="form-group" style="padding: 5px 0px;">
					<label for='username'>Username:</label>
					<input type="text" class='form-control' name="username" value="<?php if(isset($_COOKIE['member'])) { echo $_COOKIE['member']; }?>">
				</div>
				<div class="form-group" style="padding: 5px 0px;">
					<label for='password'>Password:</label>
					<input type="password" class='form-control' name="password">
				</div>
				<div class="form-group" style="padding: 5px 0px;">
					<input type="checkbox" name="rememberme" <?php if(isset($_COOKIE['member'])) {?> checked <?php ; }?>>&nbsp;<label for='password'>Remember me</label>
				</div>
				<div class="form-group" style="padding: 10px 0px;">
					<input type="submit" class="btn btn-success form-control"  name="login" value="Login" style="padding: 5px 30px;">
				</div>
				<p style="font-size:16px; font-style:bold;color:white;text-align: center; margin-bottom: 20px;">Forget Password? <a href="#"> Click Here</a></p>
				<p style="font-size:16px; font-style:bold;color:white;text-align: center;">Do not an account? <a href="signup.php"> Click Here</a></p>
			</form>
		</div>
		<div class="col-md-4 col-lg-4 col-sm-1"></div>
	</div>
</div>
</body>
</html>