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
	<div class="jumbotron" id='jumb'>
		<div class="col-md-3 col-lg-3 col-sm-1">
		</div>
		<div class="col-md-6 col-lg-6 col-sm-10" id='abc'>
			<center>
				<a href="index.php"><img style="margin-bottom: -40px;" src="logo.png" alt="" width="100" height="100"/></a>
			</center>
            <h2 style="text-align: center;">Update Your Profile Here</h2>
            <div class="text-right">
                <a href="index.php" class="btn btn-info">Back</a>
            </div>
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
					<input type="text" class='form-control' name="phone" value="<?php echo $data['mobile']; ?>">
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