<?php


function count_fast($id){
  include "db_conn.php";

  if ($id!=10) {
    $id_new = "20200"."$id";
  }else {
    $id_new = "2020"."$id";
  }
  $sql = "SELECT * FROM seai.charging WHERE charger_id='$id'";
  $result = pg_query($conn, $sql);
  $fast=0;

  if (pg_num_rows($result) > 0) {

    while($row = pg_fetch_assoc($result)) {
        $charge_type = $row['charge_type'];
        if ($charge_type=="t") {
          $fast++;
        }
    }
}
return $fast;
}

function count_normal($id){
  include "db_conn.php";

  if ($id!=10) {
    $id_new = "20200"."$id";
  }else {
    $id_new = "2020"."$id";
  }
  $sql = "SELECT * FROM seai.charging WHERE charger_id='20200$id'";
  $result = pg_query($conn, $sql);
$normal=0;

  if (pg_num_rows($result) > 0) {

    while($row = pg_fetch_assoc($result)) {
        $charge_type = $row['charge_type'];
        if ($charge_type=="f") {
          $normal++;
        }
    }
}
return $normal;
}


function count_avg_power($id){
  include "db_conn.php";

  $sql = "SELECT * FROM seai.charging WHERE charger_id='20200$id'";
  $result = pg_query($conn, $sql);
$total_avg_power=0;
$a=0;
  if (pg_num_rows($result) > 0) {

    while($row = pg_fetch_assoc($result)) {
        $avg_power = $row['avg_power'];
        $total_avg_power =  $total_avg_power + $avg_power;
        $a++;
    }
    $total_avg_power = $total_avg_power/$a;
}
return $total_avg_power;
}

function times_used($id){
  include "db_conn.php";

  $sql = "SELECT * FROM seai.historic WHERE charger_id='20200$id'";
  $result = pg_query($conn, $sql);
$times_used=0;
  if (pg_num_rows($result) > 0) {

    while($row = pg_fetch_assoc($result)) {
        $times_used++;
    }

}
return $times_used;
}

function amout_time_avg($id){
  include "db_conn.php";

  $sql = "SELECT * FROM seai.charging WHERE charger_id='20200$id'";
  $result = pg_query($conn, $sql);
$ti=0;
$to=0;
$tfinal=0;
  if (pg_num_rows($result) > 0) {

    while($row = pg_fetch_assoc($result)) {
        $ti = $row['starting_time'];
        $to = $row['stoping_time'];

      }
$ti2 = date('Y-m-d h:i:sa', strtotime($ti));
$datetime1 = strtotime($ti2);
$to2 = date('Y-m-d h:i:sa', strtotime($to));
$datetime2 = strtotime($to2);
$data = $datetime2-$datetime1;
$data_min = $data / 60;
if ($data_min<1) {
  $formattedmin=0;
  $data_seg=$data;
}
else {
  $formattedmin = number_format($data_min);
  $data_seg = $data - ($formattedmin*60);
  $data_seg=$data_seg;
}


$data_fin = "$formattedmin"." min and "."$data_seg"." sec";

}
return $data_fin;
}






function updatePrice($new_ppk, $new_ppk_fc, $new_ppk_green ){
	include "db_conn.php";

	for($i=1; $i<10; $i=$i+1){
		$query = "update seai.charger
					set priceper_kwh = '".$new_ppk."'
					where charger_id = 20200".$i.";";
		$result = pg_query($conn, $query);

	}
	$query = "update seai.charger
					set priceper_kwh = '".$new_ppk."'
					where charger_id = 202010;";
					$result = pg_query($conn, $query);

	for($i=1; $i<10; $i=$i+1){
		$query = "update seai.charger
					set priceper_kwh_fc = '".$new_ppk_fc."'
					where charger_id = 20200".$i.";";
		$result = pg_query($conn, $query);

	}
	$query = "update seai.charger
					set priceper_kwh_fc = '".$new_ppk_fc."'
					where charger_id = 202010;";
					$result = pg_query($conn, $query);

	for($i=1; $i<10; $i=$i+1){
		$query = "update seai.charger
					set priceper_kwh_green = '".$new_ppk_green."'
					where charger_id = 20200".$i.";";
		$result = pg_query($conn, $query);

	}
	$query = "update seai.charger
					set priceper_kwh_green = '".$new_ppk_green."'
					where charger_id = 202010;";
	$result = pg_query($conn, $query);

	$result = pg_query($conn, $query);
	return $result;
}














 ?>
