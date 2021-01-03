##
# IMPORTS
##
import json
import socket
import threading
from threading import Lock
import struct
import os
import sys
import common
from Controlo.Algoritmo import control as ctrl
from Controlo.Algoritmo import chargers_config as config
#cd = os.path.dirname(os.path.realpath(__file__))
#pd = os.path.dirname(cd)
#sys.path.append(pd)
#from Algoritmo import control as ctrl
# --------------------------------------------------------------- #

# Define server parameters
HEADER = 64
PORT = 5050
SERVER = socket.gethostbyname(socket.gethostname())
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"

# Instantiate Lock object for thread access manipulation
lock = Lock()

# Function to establish new connections
# (keeps running on main thread always listening for connections)
def start_server():
    # Listen
    s.listen(15)  # Queue of 15 connections
    print(f"[LISTENNING] On: {ADDR}")
    while True:
        # Accept connections and start a new thread to handle each
        conn, addr = s.accept()
        thread = threading.Thread(target=handle_client, args=(conn, addr))
        thread.start()
        print(f"[# CONNECTIONS] {threading.activeCount() - 1}")


# Function to handle clients connections
def handle_client(conn, addr):
    print(f"[NEW CONNECTION] Address: {addr}.")
    connected = True
    # Decode msgs while connected
    while connected:
        msg = common.receive_json_message(conn)

        if msg:
            if msg['module']=='disconnected':
                connected = False
            else:
                # Tratar a mensagem
                handle_msg(conn, msg)

    # Close connection
    conn.close()

# Function to handle messages
def handle_msg(conn, json_data):
    # Messages from STUB
    if json_data['module'] == 'stub':
        print("Message STUB:\n ", json_data)
        # Update charger info
        x = ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOcupation'], json_data['newConnection'],
                        json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'], json_data['maxPower'])
        # Enviar info para carregador
        # print("Sending message... :", x)
        common.send_json_message(conn, x)

    # Messages from INTERFACE
    elif json_data['module'] == 'interface':
        print("Message INTERFACE:\n ", json_data)
        # Update info from Interface
        ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOcupation'],
                             json_data['newConnection'],
                             json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'],
                             json_data['maxPower'])

    # Messages from MANAGEMENT
    elif json_data['module'] == 'management':
        print("Message MANAGEMENT:\n ", json_data)
        # Como é que o sistema trata as mensagens vindas da gestão
        if json_data['state'] == -1:
            print("Interrupção.")
        else:
            print("Funcionamento Normal.")


# StartUp Routine
ctrl.startUp()

# Create socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP
# Bind socket
s.bind(ADDR)
# Start server
print("Server is starting .....")
start_server()
