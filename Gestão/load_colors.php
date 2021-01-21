<?php
include "db_conn.php";
session_start();
$count =0;
$nr_fori=0;
$sql = "SELECT * FROM seai.charger WHERE charger_id='202001'";
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
      $emergency1 = $row['emergency_interr'];
  }
  if ($current_inst1!="0.00") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='202002'";
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
      $emergency2 = $row['emergency_interr'];

  }
  if ($current_inst2!="0.00") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='202003'";
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
      $emergency3 = $row['emergency_interr'];

  }
  if ($current_inst3!="0.00") {
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
      $emergency4 = $row['emergency_interr'];

  }
  if ($current_inst4!="0.00") {
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
      $emergency5 = $row['emergency_interr'];

  }
  if ($current_inst5!="0.00") {
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
      $emergency6 = $row['emergency_interr'];

  }
  if ($current_inst6!="0.00") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='202007'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid7 = $row['charger_id'];
      $voltage_inst7=$row['voltage_inst'];
      $current_inst7=$row['current_inst'];
      $charging_id7=$row['charging_id'];
      $fc_availability7=$row['fc_availability'];
      $max_curr7=$row['max_curr'];
      $state_charger7 = $row['charging_mode'];
      $emergency7 = $row['emergency_interr'];

  }
  if ($current_inst7!="0.00") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger WHERE charger_id='202008'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid8 = $row['charger_id'];
      $voltage_inst8=$row['voltage_inst'];
      $current_inst8=$row['current_inst'];
      $charging_id8=$row['charging_id'];
      $fc_availability8=$row['fc_availability'];
      $max_curr8=$row['max_curr'];
      $state_charger8 = $row['charging_mode'];
      $emergency8 = $row['emergency_interr'];

  }
  if ($current_inst8!="0.00") {
    $count++;
  }
}
$sql = "SELECT * FROM seai.charger WHERE charger_id='202009'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid9 = $row['charger_id'];
      $voltage_inst9=$row['voltage_inst'];
      $current_inst9=$row['current_inst'];
      $charging_id9=$row['charging_id'];
      $fc_availability9=$row['fc_availability'];
      $max_curr9=$row['max_curr'];
      $state_charger9 = $row['charging_mode'];
      $emergency9 = $row['emergency_interr'];

  }
  if ($current_inst9!="0.00") {
    $count++;
  }
}
$sql = "SELECT * FROM seai.charger WHERE charger_id='202010'";
$result = pg_query($conn, $sql);


if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid10 = $row['charger_id'];
      $voltage_inst10=$row['voltage_inst'];
      $current_inst10=$row['current_inst'];
      $charging_id10=$row['charging_id'];
      $fc_availability10=$row['fc_availability'];
      $max_curr10=$row['max_curr'];
      $state_charger10 = $row['charging_mode'];
      $emergency10 = $row['emergency_interr'];

  }
  if ($current_inst10!="0.00") {
    $count++;
  }
}

$sql = "SELECT * FROM seai.charger";
$result = pg_query($conn, $sql);
$id_emer=0;

if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $chargerid = $row['charger_id'];
      $emergency = $row['emergency_interr'];
      if ($emergency=="t") {
        $id_emer = $chargerid;
      }

      $_SESSION['emer']=  $id_emer;

  }

}

$sql = "SELECT * FROM seai.charging ";
$result = pg_query($conn, $sql);
$b = 0;
if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
      $fori= $row['fori'];
      if ($fori=="t") {
        $nr_fori++;
        $ids[$b]=$row['charger_id'];
        $b++;
      }

      $_SESSION['emer'] = $id_emer;

  }

}





