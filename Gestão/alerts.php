<?php
session_start();
include "db_conn.php";


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
        <a href="statistics.php"><li>Statistics</li></a>
        <a href="alerts.php"><li class="active">Alerts</li></a>
		<a href="prices.php"><li>Prices</li></a>
      </ul>
    </div>
    <div class="other_stuff1">

    </ul>  <a class="no" href="interruption_all.php"><i class="fas fa-exclamation-triangle"></i><span class="warning">Force all chargers to turn off</span> </a>


    </div>


  </div>
  <div class="nothing">
  </div>
  <div class="chargers">

<?php
$teste= $_SESSION['emer'];
$id_mod=0;
if ($teste == "202010") {
  $id_mod = "10";
} else {
  $id_mod = $teste[strlen($teste)-1];
}

 ?>
<?php
$sql = "SELECT * FROM seai.emergency ORDER BY id DESC LIMIT 1";
$result = pg_query($conn, $sql);
if (pg_num_rows($result)>0) {
  while ($row = pg_fetch_assoc($result)) {

    $teste1 = $row['charger_id'];
  }
  }


 ?>
 <table class="emergency_table">
   <tr>
     <th>Charger ID</th>
     <th>Date Emergency</th>

   </tr>

   <?php

           if ($teste1!=$id_mod && ($id_mod!="")) {

             $sql = "INSERT into seai.emergency (charger_id, date_emergency) VALUES ('$id_mod', CURRENT_TIMESTAMP)";
             $result = pg_query($conn, $sql);

           }


                        $sql = "SELECT * FROM seai.emergency ORDER BY id DESC";
                        $result = pg_query($conn, $sql);
                           if (pg_num_rows($result)>0) {
                             while ($row = pg_fetch_assoc($result)) {

                                 echo "<tr><td>". $row['charger_id'] ."</td><td>" .$row['date_emergency'] ."</td></tr>";
                                      }

                                     }










                ?>
 </table>










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
