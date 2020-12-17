<?php
include "db_conn.php";
session_start();





if (isset($_POST['uname']) && isset($_POST['password'])&& isset($_POST['name'])&& isset($_POST['adress'])&& isset($_POST['mobile'])) {
  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $uname = validate($_POST['uname']);
  $pass =  validate($_POST['password']);
  $name =  validate($_POST['name']);
  $adress =  validate($_POST['adress']);
  $mobile =  validate($_POST['mobile']);

if (empty($uname)) {
  header("Location: register.php?error=Username is required");
  exit();
}elseif (empty($pass)) {
  header("Location: register.php?error=Password is required");
  exit();
}elseif (empty($name)) {
  header("Location: register.php?error=Name is required");
  exit();
}elseif (empty($adress)) {
    header("Location: register.php?error=Adress is required");
    exit();
}elseif (empty($mobile)) {
    header("Location: register.php?error=Mobile Number is required");
    exit();
}else {



  $sql = "INSERT INTO trabalho2.clientes (nome, morada, telefone, username, password)
  VALUES ('".$name."','".$adress."','".$mobile."','".$uname."','".$pass."')";

  $result = pg_query($conn,$sql);

if ($result) {
header("Location: front_page.php");
}else {
  header("Location: register.php?error=Username already taken / invalid fields");
}



}

}


else {
  header("Location: index.php");
  exit();
}

 ?>
