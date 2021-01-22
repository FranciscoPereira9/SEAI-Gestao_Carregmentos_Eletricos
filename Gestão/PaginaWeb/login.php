<?php
include "db_conn.php";
session_start();






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



$sql = "SELECT * FROM seai.operator WHERE username = '$uname' AND password = '$pass'";
  $result = pg_query($conn, $sql);
  if (pg_num_rows($result)===1) {
    $row = pg_fetch_assoc($result);
    if ($row['username'] === $uname && $row['password'] === $pass) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['id'] = $row['id'];
      $_SESSION ['chargers'] = ['module'=>'management','202001' => 1, '202002' => 0, '202003' => 1, '202004' => 0, '202005' => 1, '202006' => 0, '202007' => 1, '202008' => 0, '202009' => 1, '202010' => 1];
      echo $_SESSION ['chargers'];
      header("Location: home.php");
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
