<?php
include "db_conn.php";
session_start();
$count =0;
$sql = "SELECT * FROM seai.charger WHERE charger_id='1'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid1 = $row['charger_id'];
      $voltage_inst1=$row['voltage_inst'];
      $current_inst1=$row['current_inst'];
      $charging_id1=$row['charging_id'];
      $fc_availability1=$row['fc_availability'];
      $max_curr1=$row['max_curr'];
      $state_charger1 = $row['charging_mode'];
  }
  if ($state_charger1=="t") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='2'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid2 = $row['charger_id'];
      $voltage_inst2=$row['voltage_inst'];
      $current_inst2=$row['current_inst'];
      $charging_id2=$row['charging_id'];
      $fc_availability2=$row['fc_availability'];
      $max_curr2=$row['max_curr'];
      $state_charger2 = $row['charging_mode'];

  }
  if ($state_charger2=="t") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='3'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid3 = $row['charger_id'];
      $voltage_inst3=$row['voltage_inst'];
      $current_inst3=$row['current_inst'];
      $charging_id3=$row['charging_id'];
      $fc_availability3=$row['fc_availability'];
      $max_curr3=$row['max_curr'];
      $state_charger3 = $row['charging_mode'];

  }
  if ($state_charger3=="t") {
    $count++;
  }
}


$sql = "SELECT * FROM seai.charger WHERE charger_id='202004'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid4 = $row['charger_id'];
      $voltage_inst4=$row['voltage_inst'];
      $current_inst4=$row['current_inst'];
      $charging_id4=$row['charging_id'];
      $fc_availability4=$row['fc_availability'];
      $max_curr4=$row['max_curr'];
      $state_charger4 = $row['charging_mode'];

  }
  if ($state_charger4=="t") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='202005'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid5 = $row['charger_id'];
      $voltage_inst5=$row['voltage_inst'];
      $current_inst5=$row['current_inst'];
      $charging_id5=$row['charging_id'];
      $fc_availability5=$row['fc_availability'];
      $max_curr5=$row['max_curr'];
      $state_charger5 = $row['charging_mode'];

  }
  if ($state_charger5=="t") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='202006'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid6 = $row['charger_id'];
      $voltage_inst6=$row['voltage_inst'];
      $current_inst6=$row['current_inst'];
      $charging_id6=$row['charging_id'];
      $fc_availability6=$row['fc_availability'];
      $max_curr6=$row['max_curr'];
      $state_charger6 = $row['charging_mode'];

  }
  if ($state_charger6=="t") {
    $count++;
  }
}

// Tipo de carregamento em curso do carregador
$sql = "SELECT charge_type FROM seai.charging WHERE id='$charging_id1'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $charging_type1 = $row['charge_type'];


  }

}
$sql = "SELECT charge_type FROM seai.charging WHERE id='$charging_id2'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $charging_type2 = $row['charge_type'];


  }

}

$sql = "SELECT charge_type FROM seai.charging WHERE id='$charging_id3'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $charging_type3 = $row['charge_type'];


  }

}

$sql = "SELECT charge_type FROM seai.charging WHERE id='$charging_id4'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $charging_type4 = $row['charge_type'];


  }

}


$sql = "SELECT charge_type FROM seai.charging WHERE id='$charging_id5'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $charging_type5 = $row['charge_type'];


  }

}

