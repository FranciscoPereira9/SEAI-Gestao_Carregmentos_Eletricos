<?php
include "load_colors.php";


if (isset($_SESSION['id']) && isset($_SESSION['username'])) {


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HOME</title>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <h1 class="greets">Welcome, <?php echo ($_SESSION['username']) ; ?></h1>
        <a class="logout"href="logout.php">LOGOUT</a>
      </div>

    </div>
<div class="container">
  <div class="options">
    <div class="nav-bar">
      <ul>
        <a href="home.php"><li class="active">Home</li></a>
        <a href="statistics.php"><li>Statistics</li></a>
        <a href="alerts.php"><li>Alerts</li></a>
    		<a href="prices.php"><li>Prices</li></a>
        <a href="forced.php"><li>Forced Interrupt</li></a>
      </ul>
    </div>
    <div class="other_stuff">

      <h6>Active Chargers -  <i class="fas fa-plug"><span id="active_chargers"></span> </i></h6>
      <h6>Forced Interruptions -  <i class="fas fa-hand-paper"><span id="nr_fori"></span> </i></h6>

      <a href="client_php.php?id=<?php echo '202000'; ?>"><i class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn off</span> </a>
      <p><a href="client_php.php?id=<?php echo '202000_on'; ?>"><i id="onn"class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn on</span> </a></p>
      <div class="emergency">
        <h4>Emergency Alert :</h4>
        <div id="emergency1" class="emergency2"></div>
        <h6>Emergência no id: </h6><h6 id="id_emer"></h6>
        <h5>Check <a class="alerts" href="alerts.php">Alerts</a> for more info</h5>





      </div>




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
        <span class="info_charger">Charger<span id="chargerid1"></span></span>
        <div class="turns">
          <a href="client_php.php?id=<?php echo $chargerid1; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
          <a href="client_php.php?id_on=<?php echo $chargerid1; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
        </div>

      </div>
      <div class="info1">

        <p>Power Inst. = <span id="current_inst1"></span>KW</p>
        <p>Power max = <span id="max_curr1"></span>KW</p>
        <p>Charging id =<span id="charging_id1"></span> </p>


        <a href="data_charger.php?id=<?php echo $chargerid1; ?>">+ info</a>
      </div>
      <div class="charger2">
        <div id="state2">
          <div class="value2">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span class="info_charger">Charger<span id="chargerid2"></span></span>
        <div class="turns">
          <a href="client_php.php?id=<?php echo $chargerid2; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
          <a href="client_php.php?id_on=<?php echo $chargerid2; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
        </div>
      </div>
      <div class="info1">

        <p>Power Inst. = <span id="current_inst2"></span>KW</p>
        <p>Power max = <span id="max_curr2"></span>KW</p>
        <p>Charging id = <span id="charging_id2"></span> </p>

        <a href="data_charger.php?id=<?php echo $chargerid2; ?>">+ info</a>
      </div>
      <div class="charger3">
        <div id="state3">
          <div class="value3">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span class="info_charger">Charger<span id="chargerid3"></span></span>
        <div class="turns">
          <a href="client_php.php?id=<?php echo $chargerid3; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
          <a href="client_php.php?id_on=<?php echo $chargerid3; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
        </div>
      </div>
      <div class="info1">

        <p>Power Inst. = <span id="current_inst3"></span>KW</p>
        <p>Power max = <span id="max_curr3"></span>KW</p>
        <p>Charging id = <span id="charging_id3"></span> </p>

        <a href="data_charger.php?id=<?php echo $chargerid3; ?>">+ info</a>
      </div>
      <div class="charger4">
        <div id="state4">
          <div class="value4">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span class="info_charger">Charger<span id="chargerid4"></span></span>
        <div class="turns">
          <a href="client_php.php?id=<?php echo $chargerid4; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
          <a href="client_php.php?id_on=<?php echo $chargerid4; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
        </div>
      </div>
      <div class="info1">

        <p>Power Inst. = <span id="current_inst4"></span>KW</p>
        <p>Power max = <span id="max_curr4"></span>KW</p>
        <p>Charging id = <span id="charging_id4"></span> </p>

        <a href="data_charger.php?id=<?php echo $chargerid4; ?>">+ info</a>
      </div>
      <div class="charger5">
        <div id="state5">
          <div class="value5">
            <p></p>
          </div>
        </div>
        <img class="charger_img" src="charger.png" alt="">
        <span class="info_charger">Charger<span id="chargerid5"></span></span>
        <div class="turns">
          <a href="client_php.php?id=<?php echo $chargerid5; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
          <a href="client_php.php?id_on=<?php echo $chargerid5; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
        </div>
      </div>
      <div class="info1_">

        <p>Power Inst. = <span id="current_inst5"></span>KW</p>
        <p>Power max = <span id="max_curr5"></span>KW</p>
        <p>Charging id = <span id="charging_id5"></span> </p>

        <a href="data_charger.php?id=<?php echo $chargerid5; ?>">+ info</a>
      </div>


      </div>



<div class="line_2">
  <div class="charger6">
    <div id="state6">
      <div class="value6">
        <p></p>
      </div>
    </div>
    <img class="charger_img" src="charger.png" alt="">
    <span class="info_charger">Charger<span id="chargerid6"></span></span>
    <div class="turns">
      <a href="client_php.php?id=<?php echo $chargerid6; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
      <a href="client_php.php?id_on=<?php echo $chargerid6; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
    </div>
  </div>
  <div class="info1_line2">

    <p>Power Inst. = <span id="current_inst6"></span>KW</p>
    <p>Power max = <span id="max_curr6"></span>KW</p>
    <p>Charging id = <span id="charging_id6"></span> </p>

    <a href="data_charger.php?id=<?php echo $chargerid6; ?>">+ info</a>
  </div>
  <div class="charger7">
    <div id="state7">
      <div class="value7">
        <p></p>
      </div>
    </div>
    <img class="charger_img" src="charger.png" alt="">
    <span class="info_charger">Charger<span id="chargerid7"></span></span>
    <div class="turns">
      <a href="client_php.php?id=<?php echo $chargerid7; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
      <a href="client_php.php?id_on=<?php echo $chargerid7; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
    </div>
  </div>
  <div class="info1_line2">

    <p>Power Inst. = <span id="current_inst7"></span>KW</p>
    <p>Power max = <span id="max_curr7"></span>KW</p>
    <p>Charging id = <span id="charging_id7"></span> </p>

    <a href="data_charger.php?id=<?php echo $chargerid7; ?>">+ info</a>
  </div>
  <div class="charger8">
    <div id="state8">
      <div class="value8">
        <p></p>
      </div>
    </div>
    <img class="charger_img" src="charger.png" alt="">
    <span class="info_charger">Charger<span id="chargerid8"></span></span>
    <div class="turns">
      <a href="client_php.php?id=<?php echo $chargerid8; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
      <a href="client_php.php?id_on=<?php echo $chargerid8; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
    </div>
  </div>
  <div class="info1_line2">

    <p>Power Inst. = <span id="current_inst8"></span>KW</p>
    <p>Power max = <span id="max_curr8"></span>KW</p>
    <p>Charging id = <span id="charging_id8"></span> </p>

    <a href="data_charger.php?id=<?php echo $chargerid8; ?>">+ info</a>
  </div>
  <div class="charger9">
    <div id="state9">
      <div class="value9">
        <p></p>
      </div>
    </div>
    <img class="charger_img" src="charger.png" alt="">
    <span class="info_charger">Charger<span id="chargerid9"></span></span>
    <div class="turns">
      <a href="client_php.php?id=<?php echo $chargerid9; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
      <a href="client_php.php?id_on=<?php echo $chargerid9; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
    </div>
  </div>
  <div class="info1_line2">

    <p>Power Inst. = <span id="current_inst9"></span>KW</p>
    <p>Power max = <span id="max_curr9"></span>KW</p>
    <p>Charging id = <span id="charging_id9"></span> </p>

    <a href="data_charger.php?id=<?php echo $chargerid9; ?>">+ info</a>
  </div>
  <div class="charger10">
    <div id="state10">
      <div class="value10">
        <p></p>
      </div>
    </div>
    <img class="charger_img" src="charger.png" alt="">
    <span class="info_charger">Charger<span id="chargerid10"></span></span>
    <div class="turns">
      <a href="client_php.php?id=<?php echo $chargerid10; ?>"><i id="turn_off"class="fas fa-power-off"></i></a>
      <a href="client_php.php?id_on=<?php echo $chargerid10; ?>"><i id="turn_on"class="fas fa-power-off"></i></a>
    </div>
  </div>
  <div class="info1_line2_">

    <p>Power Inst. = <span id="current_inst10"></span>KW</p>
    <p>Power max = <span id="max_curr10"></span>KW</p>
    <p>Charging id = <span id="charging_id10"></span> </p>

    <a href="data_charger.php?id=<?php echo $chargerid10; ?>">+ info</a>
  </div>
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
