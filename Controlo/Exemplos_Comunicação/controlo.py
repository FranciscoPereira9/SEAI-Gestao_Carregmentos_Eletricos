import json
import socket
import threading
import os
import sys
cd = os.path.dirname(os.path.realpath(__file__))
pd = os.path.dirname(cd)
sys.path.append(pd)
from Algoritmo import control as ctrl

HEADER = 64
PORT = 5050
SERVER = socket.gethostbyname(socket.gethostname())
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"

# Create socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP

# Bind socket
s.bind(ADDR)


# Function to establish new connections
def start_server():
    # Listen
    s.listen(15)  # Queue of 15 connections
    print(f"[LISTENNING] On: {SERVER}")

    while True:
        conn, addr = s.accept()  # Accept connections and start new thread to handle it
        thread = threading.Thread(target=handle_client, args=(conn, addr))
        thread.start()
        print(f"[# CONNECTIONS] {threading.activeCount() - 1}")


# Function to handle clients connections
def handle_client(conn, addr):
    print(f"[NEW CONNECTION] Address: {addr}.")
    connected = True
    # Decode msgs while connected
    while connected:
        msg_length = conn.recv(HEADER).decode(FORMAT)
        if msg_length:  # Verifify that it is not null
            # Decode the message
            msg_length = int(msg_length)
            msg = conn.recv(msg_length).decode(FORMAT)

            # Verifify is it's a closing msg
            if msg == DISCONNECT_MESSAGE:
                connected = False
            else:
                # Tratar a mensagem
                handle_msg(conn, msg)

            # print(f"[{addr}] {msg}")

    # CLose connection
    conn.close()


# Function to handle messages
def handle_msg(conn, msg):
    json_data = json.loads(msg)  # Load msg as json - dictionary

    # print(json_data)

    if json_data['module'] == 'stub':
        # Como é que o sistema trata as mesnagens vindas do controlo
        # update charger state
        x = ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOcupation'], json_data['newConnection'],
                        json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'], json_data['maxPower'])
        # enviar info para carregador
        # x = json.dumps(x)
        send_msg(conn, x)

    elif json_data['module'] == 'interface':
        conn.send("És interface".encode(FORMAT))
        # Como é que o sistema trata as mesnagens vindas da interface

        x = ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['state_occupation'],
                             json_data['newConnection'],
                             json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'],
                             json_data['maxPower'])

        if json_data['state'] == 0:
            print("[", json_data['ID'], "]", " Livre.")
        elif json_data['state'] == 1:
            print("[", json_data['ID'], "]", " Carregamento Normal.")
        elif json_data['state'] == 2:
            print("[", json_data['ID'], "]", " Carregamento Rápido.")
        elif json_data['state'] == -1:
            print("[", json_data['ID'], "]", " Interrupção.")

    elif json_data['module'] == 'management':
        conn.send("És gestão".encode(FORMAT))
        # Como é que o sistema trata as mensagens vindas da gestão
        if json_data['state'] == -1:
            print("Interrupção.")
        else:
            print("Funcionamento Normal.")



def send_msg(conn, msg):
    # Encode msg and header
    print('X = ', msg)
    msg = json.dumps(msg)
    encoded_msg = msg.encode(FORMAT)
    msg_length = len(encoded_msg)
    encoded_header = str(msg_length).encode(FORMAT)
    encoded_header += b' ' * (HEADER - len(encoded_header))
    # Send msgs to server
    conn.send(encoded_header)
    conn.send(encoded_msg)

print("Server is starting .....")
start_server()

# Message to receive from Interface and Gestão
# ID: 2020(xx);
# State: (2/1/0/-1);
# 2 - Rápido
# 1 - Normal
# 0 - Desligado
# -1 - Interrupção


# Message to get from Carregadores
# charger = {
# from: 0;
# "chargerID" : 202001, -> Year + Order
# "stateOcupation" : 0, -> 0 Free, 1 Occupied
# "newConnection" : 0, -> 1 New Car Connected, 0
# "chargingMode" : 0, -> 0 NormalCharging, 1 FastCharging
# "voltageMode": 0, -> 0 DC, 1 AC
# "instCurrent": 0, -> Instantaneous Current
# "maxCurrent": 0, -> Max Current Allowed
# "voltage": 230 -> Applied Voltage = Constant
# }
