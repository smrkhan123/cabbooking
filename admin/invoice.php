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
$obj1 = new Rides();
$db = new config();
$id = $_GET['id'];
$comp = $obj1->select_invoice($id, $db->conn);
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
          <a class="" href="#"><img src="../logo.png" width="100" alt="CedCab" class="logoimage"
              style="margin-bottom:-40px"></a>
        </li>
        <li>
          <h4><a class="active" style="color:white;" href="index.php">Home</a></h4>
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
          <h4 id="userData"> Hey, <?php echo $_SESSION['username']; ?>
            <a href='../logout.php'>Logout</a>
          </h4>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2 col-lg-2"></div>
          <div class="col-md-8 col-lg-8">
            <div class="row panel panel-default">
              <div class="text-center panel-heading">
                <h1>Invoice</h1>
              </div>
              <div class="panel-body">
                <table class="table">
                  <?php foreach($comp as $data) {
                            ?>
                  <tr>
                    <th>
                      <h3>Date:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php echo $data['ride_date']; ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>Ride Id:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php echo $data['ride_id']; ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>Name:</h3>
                    </th>
                    <td class="text-center">
                      <h3>
                        <?php
                                  $selectUser = new Users();
                                  $users = $selectUser->select_user_id($data['customer_user_id'], $db->conn);
                                  if($users == '0') {
                                    echo "Unknown User";
                                  } else {
                                      foreach($users as $user) {
                                        $username = $user['name'];
                                      }
                                      echo ucfirst($username);
                                  }
                                ?>
                      </h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>From:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php echo ucfirst($data['from']); ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>To:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php echo ucfirst($data['to']); ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>Total Distance:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php echo $data['total_distance']; ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>Cab Type:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php echo ucfirst($data['cabtype']); ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <h3>Luggage:</h3>
                    </th>
                    <td class="text-center">
                      <h3><?php if($data['luggage'] == '') { echo '0KG'; } else { echo $data['luggage']."KG";} ?></h3>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center">
                      <h2>Total fare: </h2>
                    </th>
                    <td class="text-center">
                      <h1><?php echo "Rs.".$data['total_fare']; ?></h1>
                    </td>
                  </tr>
                  <?php
                        } ?>
                </table>
                <p class="text-center" id="printButton"><button class="btn btn-primary"
                    onclick="printScr()">Print</button></p>
              </div>
            </div>
            <div class="col-md-2 col-lg-2"></div>
          </div>
        </div>
      </div>
    </div>
    <script src="../action.js"></script>
    <script>
      function printScr() {
        $('#userData').css('display', 'none');
        $('#printButton').css('display', 'none');
        window.print();
      }
    </script>
</body>

</html>