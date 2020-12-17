<?php
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $uname = validate($_POST['uname']);
  $pass =  validate($_POST['password']);

if (empty($uname)) {
  header("Location: index.php?error=Username is required");
  exit();
}elseif (empty($pass)) {
  header("Location: index.php?error=Password is required");
  exit();
}else {



$sql = "SELECT * FROM trabalho2.clientes WHERE username = '$uname' AND password = '$pass'";
  $result = pg_query($conn, $sql);
  if (pg_num_rows($result)===1) {
    $row = pg_fetch_assoc($result);
    if ($row['username'] === $uname && $row['password'] === $pass) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['id'] = $row['id_cliente'];

      if ($_SESSION['username']=="admin") {
        header("Location: main.php");
      }else {
        header("Location: main.php");
      }

      exit();
    } else {
      header("Location: index.php?error=Incorrect username or password");
      exit();
    }




  } else {
    header("Location: index.php?error=Incorrect username or password");
    exit();
  }

}

}


else {
  header("Location: index.php");
  exit();
}

 ?>
