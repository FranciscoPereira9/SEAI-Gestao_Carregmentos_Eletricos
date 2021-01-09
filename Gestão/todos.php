<?php
session_start();
include "../includes/header.php";
include "../config/db_conn.php";
include "../database/produtos.php";

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="../css/todos.css">
   </head>
   <body>
     <?php

     $result = retornaProdutos_orderBy('codigo');


     $i=0;
     $dyn_table = '<table class="tabela_din">';
     if (pg_num_rows($result) > 0) {
     while($row = pg_fetch_assoc($result)) {
       $nome = $row['nome'];
       $preco = $row['preco'];
       $foto = $row['foto'];
       $id_produto = $row['id_produto'];
       $preco = $row['preco'];



       if ($i%3==0) {
          $dyn_table .= '<tr><td>'.'
          <div class="conteudo">
              <a href="../pages/produtos_ind.php?id_produto= '.$id_produto.'"><img classe = imagem_ind_grid src=" '.$foto .'"/></a>
            <h6>'.$preco.'€</h6>
            <a href="../pages/produtos_ind.php?id_produto= '.$id_produto.'"><h5>' .$nome .'</h5></a>
            </td>
          </div>
            ';



       } else {
         $dyn_table .= '<td>'.'
           <div class="conteudo">
         <a href="../pages/produtos_ind.php?id_produto= '.$id_produto.'"><img classe = imagem_ind_grid src=" '.$foto .'"/></a>
         <h6>'.$preco.'€</h6>
         <a href="../pages/produtos_ind.php?id_produto= '.$id_produto.'"><h5>' .$nome .'</h5></a>
         </td>
           </div>
           ';
       }
   $i++;
       }
     }      ?><img src="" alt=""> <?php

     $dyn_table .= '</tr></table>';
      ?>
     <div class="grid-container">
       <div class="tabela_grid">
         <?php echo $dyn_table; ?>
       </div>





     </div>
   </body>
 </html>
 <?php
 }else {
   header("Location: ../pages/index.php");
   exit();
 }
  ?>
