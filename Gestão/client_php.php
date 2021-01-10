<?php
$address    = "172.29.0.120";
$port    = 5050;


class ArrayValue implements JsonSerializable {
    public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }
}

//Build JSON data
$json_data = ['module'=>'management','202001' => 1, '202002' => 1];
// Turn data to string
$data = json_encode(new ArrayValue($json_data), JSON_PRETTY_PRINT);
//$data = serialize($json_data);
$header_len = pack('I',strlen($data));


/* Create a TCP/IP socket. */

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

echo "Sending HEADER ...";
socket_write($socket, $header_len);
echo "OK.\n";
echo "Sending DATA ...";
socket_write($socket, $data);
echo "OK.\n";


echo "Closing socket...";
socket_close($socket);
echo "OK.\n\n";

?>