<?php
include "db_conn.php";
include "functions.php";
 ?>



<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <link href='https://fonts.googleapis.com/css?family=Prompt' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="style_header.css">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <body>
<div class="grey_bar">
<div class="logo">
  <div class="image">
    <img src="logo.png" alt="" class="logo">
    <h6 class="marca">Pocketphones</h6>
  </div>
</div>
<div class="search">
  <form class="" action="details.php" method="post">
<div class="search_lupa">
  <input  name="search" id="search" class="form-control form-control-lg rounded-0 border-info" class="search_nav_bar"type="text" placeholder="Procurar.." style="margin-top:120px;">
  <div class="lupa">
    <button type="submit" name="submit" class="botao_pesquisa"><i class="fas fa-search"></i></button>
</div>
</div>

  </form>

</div>



<div class="carro_compras">
  <i class="fas fa-shopping-cart"></i>
</div>
<div class="user">
  <i class="fas fa-user"></i>
</div>

</div>
<div class="white_bar">
  <ul>
    <li class="todos"><a class="todos1" href="todos.php">Todos</a></li>

    <li class="iphone"><a class="todos1" href="iphones.php">iPhone</a>
    <select placeholder="iPhone" class="select_header" name="iphone" onchange="location = this.value;">
      <option placeholder="" value=""></option>
      <?php
      $sql = "SELECT * FROM trabalho2.produtos2 WHERE marca = 'Apple'";
      $result = pg_query($conn, $sql);
         if (pg_num_rows($result)>0) {
           while ($row = pg_fetch_assoc($result)) {
             $id_produto = $row['id_produto'];
             $nome = $row['nome'];
             ?>
             <option placeholder="iPhone" value=produtos_ind.php?id_produto=<?php echo $id_produto; ?>><?php echo $nome; ?></option>
             <?php

                   }
                  }
       ?>
    </select></li>

    <li><a class="todos1" href="samsung.php">Samsung</a>
    <li class="samsung_xiaomi"><select placeholder="Samsung" class="select_header" name="samsung" onchange="location = this.value;">
        <option placeholder="" value=""></option>
      <?php
      $sql = "SELECT * FROM trabalho2.produtos2 WHERE marca = 'Samsung'";
      $result = pg_query($conn, $sql);
         if (pg_num_rows($result)>0) {
           while ($row = pg_fetch_assoc($result)) {
             $id_produto = $row['id_produto'];
             $nome = $row['nome'];
             ?>
             <option placeholder="Samsung" value=produtos_ind.php?id_produto=<?php echo $id_produto; ?>><?php echo $nome; ?></option>
             <?php

                   }
                  }
       ?>
    </select></li>

        <li><a class="todos1" href="xiaomi.php">Xiaomi</a>
    <li class="samsung_xiaomi"><select placeholder="Xiaomi" class="select_header" name="xiaomi" onchange="location = this.value;">
<option placeholder="" value=""></option>
      <?php
      $sql = "SELECT * FROM trabalho2.produtos2 WHERE marca = 'Xiaomi'";
      $result = pg_query($conn, $sql);
         if (pg_num_rows($result)>0) {
           while ($row = pg_fetch_assoc($result)) {
             $id_produto = $row['id_produto'];
             $nome = $row['nome'];
             ?>
             <option placeholder="Xiaomi" value=produtos_ind.php?id_produto=<?php echo $id_produto; ?>><?php echo $nome; ?></option>
             <?php

                   }
                  }
       ?>
    </select></li>
    <li class="todos"><a class="todos1" href="contactos.php">Contactos</a></li>
  </ul>
</div>

<div class="col-md-5">
  <div class="list_group" id="show-list" id="teste">
    <a href="#" class="list-group-item list-group-item-action border-1"></a>
  </div>
</div>
</div>
<script type="text/javascript">
          $(document).ready(function () {
              $("#show-list").html("");
        // Send Search Text to the server
        $("#search").keyup(function () {
        let searchText = $(this).val();
        if (searchText != "") {
          $.ajax({
            url: "action.php",
            method: "post",
            data: {
              query: searchText,
            },
            success: function (response) {
              console.log(response);
              $("#show-list").html(response);
            },
          });
        }
        else {
          $("#show-list").html("");
        }
        });
        // Set searched text in input field on click of search button
        $(document).on("click", "a", function () {
        $("#search").val($(this).text());
        $("#show-list").html("");
        });
        });
</script>


  </body>
</html>
