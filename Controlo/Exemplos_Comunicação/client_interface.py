import json
import socket
import common

HEADER = 64
PORT = 5050
SERVER = "172.29.0.23"
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"

 #Define message to send
msg = {
    "module": 'interface', #<-
    "chargerID": 202001, #<-
    "stateOcupation": 0,
    "newConnection": 0, #<-
    "chargingMode": 0, #<-
    "voltageMode": 0,
    "instPower": 0,
    "maxPower": 0,
    "voltage": 0
}


# Criar socket
client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP

# Connect to server in the same port
client.connect(ADDR)

# Send message to CONTROLO
common.send_json_message(client, msg)
print(client.recv(2048).decode(FORMAT))
