<?php
include "load_colors.php";
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {


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
        <a href="home.php"><li class="active">Home</li></a>
        <a href="statistics.php"><li>Statistics</li></a>
      </ul>
    </div>
    <div class="other_stuff">
      <h6>Active Chargers -  <i class="fas fa-plug"><span id="active_chargers"></span> </i></h6>
      <a href="interruption_all.php"><i class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn off</span> </a>


    </div>


  </div>
  <div class="nothing">

  </div>
  <div class="chargers">
      <div class="charger1">
        <div id="state1">
          <div class="value1">
            <p class="teste"></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span>Charger<span id="chargerid1"></span></span>
        <a href="interruption.php?id=<?php echo $chargerid1; ?>"><i class="fas fa-toggle-off"></i></a>
      </div>
      <div class="info1">
        <p>Voltage Inst. = <span id="voltage_inst1"></span> </p>
        <p>Curr Inst. = <span id="current_inst1"></span></p>
        <p>Curr max = <span id="max_curr1"></span> </p>
        <p>Charging id = <span id="charging_id1"></span> </p>
      </div>
      <div class="charger2">
        <div id="state2">
          <div class="value2">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span>Charger<span id="chargerid2"></span></span>
        <a href="interruption.php?id=<?php echo $chargerid2; ?>"><i class="fas fa-toggle-off"></i></a>
      </div>
      <div class="info1">
        <p>Voltage Inst. = <span id="voltage_inst2"></span> </p>
        <p>Curr Inst. = <span id="current_inst2"></span></p>
        <p>Curr max = <span id="max_curr2"></span> </p>
        <p>Charging id = <span id="charging_id2"></span> </p>
      </div>
      <div class="charger3">
        <div id="state3">
          <div class="value3">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span>Charger<span id="chargerid3"></span></span>
        <a href="interruption.php?id=<?php echo $chargerid3; ?>"><i class="fas fa-toggle-off"></i></a>
      </div>
      <div class="info1">
        <p>Voltage Inst. = <span id="voltage_inst3"></span> </p>
        <p>Curr Inst. = <span id="current_inst3"></span></p>
        <p>Curr max = <span id="max_curr3"></span> </p>
        <p>Charging id = <span id="charging_id3"></span> </p>
      </div>
      <div class="charger4">
        <div id="state4">
          <div class="value4">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span>Charger<span id="chargerid4"></span></span>
        <a href="interruption.php?id=<?php echo $chargerid4; ?>"><i class="fas fa-toggle-off"></i></a>
      </div>
      <div class="info1">
        <p>Voltage Inst. = <span id="voltage_inst4"></span> </p>
        <p>Curr Inst. = <span id="current_inst4"></span></p>
        <p>Curr max = <span id="max_curr4"></span> </p>
        <p>Charging id = <span id="charging_id4"></span> </p>
      </div>
      <div class="charger5">
        <div id="state5">
          <div class="value5">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span>Charger<span id="chargerid5"></span></span>
        <a href="interruption.php?id=<?php echo $chargerid5; ?>"><i class="fas fa-toggle-off"></i></a>
      </div>
      <div class="info1">
        <p>Voltage Inst. = <span id="voltage_inst5"></span> </p>
        <p>Curr Inst. = <span id="current_inst5"></span></p>
        <p>Curr max = <span id="max_curr5"></span> </p>
        <p>Charging id = <span id="charging_id5"></span> </p>
      </div>


      </div>



<div class="line_2">
PPPPPP
</div>



  </div>







  </body>
</html>
<?php
}else {
  header("Location: index.php");
  exit();
}
 ?>
