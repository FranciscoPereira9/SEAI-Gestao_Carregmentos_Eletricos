<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="image">
      <img src="portophones.png" alt="">
      <span><b>PocketPhones</b></span>
    </div>
    <form action="register_database.php" method="post">
<h2>REGISTER</h2>
<?php if (isset($_GET['error'])) { ?>
  <p class="error"> <?php echo $_GET['error']; ?></p>
<?php } ?>
<label>Name</label>
<input type="text" name="name" placeholder="Name">

<label>Adress</label>
<input type="text" name="adress" placeholder="Adress">

<label>Mobile Number</label>
<input type="text" name="mobile" placeholder="Mobile number">

<label>User Name</label>
<input type="text" name="uname" placeholder="Username">

<label>Password</label>
<input type="password" name="password" placeholder="Password">
<button type="submit" name="button">Register</button>



  </form>
  </body>
</html>
