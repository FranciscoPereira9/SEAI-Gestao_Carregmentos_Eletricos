import json
import socket

HEADER = 64
PORT = 5050
SERVER = "192.168.192.7"
ADDR = (SERVER, PORT)
FORMAT = 'utf-8'
DISCONNECT_MESSAGE = "!DISCONNECT"

# Define message to send
'''
charger_string = {
    "chargers": [
        {
            "module": 0
            "ID": "202010",
            "state_occupation": true,
            "new_connection": true,
            "charging_mode": true,
            "voltage_mode": false,
            "instant_current": 120,
            "max_current": 200,
            "voltage": 230
        }
    ]
}
'''


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


class Charger:

    def __init__(self, ID, charging_mode, voltage_mode, max_current, voltage, state_occupation, new_connection,
                 instant_current):
        self.module = 0
        self.ID = ID
        self.charging_mode = charging_mode
        self.voltage_mode = voltage_mode
        self.max_current = max_current
        self.voltage = voltage
        self.state_occupation = state_occupation
        self.new_connection = new_connection
        self.instant_current = instant_current


# Criar socket
client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)  # AF_INET - IPV4 and SOCK_STREAM has by default TCP

# Connect to server in the same port
client.connect(ADDR)

ch202010 = Charger("202010", True, False, 200, 230, True, True, 120)

# Send a message to the SERVER
jdata = json.dumps(ch202010.__dict__)
# Send message to Controlo
send_msg(jdata)
print(client.recv(2048).decode(FORMAT))
send_msg(DISCONNECT_MESSAGE)

# "chargerID" : 202001, -> Year + Order
# "stateOcupation" : 0, -> 0 Free, 1 Occupied
# "newConnection" : 0, -> 1 New Car Connected, 0
# "chargingMode" : 0, -> 0 NormalCharging, 1 FastCharging
# "voltageMode": 0, -> 0 DC, 1 AC
# "instCurrent": 0, -> Instantaneous Current
# "maxCurrent": 0, -> Max Current Allowed
# "voltage": 230 -> Applied Voltage = Constant
