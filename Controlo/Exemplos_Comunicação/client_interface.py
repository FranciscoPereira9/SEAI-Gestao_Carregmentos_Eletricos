import json
import socket

HEADER = 64
PORT = 5050
SERVER = "192.168.192.7"
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"

# Define message to send
msg = {
        "module": 1,
        "ID": "202001",
        "state": 1,
    }



# Function to encode and send messages to the server
def send_msg(msg):
    # Encode msg and header
    encoded_msg = msg.encode(FORMAT)
    msg_length = len(encoded_msg)
    encoded_header = str(msg_length).encode(FORMAT)
    encoded_header += b' ' * (HEADER - len(encoded_header))
    # Send msgs to server
    client.send(encoded_header)
    client.send(encoded_msg)


# end of function send_msg ----------------------------------


# Criar socket
client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP

# Connect to server in the same port
client.connect(ADDR)

# Send a message to the SERVER
jdata = json.dumps(msg)
# Send message to Controlo
send_msg(jdata)
print(client.recv(2048).decode(FORMAT))
send_msg(DISCONNECT_MESSAGE)

