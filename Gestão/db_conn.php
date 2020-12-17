<?php

//connection to the DB
       $host        = "host = db.fe.up.pt";
       $port        = "port = 5432";
       $dbname      = "dbname = siem2020";
       $credentials = "user = siem2020 password=YuyaMyDj";

       $conn = pg_connect( "$host $port $dbname $credentials"  );
       if(!$conn) {
          echo "Error : Unable to open database\n";
       } else {
          echo "";
       }

 ?>
