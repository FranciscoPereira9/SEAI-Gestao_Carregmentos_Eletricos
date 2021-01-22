<link rel="stylesheet" href="style1.css">
<a class="db" ><?php

//connection to the DB
       $host        = "host = db.fe.up.pt";
       $port        = "port = 5432";
       $dbname      = "dbname = up201504961";
       $credentials = "user = up201504961 password=32FiuJr2X";

       $conn = pg_connect( "$host $port $dbname $credentials" );
       if(!$conn) {
          echo "Error : Unable to open database\n";
       } else {
          echo "Connected!!\n";
       }



 ?></a>
