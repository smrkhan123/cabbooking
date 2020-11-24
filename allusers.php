<?php
include("Users.php");
$conn = new config();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '1') {
        header("location:index.php");
    }
} else {
    header("location:index.php");
}

if(isset($_GET['update'])){
    $id = $_GET['data'];
    $blck = new Users();
    $db = new config();
    $sql = $blck->block($id, $db->conn);
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
            <a class="navbar-brand" href="#"><img src="logo.png" width="100" alt="CedCab" class="logoimage"></a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li><a href='requestedrides.php'>Requested Rides</a></li>
            <li><a href='pastrides.php'>Past Rides</a></li>
            <li><a href='alllocations.php'>Locations</a></li>
            <li class="active"><a href='allusers.php'>All Users</a></li>
            <li><a href='logout.php'>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- Main Section/ Landing Page -->
    <section id="main">
    <div class="text-center">
        <h2>All Users</h2>
        <p>Here you can Block/Unblock Users</p> 
    </div>
      <div class="container text-center">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">UserName</th>
                    <th class="text-center">Block/Unblock</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $users = new Users();
                $db = new config();
                $sql = $users->select_users('0', $db->conn);
                    while($data = mysqli_fetch_assoc($sql)){
                        $id = $data['user_id'];
                        ?>
                            <tr>
                                <td><?php echo ucfirst($data['user_name']); ?></td>
                                <td><?php if($data['isblock'] == "0"){ echo "Blocked"; } else { echo "Unblocked"; } ?></td>
                                <td><a href="allusers.php?update=1&data=<?php echo $id; ?>" class="btn btn-info">Block/Unblock</a></td>
                            </tr>
                        <?php
                }
            ?>
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