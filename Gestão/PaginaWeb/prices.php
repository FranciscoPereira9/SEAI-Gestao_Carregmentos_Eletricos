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
        <h1 class="greets">Welcome, <?php echo ($_SESSION['username']) ; ?></h1>
        <a class="logout"href="logout.php">LOGOUT</a>
      </div>

    </div>
<div class="container">
  <div class="options">
    <div class="nav-bar">
      <ul>
        <a href="home.php"><li>Home</li></a>
        <a href="statistics.php"><li>Statistics</li></a>
        <a href="alerts.php"><li>Alerts</li></a>
		<a href="prices.php"><li class="active">Prices</li></a>
    <a href="forced.php"><li>Forced Interrupt</li></a>
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
		include "db_conn.php";
		$sql = "SELECT * FROM seai.charger WHERE charger_id='202001'";
		$result = pg_query($conn, $sql);
		if (pg_num_rows($result)>0) {
			$row = pg_fetch_assoc($result);
			//var_dump($row);
			$current_ppk = $row['priceper_kwh'];
			$current_ppk_fc = $row['priceper_kwh_fc'];
			$current_ppk_green = $row['priceper_kwh_green'];
			//$_SESSION['PPK'] = $current_PPK;
      ?>
      <div class="container_total">

        <h3 class="charging_title_price">Price Changing € / KW / h</h3>
        <form class="container_price" method = "GET" action ="actionUpdatePrice.php">
        <div class="price1">
          Normal Charging: <br><input class="input_price_text" type="text" 		name="new_ppk" 		 value="<?php echo $current_ppk; ?>">
        </div>
        <div class="price2">
          Fast Charging: <br><input class="input_price_text" type="text" 		name="new_ppk_fc" 		 value="<?php echo $current_ppk_fc; ?>">
        </div>
        <div class="price3">
          Green Charging: <br><input class="input_price_text" type="text" 		name="new_ppk_green" 		 value="<?php echo $current_ppk_green;  ?>">
        </div>

        <div class="submit_input">
            <input class="button4" type="submit" 	name="Confirmar" 	value="Confirmar">
        </div>

        </form>

      </div>
      <?php
        }
if (isset($_GET['Confirmar'])) {
  echo '<script language="javascript">';
  echo 'alert("record is successfully inserted")';
  echo '</script>';
}
?>

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
