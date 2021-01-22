<?php
include "db_conn.php";


$id = $_GET['id'];

echo $id;



$sql = "UPDATE seai.charger SET charging_mode = 'f', operator_interr= 't' WHERE charger_id='$id'";
$result = pg_query($conn, $sql);



header("Location: home.php");


 ?>