$sql = "SELECT charge_type FROM seai.charging WHERE id='$charging_id6'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $charging_type6 = $row['charge_type'];


  }

}
//





 ?>

 <script type="text/javascript">


   var active_chargers = "<?php echo $count; ?>";
   var state1 =  "<?php echo $state_charger1; ?>";
   var state2 =  "<?php echo $state_charger2; ?>";
   var state3 =  "<?php echo $state_charger3; ?>";
   var state4 =  "<?php echo $state_charger4; ?>";
   var state5 =  "<?php echo $state_charger5; ?>";
   var state6 =  "<?php echo $state_charger6; ?>";
   var voltage_inst1 =  "<?php echo $voltage_inst1; ?>";
   var chargerid1 =  "<?php echo $chargerid1; ?>";
   var current_inst1="<?php echo $current_inst1; ?>";
   var charging_id1="<?php echo $charging_id1; ?>";
   var fc_availability1="<?php echo $fc_availability1; ?>";
   var max_curr1="<?php echo $max_curr1; ?>";
   var charging_type1="<?php echo $charging_type1; ?>";
   var voltage_inst2 =  "<?php echo $voltage_inst2; ?>";
   var chargerid2 =  "<?php echo $chargerid2; ?>";
   var current_inst2="<?php echo $current_inst2; ?>";
   var charging_id2="<?php echo $charging_id2; ?>";
   var fc_availability2="<?php echo $fc_availability2; ?>";
   var max_curr2="<?php echo $max_curr2; ?>";
   var charging_type2="<?php echo $charging_type2; ?>";
   var voltage_inst3 =  "<?php echo $voltage_inst3; ?>";
   var chargerid3 =  "<?php echo $chargerid3; ?>";
   var current_inst3="<?php echo $current_inst3; ?>";
   var charging_id3="<?php echo $charging_id3; ?>";
   var fc_availability3="<?php echo $fc_availability3; ?>";
   var max_curr3="<?php echo $max_curr3; ?>";
   var charging_type3="<?php echo $charging_type3; ?>";
   var voltage_inst4 =  "<?php echo $voltage_inst4; ?>";
   var chargerid4 =  "<?php echo $chargerid4[strlen($chargerid4)-1]; ?>";
   var current_inst4="<?php echo $current_inst4; ?>";
   var charging_id4="<?php echo $charging_id4; ?>";
   var fc_availability4="<?php echo $fc_availability4; ?>";
   var max_curr4="<?php echo $max_curr4; ?>";
   var charging_type4="<?php echo $charging_type4; ?>";
   var voltage_inst5 =  "<?php echo $voltage_inst5; ?>";
   var chargerid5 =  "<?php echo $chargerid5[strlen($chargerid5)-1]; ?>";
   var current_inst5="<?php echo $current_inst5; ?>";
   var charging_id5="<?php echo $charging_id5; ?>";
   var fc_availability5="<?php echo $fc_availability5; ?>";
   var max_curr5="<?php echo $max_curr5; ?>";
   var charging_type5="<?php echo $charging_type5; ?>";
   var voltage_inst6 =  "<?php echo $voltage_inst6; ?>";
   var chargerid6 =  "<?php echo $chargerid6[strlen($chargerid5)-1]; ?>";
   var current_inst6="<?php echo $current_inst6; ?>";
   var charging_id6="<?php echo $charging_id6; ?>";
   var fc_availability6="<?php echo $fc_availability6; ?>";
   var max_curr6="<?php echo $max_curr6; ?>";
   var charging_type6="<?php echo $charging_type6; ?>";







   if (state1=="t") {
       document.getElementById("state1").style.backgroundColor = 'green';
   }
   else if (state1=="f"){
       document.getElementById("state1").style.backgroundColor = 'red';
   }

   if (state2=="t") {
       document.getElementById("state2").style.backgroundColor = 'green';
   }
   else if (state2=="f"){
       document.getElementById("state2").style.backgroundColor = 'red';
   }
   if (state3=="t") {
       document.getElementById("state3").style.backgroundColor = 'green';
   }
   else if (state3=="f"){
       document.getElementById("state3").style.backgroundColor = 'red';
   }
   if (state4=="t") {
       document.getElementById("state4").style.backgroundColor = 'green';
   }
   else if (state4=="f"){
       document.getElementById("state4").style.backgroundColor = 'red';
   }
   if (state5=="t") {
       document.getElementById("state5").style.backgroundColor = 'green';
   }
   else if (state5=="f"){
       document.getElementById("state5").style.backgroundColor = 'red';
   }
   if (state6=="t") {
       document.getElementById("state6").style.backgroundColor = 'green';
   }
   else if (state6=="f"){
       document.getElementById("state6").style.backgroundColor = 'red';
   }
   if (charging_type1=="t") {
     charging_type1="fast";
   }
   else {
     charging_type1="normal";
   }
   if (charging_type2=="t") {
     charging_type2="fast";
   }
   else {
     charging_type2="normal";
   }
   if (charging_type3=="t") {
     charging_type3="fast";
   }
   else {
     charging_type3="normal";
   }
   if (charging_type4=="t") {
     charging_type4="fast";
   }
   else {
     charging_type4="normal";
   }
   if (charging_type5=="t") {
     charging_type5="fast";
   }
   else {
     charging_type5="normal";
   }
   if (charging_type6=="t") {
     charging_type6="fast";
   }
   else {
     charging_type6="normal";
   }



  document.getElementById("chargerid1").innerHTML = chargerid1;
  document.getElementById("voltage_inst1").innerHTML = voltage_inst1;
  document.getElementById("current_inst1").innerHTML = current_inst1;
  document.getElementById("charging_id1").innerHTML = charging_id1;
  document.getElementById("max_curr1").innerHTML = max_curr1;
  document.getElementById("charging_type1").innerHTML = charging_type1;
  document.getElementById("chargerid2").innerHTML = chargerid2;
  document.getElementById("voltage_inst2").innerHTML = voltage_inst2;
  document.getElementById("current_inst2").innerHTML = current_inst2;
  document.getElementById("charging_id2").innerHTML = charging_id2;
  document.getElementById("max_curr2").innerHTML = max_curr2;
  document.getElementById("charging_type2").innerHTML = charging_type2;
  document.getElementById("chargerid3").innerHTML = chargerid3;
  document.getElementById("voltage_inst3").innerHTML = voltage_inst3;
  document.getElementById("current_inst3").innerHTML = current_inst3;
  document.getElementById("charging_id3").innerHTML = charging_id3;
  document.getElementById("max_curr3").innerHTML = max_curr3;
  document.getElementById("charging_type3").innerHTML = charging_type3;
  document.getElementById("chargerid4").innerHTML = chargerid4;
  document.getElementById("voltage_inst4").innerHTML = voltage_inst4;
  document.getElementById("current_inst4").innerHTML = current_inst4;
  document.getElementById("charging_id4").innerHTML = charging_id4;
  document.getElementById("max_curr4").innerHTML = max_curr4;
  document.getElementById("charging_type4").innerHTML = charging_type4;
  document.getElementById("chargerid5").innerHTML = chargerid5;
  document.getElementById("voltage_inst5").innerHTML = voltage_inst5;
  document.getElementById("current_inst5").innerHTML = current_inst5;
  document.getElementById("charging_id5").innerHTML = charging_id5;
  document.getElementById("max_curr5").innerHTML = max_curr5;
  document.getElementById("active_chargers").innerHTML = active_chargers;
  document.getElementById("charging_type5").innerHTML = charging_type5;
  document.getElementById("chargerid6").innerHTML = chargerid6;
  document.getElementById("voltage_inst6").innerHTML = voltage_inst6;
  document.getElementById("current_inst6").innerHTML = current_inst6;
  document.getElementById("charging_id6").innerHTML = charging_id6;
  document.getElementById("max_curr6").innerHTML = max_curr6;
    document.getElementById("charging_type6").innerHTML = charging_type6;
  document.getElementById("active_chargers").innerHTML = active_chargers;







 </script>
