<?php
session_start();

$address = "172.29.0.42";
$port    = 5050;


if (isset($_GET['id'])) {
$id = $_GET['id'];
}
if (isset($_GET['id_on'])) {
$id = $_GET['id_on'];
}




if($id == "202000"){
    $_SESSION['chargers'][202001] = 0;
    $_SESSION['chargers'][202002] = 0;
    $_SESSION['chargers'][202003] = 0;
    $_SESSION['chargers'][202004] = 0;
    $_SESSION['chargers'][202005] = 0;
    $_SESSION['chargers'][202006] = 0;
    $_SESSION['chargers'][202007] = 0;
    $_SESSION['chargers'][202008] = 0;
    $_SESSION['chargers'][202009] = 0;
    $_SESSION['chargers'][202010] = 0;
}
if ($id == "202000_on") {
  $_SESSION['chargers'][202001] = 1;
  $_SESSION['chargers'][202002] = 1;
  $_SESSION['chargers'][202003] = 1;
  $_SESSION['chargers'][202004] = 1;
  $_SESSION['chargers'][202005] = 1;
  $_SESSION['chargers'][202006] = 1;
  $_SESSION['chargers'][202007] = 1;
  $_SESSION['chargers'][202008] = 1;
  $_SESSION['chargers'][202009] = 1;
  $_SESSION['chargers'][202010] = 1;
}
else{
    if (isset($_GET['id'])) {
      $_SESSION['chargers'][$id] = 0;
    }
    if (isset($_GET['id_on'])) {
        $_SESSION['chargers'][$id] = 1;
    }
}

//Build JSON data
$json_data = $_SESSION['chargers'];

// Turn data to string
//$data = json_encode(new ArrayValue($json_data), JSON_PRETTY_PRINT);
//$data = serialize($json_data);

var_dump($json_data);
//$header_len = pack('I',strlen($data));


/* Create a TCP/IP socket. */
/*
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}

echo "Attempting to connect to '$address' on port '$port'...";
$result = socket_connect($socket, $address, $port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}

//Disconnect
$discon = ['module'=>'disconnected'];
// Turn data to string
$data_discon = json_encode(new ArrayValue($discon), JSON_PRETTY_PRINT);
//$data = serialize($json_data);
$header_len_disc = pack('I',strlen($data_discon));

// MSG data
echo "Sending HEADER ...";
socket_write($socket, $header_len);
echo "OK.\n";
echo "Sending DATA ...";
socket_write($socket, $data);
echo "OK.\n";
/*
// MSG disconnect
echo "Sending HEADER ...";
socket_write($socket, $header_len_disc);
echo "OK.\n";
echo "Sending DISCONNECT msg ...";
socket_write($socket, $data_discon);
echo "OK.\n";
*/
//echo "Closing socket...";
//socket_close($socket);
//echo "OK.\n\n";

//header("Location: home.php");

?>
