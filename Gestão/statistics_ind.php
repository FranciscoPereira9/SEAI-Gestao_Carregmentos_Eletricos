<?php
include "load_colors.php";
include "db_conn.php";
include "functions.php";

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
$green=0;
  $sql = "SELECT * FROM seai.charging";
  $result = pg_query($conn,$sql);
  $chart_data_donut='';
  while ($row = pg_fetch_array($result)) {
    if ($row['charge_type']=="t") {
      $fast++;
    }  if ($row['charge_type_green']=="1") {
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
            <li class="charts"><a class="charts1"href="statistics.php">General</a></li>
            <li class="charts"><a  class="charts1_active" class="charts1" href="statistics_ind.php">Individual</a></li>
            <li class="charts"><a class="charts1" href="statistics_client.php">Client</a></li>
          </ul>  <a class="no" href="interruption_all.php"><i class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn off</span> </a>


    </div>


  </div>
  <div class="nothing">

  </div>
  <div class="chargers_chart">

<div class="selector">
  <span class="select_charger">Select charger </span> <Select id="colorselector">
    <option value="none">none</option>
    <?php
    $a=1;
    while ($a <= 10) {
      ?> <option value="<?php echo $a; ?>"><?php echo $a; ?></option>
      <?php
  $a++;  } ?>
  </Select>
</div>


  <span class="title"> <b>Fast VS Normal charging</b></span>

<?php $b=1;while ($b <= 10) {
  ?><div class="wrapper1">
    <div id="<?php echo $b;?>" class="count_charger_type" style="display:none;width:auto;position:fixed"></div>

  </div>

<?php $fast = count_fast($b); $normal = count_normal($b);  ?>
<script>
Morris.Donut({
  element : '<?php echo $b; ?>',
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
$b++;
} ?>



      </div>


<div class="avg">

  Select Charger <Select id="id">
    <option value="">none</option>
     <option value="a">1</option>
     <option value="b">2</option>
     <option value="c">3</option>
     <option value="d">4</option>
     <option value="e">5</option>
     <option value="f">6</option>
     <option value="g">7</option>
     <option value="h">8</option>
     <option value="i">9</option>
     <option value="j">10</option>
  </Select>
  <h4 class="avg_info">Detailed information:</h4>
  <div class="avg_info_detailed">
    <div id="a" class="colors" style="display:none"> <?php $res =  count_avg_power(1); $times_used = times_used(1); $time = amout_time_avg(1);?><h3>Charger 1:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="b" class="colors" style="display:none"> <?php $res =  count_avg_power(2); $times_used = times_used(2); $time = amout_time_avg(2);?><h3>Charger 2:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="c" class="colors" style="display:none"> <?php $res =  count_avg_power(3); $times_used = times_used(3); $time = amout_time_avg(3);?><h3>Charger 3:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="d" class="colors" style="display:none"> <?php $res =  count_avg_power(4); $times_used = times_used(4); $time = amout_time_avg(4);?><h3>Charger 4:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="e" class="colors" style="display:none"> <?php $res =  count_avg_power(5); $times_used = times_used(5); $time = amout_time_avg(5);?><h3>Charger 5:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="f" class="colors" style="display:none"> <?php $res =  count_avg_power(6); $times_used = times_used(6); $time = amout_time_avg(6);?><h3>Charger 6:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="g" class="colors" style="display:none"> <?php $res =  count_avg_power(7); $times_used = times_used(7); $time = amout_time_avg(7);?><h3>Charger 7:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="h" class="colors" style="display:none"> <?php $res =  count_avg_power(8); $times_used = times_used(8); $time = amout_time_avg(8);?><h3>Charger 8:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="i" class="colors" style="display:none"> <?php $res =  count_avg_power(9); $times_used = times_used(9); $time = amout_time_avg(9);?><h3>Charger 9:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
    <div id="j" class="colors" style="display:none"> <?php $res =  count_avg_power(10); $times_used = times_used(10); $time = amout_time_avg(10);?><h3>Charger 10:</h3><h5>This charger was used <?php echo $times_used; ?> times</h5><h5>Average power : <?php echo number_format($res, 2);?> W</h5>
    <h5> Avg Charging time : <?php echo $time;?></h5></div>
  </div>

</div>





  </div>







  </body>
</html>
<script>
$(function() {
    $('#colorselector').change(function(){
        $('.count_charger_type').hide();
        $('#' + $(this).val()).show();
    });
});


    $(function() {
        $('#id').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
        });
    });

</script>
<?php
}else {
  header("Location: index.php");
  exit();
}
 ?>
