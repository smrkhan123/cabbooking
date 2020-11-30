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
$confirmed_ride = new Rides();
$db = new config();
$comp = $confirmed_ride->select_confirmed_ride($db->conn);
if($comp == '0') {
  $completedrides = 0;
} else {
  $completedrides = 0;
  foreach($comp as $completed) {
    ++$completedrides;
  }
  $total = 0;
  foreach($comp as $price) {
    $total = $total + $price['total_fare'];
  }
}

$pend = $confirmed_ride->select_ride('1', $db->conn);
if($pend == '0') {
  $pendingrides = 0;
} else {
  $pendingrides = 0;
  foreach($pend as $pending) {
    ++$pendingrides;
  }
}
$cancell = $confirmed_ride->select_ride('0', $db->conn);
if($cancell == '0') {
  $cancelledrides = 0;
} else {
  $cancelledrides = 0;
  foreach($cancell as $cancelled) {
  ++$cancelledrides;
  }
}
$obj2 = new Users();
$blockedusers = $obj2->select_pending_users('0', $db->conn);
$pendingusers = 0;
foreach($blockedusers as $blocked) {
  ++$pendingusers;
}
$obj2 = new Users();
$blockedusers = $obj2->select_pending_users('1', $db->conn);
$approvedusers = 0;
foreach($blockedusers as $blocked) {
  ++$approvedusers;
}
$chart_rides = array($completedrides,$cancelledrides,$pendingrides);
$chart_users = array($approvedusers,$pendingusers);

$ride_dates = new Rides();
$db = new config();
$ridedate = $ride_dates->fetchRidedates($db->conn);
$rideData = [];
$rideEarning = [];
foreach($ridedate as $eachride) {
  $rideData[] = substr($eachride['ride_date'],0,10);
  $rideEarning[] = $eachride['total'];
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
</head>
<body>
  <div id="wrap">
        <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand" style="background-color:white;">
          <a class="" href="#"><img src="../logo.png" width="100" alt="CedCab" class="logoimage" style="margin-bottom:-40px"></a>
        </li>
        <li>
            <h4><a class="active" style="color:white;" href="admindashboard.php">Home</a></h4>
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
        <h4> Hey, <?php echo $_SESSION['username']; ?>
          <a href='../logout.php'>Logout</a></h4>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-lg-4">
            <div class="panel" style="background-color:dodgerblue !important;">
              <div class="panel-heading text-center">
                <h3>Pending Rides</h3>
                <h1><?php echo $pendingrides; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="requestedrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel" style="background-color:orange !important;">
              <div class="panel-heading text-center">
                <h3>Pending User Requests</h3>
                <h1><?php echo $pendingusers; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="pendingusers.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel" style="background-color:red !important;">
              <div class="panel-heading  text-center">
                <h3>Cancelled Rides</h3>
                <h1><?php echo $cancelledrides; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="cancelledrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel" style="background-color:green !important;">
              <div class="panel-heading text-center">
                <h3>Total Earning</h3>
                <h1><?php echo $total; ?></h1>
              </div>
              <div class="panel-footer text-center"><a href="allrides.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-primary text-center">
              <div class="panel-heading">
                <h3>Completed Rides</h3>
                <h1><?php echo $completedrides; ?></h1>
              </div>
              <div class="panel-footer text-ecnter"><a href="pastrides.php">Click</a> to see more..</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div id="piechart"></div>
          </div>
          <div class="col-md-6 col-lg-6">
            <div id="piechartusers"></div>
          </div>
        </div>
        <buttton class="btn btn-xs btn-success" onclick=showchart(0)>Bar Chart</buttton>
        <buttton class="btn btn-xs btn-info" onclick=showchart(1)>Line Chart</buttton>
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
  <script src="../action.js"></script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script type="text/javascript">
    var rides = <?php echo json_encode($chart_rides); ?>;
    var users = <?php echo json_encode($chart_users); ?>;
    var ride_dates = <?php echo json_encode($rideData); ?>;
    var ride_earning = <?php echo json_encode($rideEarning); ?>;

    //for displaying all rides data
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
      ['Rides', 'All rides till date'],
      ['Completed', rides[0]],
      ['Cancelled', rides[1]],
      ['Pending', rides[2]],
    ]);

      // Optional; add a title and set the width and height of the chart
      var options = {'title':'Total Rides', 'width':550, 'height':400};

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }

    //for displaying all users data
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(dChart);

    // Draw the chart and set the chart values
    function dChart() {
      var data = google.visualization.arrayToDataTable([
      ['Users', 'All Blocked/Unblocked Users'],
      ['Active', users[0]],
      ['Blocked', users[1]],
    ]);

      // Optional; add a title and set the width and height of the chart
      var options = {'title':'Total Users', 'width':550, 'height':400};

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechartusers'));
      chart.draw(data, options);
    }


    //for displaying line chart
    show('line');
    function showchart(type) {
      if(type == 0) {
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
                  label: 'Earning On Given Date',
                  data: ride_earning,
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
