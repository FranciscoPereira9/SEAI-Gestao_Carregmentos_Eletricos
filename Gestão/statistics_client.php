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
        <h1 class="greets">Bem vindo, <?php echo ($_SESSION['username']) ; ?></h1>
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
    <div class="tabela">
      <table>
        <tr>
          <th>Name</th>
          <th>E-mail</th>
          <th>User Type</th>
          <th>Total Charging time</th>
          <th>Average charging time</th>
          </tr>
          <?php
             $sql = "SELECT * FROM seai.user";
             $result = pg_query($conn, $sql);
                if (pg_num_rows($result)>0) {
                  while ($row = pg_fetch_assoc($result)) {
                      $user_id = $row['id'];
                       $sql1 = "SELECT * FROM seai.charging WHERE	user_id = '$user_id'";
                       $result1 = pg_query($conn, $sql1);
                       $all = 0;
                       if (pg_num_rows($result1)>0) {
                         while ($row1 = pg_fetch_assoc($result1)) {
                            $starting_time = $row1['starting_time'];
                            $datetime2=0;
                              // VER ISTO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                            $all =  $all +  $datetime2;
                            $datetime2 = strtotime($all);
                            $data_min = $datetime2 / 60;
                            $formattedmin = number_format($data_min);
                            $data_seg = $datetime2 - ($formattedmin*60);
                            $data_fin = "$formattedmin"." min and "."$data_seg"." sec";
                            }
                         }

                      echo "<tr><td>". $row['name'] ."</td><td>" .$row['email'] ."</td><td>" .$row['user_type']
                      ."</td><td>". $data_fin ."</td><td>" . $row['email'] ."</td></tr>";
                            }
                           }
                          ?>
      </table>
    </div>


<div class="top">
  <h4>Top 3 clients</h4>

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
