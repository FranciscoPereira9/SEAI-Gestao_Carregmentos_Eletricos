<?php
session_start();
include "header.php";
include "db_conn.php";


if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>LOGIN</title>
    <link rel="stylesheet" href="main.css">
  </head>
  <body>

    <div class="foto">
      <img  src="imagem_main.png" alt="main" >
    </div>

    <div class="baixo">
      <div class="icon">
        <i class="fas fa-truck fa-7x"></i>
        <p>Entrgas rapidas</p>
      </div>
      <div class="icon">
        <i class="far fa-heart fa-7x"></i>
        <p >Mínimo 1 ano de garantia</p>
      </div>
      <div class="icon">
        <i class="far fa-envelope fa-7x"></i>
        <p style="margin-bottom: 0px">Dúvidas</p>
        <a style="color: black" style="margin: 2px" href="mailto:hello@pocketphones.com">hello@pocketphones.com</a>
      </div>
    </div>
  </body>
</html>
<?php
}else {
  exit();
//  header("Location : index.php");
}
 ?>
