import json
import socket
import struct

HEADER = 64
PORT = 5050
SERVER = "172.29.0.15"
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"

 #Define message to send
msg = {
    "module": 'interface', #<-
    "chargerID": 202002, #<-
    "stateOcupation": 0,
    "newConnection": 0, #<-
    "chargingMode": 1, #<-
    "voltageMode": 0,
    "instPower": 0,
    "maxPower": 0,
    "voltage": 0
}

def receive_json_message(sock, timeout=None):
    sock.settimeout(timeout)

    try:
        data = sock.recv(struct.Struct("!I").size)
        if len(data) == 0:
            return None

        size = struct.Struct("!I").unpack(data)

        data = sock.recv(size[0])
        if len(data) == 0:
            return None

        json_data = json.loads(data.decode("utf-8"))
        # print(json_data)
        return json_data
    except TimeoutError:
        print("Timeout!")
        return None


def send_json_message(sock, json_data):
    data = json.dumps(json_data)
    data_size = len(data.encode("utf-8"))
    header = struct.pack("!I", data_size)

    # print("Sending packet... (identifier:{}, {:.2f}kWh, {:.2f}%)".format(*values))
    sock.send(header)
    print(data)
    sock.send(bytes(data, "utf-8"))


# Criar socket
client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP

# Connect to server in the same port
client.connect(ADDR)

# Send message to CONTROLO
send_json_message(client, msg)
#print(client.recv(2048).decode(FORMAT))
