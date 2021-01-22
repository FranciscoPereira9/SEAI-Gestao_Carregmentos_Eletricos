<?php
include "load_colors.php";
include "db_conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

  $sql = "SELECT * FROM seai.charging ORDER BY charger_id";
  $result = pg_query($conn,$sql);
  $chart_data='';
  while ($row = pg_fetch_array($result)) {
    $charger_id_stats = $row["charger_id"];
    $aux = $charger_id_stats;
    $power  = $row["avg_power"];



    $chart_data  .="{ charger_id:'".$charger_id_stats."', avg_power:".$power."}, ";

  }
  $chart_data = substr ($chart_data, 0, -2);


$fast=0;
$normal=0;
$green=0;
  $sql = "SELECT * FROM seai.charging";
  $result = pg_query($conn,$sql);
  $chart_data_donut='';
  while ($row = pg_fetch_array($result)) {
    if ($row['charge_type']=="t") {
      $fast++;
    }
    if ($row['charge_type_green']=="1") {
      $green++;
    }else {
      $normal++;
    }
}


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HOME</title>

    <script type="text/javascript" src="jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="javascript_states.js"></script>

    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  </head>
  <body >
    <div class="bar">
      <div class="logo">
        <img src="logo_seai.png" alt="">
      </div>
      <div class="user">
        <h1 class="greets">Welcome, <?php echo ($_SESSION['username']) ; ?></h1>
        <a class="logout"href="logout.php">LOGOUT</a>
      </div>

    </div>
<div class="container">
  <div class="options">
    <div class="nav-bar">
      <ul>
        <a href="home.php"><li>Home</li></a>
        <a href="statistics.php"><li class="active">Statistics</li></a>
        <a href="alerts.php"><li>Alerts</li></a>
		<a href="prices.php"><li>Prices</li></a>
    <a href="forced.php"><li>Forced Interrupt</li></a>
      </ul>
    </div>
    <div class="other_stuff1">

          <ul class="lista_charts">
            <li class="charts"><a class="charts1_active" href="statistics.php">General</a></li>
            <li class="charts"><a class="charts1" href="statistics_ind.php">Individual</a></li>
            <li class="charts"><a class="charts1" href="statistics_client.php">Client</a></li>
          </ul>  <a class="no" href="interruption_all.php"><i class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn off</span> </a>


    </div>


  </div>
  <div class="nothing">

  </div>
  <div class="chargers">
    <div class="line1_charts">
      <div class="chart1">
          <h4>Avg Power Per Charging - Analysis</h4>
            <div id="chart"></div>
      </div>
      <div class="chart2">
        <h4>Type of charge count</h4>
          <div id="fast_normal"></div>
      </div>
    </div>


      </div>





  </div>







  </body>
</html>
<script>
  Morris.Bar({
    element : 'chart',
    data:[<?php echo $chart_data ?>],
    xkey: 'charger_id',
    ykeys: ['avg_power'],
    labels: ['avg_power'],
  });

  Morris.Donut({
    element : 'fast_normal',
    colors: [
    '#26C6DA',
    '#B2EBF2',
    'green',
  ],
    data: [
      { label: "Nr. Fast Charging", value: <?php echo $fast; ?>},
      { label: "Nr. Normal Charging", value: <?php echo $normal; ?>},
      { label: "Nr. Green Charging", value: <?php echo $green; ?>}
    ]
  });
</script>
<?php
}else {
  header("Location: index.php");
  exit();
}
 ?>
