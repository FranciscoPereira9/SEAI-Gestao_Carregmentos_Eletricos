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
     <title></title>
   </head>
   <body>
     <?php

if (isset($_POST['adicionar_carrinho'])) {
        $quantidade_produto = $_POST['quantidade_client'];
        $id_produto = $_GET['id_produto'];
        $id_cliente= $_SESSION['id'];

        $sql = "SELECT * FROM trabalho2.produtos2 WHERE id_produto='$id_produto'";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result) > 0) {
        while($row = pg_fetch_assoc($result)) {
          $preco = $row['preco'];
                }
            }

      $sql = "SELECT * FROM trabalho2.encomendas WHERE id_cliente = '$id_cliente' ORDER BY id_encomenda ASC";
      $result = pg_query($conn, $sql);
      if (pg_num_rows($result) > 0) {
      while($row = pg_fetch_assoc($result)) {
        if ($row['order_status']=='on_going') {
          
        } else {
              $sql = "INSERT into trabalho2.encomendas (id_cliente, order_status) VALUES ('$id_cliente', 'on_going')";
              $result = pg_query($conn, $sql);
        }
        }
      }


  $sql = "SELECT * FROM trabalho2.produtos2 WHERE id_produto = '$id_produto'";
  $result = pg_query($conn, $sql);
  if (pg_num_rows($result) > 0) {
  while($row = pg_fetch_assoc($result)) {
    $preco = $row['preco'];
    }
  }

  $sql = "SELECT * FROM trabalho2.encomendas WHERE id_cliente = '$id_cliente' ORDER BY id_encomenda ASC";
  $result = pg_query($conn, $sql);
  if (pg_num_rows($result) > 0) {
  while($row = pg_fetch_assoc($result)) {
    $id_encomenda = $row['id_encomenda'];
    }
  }

  $preco_total = $preco*$quantidade_produto;
  $sql = "INSERT into trabalho2.order_produtos (id_encomenda, id_produto, quantidade_produto, preco) VALUES ('$id_encomenda', '$id_produto','$quantidade_produto','$preco_total')";
  $result = pg_query($conn, $sql);




}






      ?>





   </body>
 </html>
 <?php
 }else {
   header("Location: index.php");
   exit();
 }
  ?>
