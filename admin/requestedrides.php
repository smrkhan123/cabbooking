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

if(isset($_GET['data'])){
    $id = $_GET['id'];
    $data = $_GET['data'];
    $blck = new Rides();
    $db = new config();
    $sql = $blck->update($id, $data, $db->conn);
}

if(isset($_GET['data'])){
  $data = $_GET['data'];
  $id = $_GET['id'];
  $blck = new Rides();
  $db = new config();
  $sql = $blck->update($id, $data, $db->conn);
}
if(isset($_GET['sort'])){
  $order = $_GET['sort'];
  $sort = $_GET['val'];
  $obj = new Rides();
  $db = new config();
  $final = $obj->sort_statuswise('1', $sort, $order, $db->conn);
  // echo $final;
  // die();
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
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
  <style>
    .caret {
      margin: 2px;
      margin-left: 5px;
    }

    .caret-dropup {
      transform: rotate(180deg);
    }
  </style>
</head>

<body>
  <div id="wrap">
    <!-- Header Section -->
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
          <a class="active" href='requestedrides.php'>Pending Rides</a>
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
    <!-- Main Section/ Landing Page -->
    <section id="main">
      <div>
        <div class="panel-body text-right">
          <h4> Hey, <?php echo $_SESSION['username']; ?>
            <a href='../logout.php'>Logout</a></h4>
        </div>
      </div>
      <div class="container text-center">
        <h2>Requested Rides</h2>
        <p>Here you can Manage Requested Rides</p>
      </div>
      <div class="container text-center">
        <table class="container table table-striped" style="width:85%;">
          <thead>
            <tr>
              <th class="text-center">S.no</th>
              <th class="text-center">
                Date
                <a href="requestedrides.php?sort=ASC&val=ride_date">
                  <p class="caret"></p>
                </a>
                <a href="requestedrides.php?sort=DESC&val=ride_date">
                  <p class="caret caret-dropup"></p>
                </a>
              </th>
              <th class="text-center">From</th>
              <th class="text-center">To</th>
              <th class="text-center">
                Total Distance
                <a href="requestedrides.php?sort=ASC&val=total_distance">
                  <p class="caret"></p>
                </a>
                <a href="requestedrides.php?sort=DESC&val=total_distance">
                  <p class="caret caret-dropup"></p>
                </a>
              </th>
              <th class="text-center">Luggage</th>
              <th class="text-center">Cab Type</th>
              <th class="text-center">
                Total Fare
                <a href="requestedrides.php?sort=ASC&val=total_fare">
                  <p class="caret"></p>
                </a>
                <a href="requestedrides.php?sort=DESC&val=total_fare">
                  <p class="caret caret-dropup"></p>
                </a>
              </th>
              <th class="text-center">Customer Id</th>
              <th class="text-center" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(isset($_GET['sort'])) {
              $sql = $final; 
            } else {
                $rides = new Rides();
                $db = new config();
                $sql = $rides->select_ride('1', $db->conn);
            }
                  $price = 0;
                  $i = 1;
                    foreach($sql as $data){
                        ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo ucfirst($data['ride_date']); ?></td>
              <td><?php echo ucfirst($data['from']); ?></td>
              <td><?php echo ucfirst($data['to']); ?></td>
              <td><?php echo ucfirst($data['total_distance']); ?></td>
              <td><?php if($data['luggage'] == "") { echo '0'; } else { echo $data['luggage'];} ?></td>
              <td><?php echo ucfirst($data['cabtype']); ?></td>
              <td><?php echo ucfirst($data['total_fare']); ?></td>
              <td><?php echo ucfirst($data['customer_user_id']); ?></td>
              <td>
                <a href="requestedrides.php?data=approve&id=<?php echo $data['ride_id']; ?>"
                  class="btn btn-success btn-xs">Approve</a>&nbsp;
                <a href="requestedrides.php?data=cancel&id=<?php echo $data['ride_id']; ?>"
                  class="btn btn-danger btn-xs">Cancel</a></td>
            </tr>
            <?php
                }
            ?>
          </tbody>
        </table>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
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
  </div>
  <script src="../action.js"></script>
</body>

</html>