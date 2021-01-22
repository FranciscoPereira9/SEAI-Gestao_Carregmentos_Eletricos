<?php
include "db_conn.php";




$sql = "UPDATE seai.charger SET charging_mode = 'f', operator_interr= 't'";
$result = pg_query($conn, $sql);



header("Location: home.php");


 ?>
