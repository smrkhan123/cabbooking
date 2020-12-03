<?php
include("Users.php");
include("Rides.php");
$conn = new config();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '0') {
        header("location:admin/index.php");
    } elseif(isset($_SESSION['booking'])){
      header("location:confirmbooking.php");
    }
} else {
    header("location:index.php");
}
$total = 0;
$id = $_SESSION['id'];
$pending = new Rides();
$db = new config();
$pending_rides = $pending->users_data($id, '1', $db->conn);
$pendingrides = 0;
if($pending_rides != '0') {
  foreach($pending_rides as $pend) {
      ++$pendingrides;
  }
}

$completed = new Rides();
$completed_rides = $completed->users_data($id, '2', $db->conn);
$completedrides = 0;
if($completed_rides != '0') {
  foreach($completed_rides as $comp) {
      ++$completedrides;
  }
  foreach($completed_rides as $price) {
      $total = $total + $price['total_fare'];
  }
}

$cancelled = new Rides();
$cancelled_rides = $cancelled->users_data($id, '0', $db->conn);
$cancelledrides = 0;
if($cancelled_rides != '0') {
  foreach($cancelled_rides as $canc) {
      ++$cancelledrides;
  }
} 

$ridesData = new Rides();
$db = new config();
$ridedate = $ridesData->user_rides($id, $db->conn);
$rideData = [];
$rideSpent = [];
if($ridedate != '0') {
  foreach($ridedate as $eachride) {
    $rideData[] = substr($eachride['ride_date'],0,10);
    $rideSpent[] = $eachride['total'];
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
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href='userdashboard.php'>Home</a></li>
              <li><a href="index.php">Book Cab</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="previousrides.php">Rides
                  <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="previousrides.php">Completed Rides</a></li>
                  <li><a href="pendingrides.php">Pending Rides</a></li>
                  <li><a href="cancelledrides.php">Cancelled Rides</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="previousrides.php">Account
                  <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="updateprofile.php">Update Profile</a></li>
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
      <!-- Page Content -->
      <div class="container">
        <div class="panel">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h2>Hi, <?php echo ucfirst($_SESSION['username']);?></h2>
              <a href="index.php" class="btn" style="float:right;margin-top: -45px; background-color:yellow;">Book
                Cab</a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading text-center">
                <h3>Pending Rides</h3>
                <h1><?php echo $pendingrides; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="pendingrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel panel-primary text-center">
              <div class="panel-heading">
                <h3>Completed Rides</h3>
                <h1><?php echo $completedrides; ?></h1>
              </div>
              <div class="panel-footer text-ecnter"><a href="previousrides.php">Click</a> to see more..</div>
            </div>
          </div>

          <div class="col-md-3 col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading text-center">
                <h3>Cancelled Rides</h3>
                <h1><?php echo $cancelledrides; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="cancelledrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                <h3>Total Spent</h3>
                <h1>Rs. <?php echo $total;?></h1>
              </div>
              <div class="panel-footer text-center"><a href="previousrides.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-6">
            <buttton class="btn btn-xs btn-success" onclick=showchart(0)>Bar Chart</buttton>
            <buttton class="btn btn-xs btn-info" onclick=showchart(1)>Line Chart</buttton>
            <canvas id="myChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer Section/ Landing Page -->
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script type="text/javascript">
    var ride_dates = <?php echo json_encode($rideData); ?>;
    var ride_spent = <?php echo json_encode($rideSpent); ?>;
    //for displaying line chart
    show('line');
    function showchart(type) {
      if (type == 0) {
        show('bar');
      } else {
        show('line');
      }
      // console.log(type);
    }
    function show(showType) {
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: showType,
        data: {
          labels: ride_dates,
          datasets: [{
            label: 'This Day Total Spent',
            data: ride_spent,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    }

  </script>
</body>

</html>