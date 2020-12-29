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

HEADER = 64
PORT = 5050
SERVER = socket.gethostbyname(socket.gethostname())
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"
lock = Lock()

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
        msg = common.receive_json_message(conn)
        if msg:
            if msg == DISCONNECT_MESSAGE:
                connected = False
            else:
                # Tratar a mensagem
                lock.acquire()
                print(f"Aquire from: {addr}.")
                try:
                    handle_msg(conn, msg)
                finally:
                    print("Release.\n")
                    lock.release()

        '''msg_length = conn.recv(HEADER).decode(FORMAT)
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

            # print(f"[{addr}] {msg}")'''

    # CLose connection
    conn.close()


# Function to handle messages
def handle_msg(conn, json_data):
    # print("Message received:\n ", json_data)

    # Messages from STUB
    if json_data['module'] == 'stub':
        print("Message received:\n ", json_data)
        # Update charger info
        #lock.acquire()
        #try:
        x = ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOcupation'], json_data['newConnection'],
                        json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'], json_data['maxPower'])
            # Enviar info para carregador
            # print("Sending message... :", x)
        common.send_json_message(conn, x)
        #finally:
        #    lock.release()






    # Messages from INTERFACE
    elif json_data['module'] == 'interface':
        print("Message received:\n ", json_data)
        #conn.send("Reponding to INTERFACE.".encode(FORMAT))
        # Update info from Interface
        #lock.acquire()
        #try:
        ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOcupation'],
                             json_data['newConnection'],
                             json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'],
                             json_data['maxPower'])
        #finally:
         #   lock.release()

    # Messages from MANAGEMENT
    elif json_data['module'] == 'management':
        conn.send("És gestão".encode(FORMAT))
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
#Start server
print("Server is starting .....")
start_server()
