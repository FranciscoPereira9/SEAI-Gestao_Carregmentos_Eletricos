<?php

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>HOME</title>

    <script type="text/javascript" src="jquery-3.5.1.min.js"></script>


    <link rel="stylesheet" href="style_data_charger.css">
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

    <p class="id_charger1">ID CHARGER</p>

    <?php
    $id_init=$_GET['id']
    ?>

    <p class="id_charger"><?php echo $id_init[strlen($id_init)-1]; ?></p>
    <p><a class="view_all" href="home.php">View all chargers</a></p>
    </div>


  </div>
  <div class="nothing">

  </div>
  <div class="chargers">

    <div  class="table1">
      <table>
        <tr>
          <th>Charger ID	</th>
          <th>User ID</th>
          <th>Starting Time</th>
          <th>Stopping Time</th>
          <th>Forl</th>
          <th>Average Power</th>
          <th>Charger Type</th>
          <th>Starting Date</th>
          <th>Ending Date</th>
          <th>Price per KWh</th>
        </tr>
        <?php
        include "db_conn.php";
        $sql = "SELECT * FROM seai.charging WHERE charger_id='$id_init'";
        $result = pg_query($conn, $sql);
           if (pg_num_rows($result)>0) {
             while ($row = pg_fetch_assoc($result)) {
               if ($row['charge_type']=="t") {
                 $aux = "Fast";
               }else {
                 $aux = "Normal";
               }
                 echo "<tr><td>". $row['charger_id'] ."</td><td>" .$row['user_id'] ."</td><td>" .$row['starting_time']
                 ."</td><td>". $row['stoping_time'] ."</td><td>" . $row['fori'] ."</td><td>" . $row['avg_power']
                 ."</td><td>". $aux ."</td><td>" . $row['starting_date'] ."</td><td>" . $row['ending_date']
                  ."</td><td>" . $row['priceper_kwh'] ."</td>";
                      }
                     } ?>
      </table>

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
