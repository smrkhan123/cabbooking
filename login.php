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
                <li><a href="index.php">Book Cab</a></li>
                <li class="active"><a href='login.php'>Login</a></li>
                <li><a href='signup.php'>Sign Up</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- Main Section/ Landing Page -->
    <section id="main">
        <div class="row" id='jumb'>
            <div class="col-md-4 col-lg-4 col-sm-1">
            </div>
            <div class="col-md-4 col-lg-4 col-sm-10" id='abc'>
                <center>
                    <a href="index.php"><img src="logo.png" alt="" width="100"
                            height="100" /></a>
                    <div class="text-center" style="margin-top:20px;">
                        <a href="#" onclick="window.history.back()" class="btn btn-info btn-xs">Back</a>
                    </div>
                </center>
                <h2 style="text-align: center;">Account Login</h2>
                <?php
                if($error) {
                    ?>
                <p id="error"><?php echo $error; ?></p>
                <?php
                }
            ?>
                <form action="login.php" method="POST">
                    <?php 
                    // 
                ?>
                    <div class="form-group">
                        <label for='username'>Username:</label>
                        <input type="text" class='form-control' name="username"
                            value="<?php if(isset($_COOKIE['member'])) { echo $_COOKIE['member']; }?>">
                    </div>
                    <div class="form-group">
                        <label for='password'>Password:</label>
                        <input type="password" class='form-control' name="password">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="rememberme" <?php if(isset($_COOKIE['member'])) {?> checked
                            <?php ; }?>>&nbsp;<label for='password'>Remember me</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success form-control" name="login" value="Login">
                    </div>
                    <!-- <p style="font-size:16px; font-style:bold;color:white;text-align: center; margin-bottom: 20px;">Forget Password? <a href="#"> Click Here</a></p> -->
                    <p id="notaccount">Do not an account? <a
                            href="signup.php"> Click Here</a></p>
                </form>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-1"></div>
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