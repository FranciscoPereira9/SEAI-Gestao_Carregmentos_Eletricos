##
# IMPORTS
##
import socket
import threading
import time
from threading import Lock

import common
from Controlo.Algoritmo import chargers_config as chargers
from Controlo.Algoritmo import control as ctrl
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
    #print(f"[NEW CONNECTION] Address: {addr}.")
    connected = True
    # Decode msgs while connected
    while connected:
        msg = common.receive_json_message(conn)
        if msg:
            if msg['module']=='disconnected':
                connected = False
                print(f"[DISCONNECT] Address: {addr}.")
            else:
                # Tratar a mensagem
                handle_msg(conn, msg)

    # Close connection
    conn.close()

# Function to handle messages
def handle_msg(conn, json_data):
    # Messages from STUB
    if json_data['module'] == 'stub':
        # Uncomment line below to print message received from STUB
        # print("Message STUB:\n ", json_data)
        # Update charger info
        x = ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOccupation'], json_data['newConnection'],
                        json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'], json_data['maxPower'])
        # Enviar info para carregador
        common.send_json_message(conn, x)
        # Uncomment line below to print message sent to stub
        #print("STUB ",x['chargerID']," : ", x)

    # Messages from INTERFACE
    elif json_data['module'] == 'interface':
        # Uncomment line below to print message received from INTERFACE
        # print("Message INTERFACE:\n ", json_data)
        # Update info from Interface
        ctrl.run_control(json_data['module'], json_data['chargerID'], json_data['stateOccupation'],
                             json_data['newConnection'],
                             json_data['chargingMode'], json_data['voltageMode'], json_data['instPower'],
                             json_data['maxPower'])


    # Messages from MANAGEMENT
    elif json_data['module'] == 'management':
        # Uncomment line below to print message received from MANAGEMENT
        # print("Message MANAGEMENT:\n ", json_data)
        # Change on charger's state, management priority -> act accordingly
        for key in json_data:
            if key != 'module':
                if json_data[key] == 0: # Caso de interrupção do carregador
                    ctrl.run_control(json_data['module'], int(key), 0, 0, 0, 0, 0, 0)
                    # Uncomment line below to see which STUB's are paused
                    # print(key + " Paused")
                elif json_data[key] == 1: # Caso de carregador ativo
                    ctrl.run_control(json_data['module'], int(key), 1, 1, 1, 1, 1, 1)
                    # Uncomment line below to see which STUB's are running
                    # print(key + " Running")
                else:
                    print("Wrong value." + json_data[key] +" value is not a valid one.")

    # Case of unknown module identifier
    else:
        print('Unknown module.')

def print_chargers():
    while True:
        print(chargers.charger1)
        print(chargers.charger2)
        print(chargers.charger3)
        print(chargers.charger4)
        print(chargers.charger5)
        print(chargers.charger6)
        print(chargers.charger7)
        print("\n\n")
        time.sleep(1)


# StartUp Routine
ctrl.startUp()
#threading.Thread(target=print_chargers).start()
# Create socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP
# Bind socket
s.bind(ADDR)
# Start server
print("Server is starting .....")
start_server()
