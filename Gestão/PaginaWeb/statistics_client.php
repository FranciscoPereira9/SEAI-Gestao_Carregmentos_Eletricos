<?php
include "load_colors.php";
include "db_conn.php";


if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

  $sql = "SELECT * FROM seai.charging ORDER BY charger_id";
  $result = pg_query($conn,$sql);
  $chart_data='';
  while ($row = pg_fetch_array($result)) {
    $chart_data  .="{ charger_id:'".$row["charger_id"]."', avg_power:".$row["avg_power"]."}, ";
  }
  $chart_data = substr ($chart_data, 0, -2);


$fast=0;
$normal=0;
  $sql = "SELECT * FROM seai.charging";
  $result = pg_query($conn,$sql);
  $chart_data_donut='';
  while ($row = pg_fetch_array($result)) {
    if ($row['charge_type']=="t") {
      $fast++;
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
            <li class="charts"><a class="charts1" href="statistics.php">General</a></li>
            <li class="charts"><a class="charts1" href="statistics_ind.php">Individual</a></li>
            <li class="charts"><a class="charts1_active"class="charts1" href="statistics_client.php">Client</a></li>
          </ul>  <a class="no" href="interruption_all.php"><i class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn off</span> </a>


    </div>


  </div>
  <div class="nothing">
  </div>
  <div class="chargers_client">
        <h4 class="charging_title">Charging table</h4>
    <div class="tabela">
      <table>
        <tr>
          <th>User ID</th>
          <th>Charger ID</th>
          <th>Starting Time</th>
          <th>Stoping Time</th>
          <th>Starting date</th>
          <th>Ending date</th>
          <th>Total cost</th>
          </tr>
          <?php
             $sql = "SELECT * FROM seai.charging ORDER BY starting_time DESC";
             $result = pg_query($conn, $sql);
                if (pg_num_rows($result)>0) {
                  while ($row = pg_fetch_assoc($result)) {
                      $user_id = $row['id'];
                      $charger_id = $row['charger_id'];
                      $starting_time = $row['starting_time'];
                      $stoping_time = $row['stoping_time'];
                      $starting_date = $row['starting_date'];
                      $ending_date = $row['ending_date'];
                      $total_cost = $row['total_cost'];

                       $all = 0;


                      echo "<tr><td>". $user_id ."</td><td>" .$charger_id ."</td><td>" .$starting_time
                      ."</td><td>". $stoping_time ."</td><td>" . $starting_date ."</td><td>" . $ending_date ."</td>
                      <td>" . $total_cost ."€</td></tr>";
                            }
                           }
                          ?>
      </table>
    </div>


<div class="top">
  <h4>Clients</h4>
  <table class="tabela_clientes">
    <tr>
      <th>User ID</th>
      <th>Times used</th>
      <th>Revenue</th>

      </tr>
      <?php
         $sql = "SELECT * FROM seai.charging";
         $result = pg_query($conn, $sql);
            if (pg_num_rows($result)>0) {
              while ($row = pg_fetch_assoc($result)) {
                  $user_id = $row['id'];
                  $sql1 = "SELECT * FROM seai.charging WHERE id='$user_id'";
                  $result1 = pg_query($conn, $sql1);
                  $a=0;
                  $cost=0;
                  if (pg_num_rows($result1)>0) {
                    while ($row = pg_fetch_assoc($result1)) {
                      $cost=$cost+$row['total_cost'];
                      $a++;
                      echo "<tr><td>". $user_id ."</td><td>". $a ."</td><td>". $cost ."€</td></tr>";
                    }


                        }
                      }}
                      ?>
  </table>
</div>




      </div>





  </div>







  </body>
</html>
<script>

</script>
<?php
}else {
  header("Location: index.php");
  exit();
}
 ?>
