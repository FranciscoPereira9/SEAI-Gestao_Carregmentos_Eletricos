<?php
include "db_conn.php";

if (isset($_POST['submit'])) {
  $data=$_POST['search'];

  $query = "SELECT * FROM trabalho2.produtos2 WHERE nome = '$data'";

  $result = pg_query($conn, $query);

  if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {
    $id_produto = $row['id_produto'];

    header("Location: produtos_ind.php?id_produto=$id_produto");

    }
  }
else {
  header("Location: produtos_all.php");
}
}
else {
    header("Location: produtos_all.php");
}


 ?>
