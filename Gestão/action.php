<?php
include "db_conn.php";

if (isset($_POST['query'])) {
  $inpText=$_POST['query'];
  $query = "SELECT nome,aux,id_produto FROM trabalho2.produtos2 WHERE nome LIKE '%$inpText%' or aux LIKE '%$inpText%'";

  $result = pg_query($conn, $query);

  if (pg_num_rows($result) > 0) {

  while($row = pg_fetch_assoc($result)) {

    echo '<a href="produtos_ind.php?id_produto='.$row['id_produto'].'" class="list-group-item list-group-item-action border-1">' . $row['nome'] . '</a>';


    }
  }
else {
  echo '<p class="list-group-item border-1">Sem resultados</p>';
}
}



 ?>