//





 ?>

 <script type="text/javascript">



   var nr_fori = "<?php echo $nr_fori; ?>";
   var active_chargers = "<?php echo $count; ?>";
   var state1 =  "<?php echo $state_charger1; ?>";
   var state2 =  "<?php echo $state_charger2; ?>";
   var state3 =  "<?php echo $state_charger3; ?>";
   var state4 =  "<?php echo $state_charger4; ?>";
   var state5 =  "<?php echo $state_charger5; ?>";
   var state6 =  "<?php echo $state_charger6; ?>";
   var state7 =  "<?php echo $state_charger7; ?>";
   var state8 =  "<?php echo $state_charger8; ?>";
   var state9 =  "<?php echo $state_charger9; ?>";
   var state10 =  "<?php echo $state_charger10; ?>";
   var voltage_inst1 =  "<?php echo $voltage_inst1; ?>";
   var chargerid1 =  "<?php echo $chargerid1[strlen($chargerid1)-1]; ?>";
   var current_inst1="<?php echo number_format($current_inst1/1000, 2, '.', ''); ?>";
   var charging_id1="<?php echo $charging_id1; ?>";
   var fc_availability1="<?php echo $fc_availability1; ?>";
   var max_curr1="<?php echo number_format($max_curr1/1000, 2, '.', ''); ?>";

   var voltage_inst2 =  "<?php echo $voltage_inst2; ?>";
   var chargerid2 =  "<?php echo $chargerid2[strlen($chargerid2)-1]; ?>";
   var current_inst2="<?php echo number_format($current_inst2/1000, 2, '.', ''); ?>";
   var charging_id2="<?php echo $charging_id2; ?>";
   var fc_availability2="<?php echo $fc_availability2; ?>";
   var max_curr2="<?php echo number_format($max_curr2/1000, 2, '.', ''); ?>";

   var voltage_inst3 =  "<?php echo $voltage_inst3; ?>";
   var chargerid3 =  "<?php echo $chargerid3[strlen($chargerid3)-1]; ?>";
   var current_inst3="<?php echo number_format($current_inst3/1000, 2, '.', ''); ?>";
   var charging_id3="<?php echo $charging_id3; ?>";
   var fc_availability3="<?php echo $fc_availability3; ?>";
   var max_curr3="<?php echo number_format($max_curr3/1000, 2, '.', ''); ?>";

   var voltage_inst4 =  "<?php echo $voltage_inst4; ?>";
   var chargerid4 =  "<?php echo $chargerid4[strlen($chargerid4)-1]; ?>";
   var current_inst4="<?php echo number_format($current_inst4/1000, 2, '.', ''); ?>";
   var charging_id4="<?php echo $charging_id4; ?>";
   var fc_availability4="<?php echo $fc_availability4; ?>";
   var max_curr4="<?php echo number_format($max_curr4/1000, 2, '.', ''); ?>";

   var voltage_inst5 =  "<?php echo $voltage_inst5; ?>";
   var chargerid5 =  "<?php echo $chargerid5[strlen($chargerid5)-1]; ?>";
   var current_inst5="<?php echo number_format($current_inst5/1000, 2, '.', ''); ?>";
   var charging_id5="<?php echo $charging_id5; ?>";
   var fc_availability5="<?php echo $fc_availability5; ?>";
   var max_curr5="<?php echo number_format($max_curr5/1000, 2, '.', ''); ?>";

   var voltage_inst6 =  "<?php echo $voltage_inst6; ?>";
   var chargerid6 =  "<?php echo $chargerid6[strlen($chargerid6)-1]; ?>";
   var current_inst6="<?php echo number_format($current_inst6/1000, 2, '.', ''); ?>";
   var charging_id6="<?php echo $charging_id6; ?>";
   var fc_availability6="<?php echo $fc_availability6; ?>";
   var max_curr6="<?php echo number_format($max_curr6/1000, 2, '.', ''); ?>";

   var voltage_inst7 =  "<?php echo $voltage_inst7; ?>";
   var chargerid7 =  "<?php echo $chargerid7[strlen($chargerid7)-1]; ?>";
   var current_inst7="<?php echo number_format($current_inst7/1000, 2, '.', ''); ?>";
   var charging_id7="<?php echo $charging_id7; ?>";
   var fc_availability7="<?php echo $fc_availability7; ?>";
   var max_curr7="<?php echo number_format($max_curr7/1000, 2, '.', ''); ?>";

   var voltage_inst8 =  "<?php echo $voltage_inst8; ?>";
   var chargerid8 =  "<?php echo $chargerid8[strlen($chargerid8)-1]; ?>";
   var current_inst8="<?php echo number_format($current_inst8/1000, 2, '.', ''); ?>";
   var charging_id8="<?php echo $charging_id8; ?>";
   var fc_availability8="<?php echo $fc_availability8; ?>";
   var max_curr8="<?php echo number_format($max_curr8/1000, 2, '.', ''); ?>";

   var voltage_inst9 =  "<?php echo $voltage_inst9; ?>";
   var chargerid9 =  "<?php echo $chargerid9[strlen($chargerid9)-1]; ?>";
   var current_inst9="<?php echo number_format($current_inst9/1000, 2, '.', ''); ?>";
   var charging_id9="<?php echo $charging_id9; ?>";
   var fc_availability9="<?php echo $fc_availability9; ?>";
   var max_curr9="<?php echo number_format($max_curr9/1000, 2, '.', ''); ?>";

   var voltage_inst10 =  "<?php echo $voltage_inst10; ?>";
   var chargerid10 =  "<?php echo $chargerid10[strlen($chargerid10)-2]."".$chargerid10[strlen($chargerid10)-1] ; ?>";
   var current_inst10="<?php echo number_format($current_inst10/1000, 2, '.', ''); ?>";
   var charging_id10="<?php echo $charging_id10; ?>";
   var fc_availability10="<?php echo $fc_availability10; ?>";
   var max_curr10="<?php echo number_format($max_curr10/1000, 2, '.', ''); ?>";

   var emergency1="<?php echo $emergency1; ?>";
   var emergency2="<?php echo $emergency2; ?>";
   var emergency3="<?php echo $emergency3; ?>";
   var emergency4="<?php echo $emergency4; ?>";
   var emergency5="<?php echo $emergency5; ?>";
   var emergency6="<?php echo $emergency6; ?>";
   var emergency7="<?php echo $emergency7; ?>";
   var emergency8="<?php echo $emergency8; ?>";
   var emergency9="<?php echo $emergency9; ?>";
   var emergency10="<?php echo $emergency10; ?>";
   var id_emer =  "<?php if ($id_emer=='202010') {
  $id_emer=10;   echo $id_emer; }else{
       echo $id_emer[strlen($id_emer)-1];

   } ?>";








   if (current_inst1!='0.00')  {
       document.getElementById("state1").style.backgroundColor = 'green';
   }
   else if (current_inst1=='0.00'){
       document.getElementById("state1").style.backgroundColor = 'red';
   }

   if ( current_inst2!='0.00') {
       document.getElementById("state2").style.backgroundColor = 'green';
   }
   else if (current_inst2=='0.00'){
       document.getElementById("state2").style.backgroundColor = 'red';
   }
   if (current_inst3!='0.00') {
       document.getElementById("state3").style.backgroundColor = 'green';
   }
   else if (current_inst3=='0.00'){
       document.getElementById("state3").style.backgroundColor = 'red';
   }
   if ( current_inst4!='0.00') {
       document.getElementById("state4").style.backgroundColor = 'green';
   }
   else if (current_inst4=='0.00'){
       document.getElementById("state4").style.backgroundColor = 'red';
   }
   if ( current_inst5!='0.00') {
       document.getElementById("state5").style.backgroundColor = 'green';
   }
   else if (current_inst5=='0.00'){
       document.getElementById("state5").style.backgroundColor = 'red';
   }
   if ( current_inst6!='0.00') {
       document.getElementById("state6").style.backgroundColor = 'green';
   }
   else if (current_inst6=='0.00'){
       document.getElementById("state6").style.backgroundColor = 'red';
   }
   if (current_inst7!='0.00') {
       document.getElementById("state7").style.backgroundColor = 'green';
   }
   else if (current_inst7=='0.00'){
       document.getElementById("state7").style.backgroundColor = 'red';
   }
   if ( current_inst8!='0.00') {
       document.getElementById("state8").style.backgroundColor = 'green';
   }
   else if (current_inst8=='0.00'){
       document.getElementById("state8").style.backgroundColor = 'red';
   }
   if ( current_inst9!='0.00') {
       document.getElementById("state9").style.backgroundColor = 'green';
   }
   else if (current_inst9=='0.00'){
       document.getElementById("state9").style.backgroundColor = 'red';
   }
   if (current_inst10!='0.00') {
       document.getElementById("state10").style.backgroundColor = 'green';
   }
   else if (current_inst10=='0.00'){
       document.getElementById("state10").style.backgroundColor = 'red';
   }







   if (emergency1=="t" || emergency2=="t"|| emergency3=="t"|| emergency4=="t"|| emergency5=="t"|| emergency6=="t"|| emergency7=="t"|| emergency8=="t"|| emergency9=="t"|| emergency10=="t"){
     emergency1="DETECTED!!";
     document.getElementById("emergency1").style.backgroundColor = 'red';
     document.getElementById("emergency1").style.color = 'white';
   }
   else {
     emergency1="Not detected";
     document.getElementById("emergency1").style.backgroundColor = 'white';
     document.getElementById("emergency1").style.color = 'black';
   }

  document.getElementById("nr_fori").innerHTML = nr_fori;
  document.getElementById("chargerid1").innerHTML = chargerid1;
  document.getElementById("current_inst1").innerHTML = current_inst1;
  document.getElementById("charging_id1").innerHTML = charging_id1;
  document.getElementById("max_curr1").innerHTML = max_curr1;

  document.getElementById("chargerid2").innerHTML = chargerid2;
  document.getElementById("current_inst2").innerHTML = current_inst2;
  document.getElementById("charging_id2").innerHTML = charging_id2;
  document.getElementById("max_curr2").innerHTML = max_curr2;

  document.getElementById("chargerid3").innerHTML = chargerid3;
  document.getElementById("current_inst3").innerHTML = current_inst3;
  document.getElementById("charging_id3").innerHTML = charging_id3;
  document.getElementById("max_curr3").innerHTML = max_curr3;

  document.getElementById("chargerid4").innerHTML = chargerid4;
  document.getElementById("current_inst4").innerHTML = current_inst4;
  document.getElementById("charging_id4").innerHTML = charging_id4;
  document.getElementById("max_curr4").innerHTML = max_curr4;

  document.getElementById("chargerid5").innerHTML = chargerid5;
  document.getElementById("current_inst5").innerHTML = current_inst5;
  document.getElementById("charging_id5").innerHTML = charging_id5;
  document.getElementById("max_curr5").innerHTML = max_curr5;
  document.getElementById("active_chargers").innerHTML = active_chargers;

  document.getElementById("chargerid6").innerHTML = chargerid6;
  document.getElementById("current_inst6").innerHTML = current_inst6;
  document.getElementById("charging_id6").innerHTML = charging_id6;
  document.getElementById("max_curr6").innerHTML = max_curr6;

  document.getElementById("chargerid7").innerHTML = chargerid7;
  document.getElementById("current_inst7").innerHTML = current_inst7;
  document.getElementById("charging_id7").innerHTML = charging_id7;
  document.getElementById("max_curr7").innerHTML = max_curr7;

  document.getElementById("chargerid8").innerHTML = chargerid8;
  document.getElementById("current_inst8").innerHTML = current_inst8;
  document.getElementById("charging_id8").innerHTML = charging_id8;
  document.getElementById("max_curr8").innerHTML = max_curr8;

  document.getElementById("chargerid9").innerHTML = chargerid9;
  document.getElementById("current_inst9").innerHTML = current_inst9;
  document.getElementById("charging_id9").innerHTML = charging_id9;
  document.getElementById("max_curr9").innerHTML = max_curr9;

  document.getElementById("chargerid10").innerHTML = chargerid10;
  document.getElementById("current_inst10").innerHTML = current_inst10;
  document.getElementById("charging_id10").innerHTML = charging_id10;
  document.getElementById("max_curr10").innerHTML = max_curr10;

  document.getElementById("active_chargers").innerHTML = active_chargers;
  document.getElementById("emergency1").innerHTML = emergency1;
  document.getElementById("id_emer").innerHTML = id_emer;








 </script>
