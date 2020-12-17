<?php
session_start();
include "header.php";
include "db_conn.php";


$id_produto = $_GET['id_produto'];

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
    $sql = "SELECT * FROM trabalho2.produtos2 WHERE id_produto = '$id_produto'";
    $result = pg_query($conn, $sql);
    if (pg_num_rows($result) > 0) {
    while($row = pg_fetch_assoc($result)) {
      $codigo = $row['codigo'];
      $nome = $row['nome'];
      $descricao = $row['descricao'];
      $quantidade_disponivel = $row['quantidade_disponivel'];
      $preco = $row['preco'];
      $foto = $row['foto'];
      $cor = $row['cor'];
      $capacidade = $row['capacidade'];
      }
    }
     ?>

     <div class="container_ind">
       <div class="foto">
          <img src="<?php echo $foto;  ?> " alt="">
       </div>
       <div class="info_ind">
         <div class="container_info">
           <div class="nome_produto">
             <div class="nome_ind">
                <h3> <?php echo $nome; ?></h3>
             </div>

           </div>
           <div class="cor_capacidade">
             <h4><?php echo "$cor | $capacidade"; ?></h4>
           </div>
           <div class="qntd_disp">
              <h4><?php echo "Quantidade disponível: "; ?><b><?php echo $quantidade_disponivel; ?></b></div>
           <div class="descricao_ind">
              <h4>Descrição:</h4>
           </div>
           <div class="quantidade_cliente">

           </div>

         </div>
       </div>
     </div>

<div class="teste">

  <p><?php echo $descricao; ?></p>
</div>

<div class="botoes_ind">
 <form class="" action="adicionar.php?id_produto=<?php echo $id_produto; ?>" method="post">
   <div class="quantidade_cliente">
     Quantidade <select class="quantidade" name="quantidade_client">
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
     </select>
   </div>
   <button type="submit" name="adicionar_carrinho">Adicionar ao carrinho</button>
   <button type="submit" name="finalizar_encomenda">Finalizar encomenda</button>
 </form>
</div>

  </body>
</html>
<?php
}else {
  header("Location: index.php");
  exit();
}
 ?>
