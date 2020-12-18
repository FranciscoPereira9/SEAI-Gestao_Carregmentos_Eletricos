# Config File - for chargers and currents
# Unit Tested

# Minimum Power 4 Fast Charging - in Watts
fastACPow = 43 * 1000
fastDCPow = 50 * 1000
# Maximum Power 4 Normal Charging - in Watts
normalPow = 22 * 1000

# charger = {
#   "chargerID" : 202001,   -> Year + Order
#   "stateOcupation" : 0,   -> 0 Free, 1 Occupied
#   "newConnection" : 0,    -> 1 New Car Connected, 0 
#   "chargingMode" : 0,     -> 0 NormalCharging, 1 FastCharging, 2 NoCharging
#   "voltageMode":  0,      -> 0 DC, 1 AC
#   "instPower": 0,       -> Instantaneous Power
#   "maxPower": 0,        -> Max Power Allowed
#   "voltage": 400          -> Applied Voltage = Constant
# }

charger1 = {
  "chargerID" : 202001,
  "stateOcupation" : 1,
  "newConnection" : 0,
  "chargingMode" : 1,
  "voltageMode":  0,
  "instPower": 120,
  "maxPower": 200,
  "voltage": 400
}

charger2 = {
  "chargerID" : 202002,
  "stateOcupation" : 1,
  "newConnection" : 0,
  "chargingMode" : 1,
  "voltageMode":  0,
  "instPower": 400,
  "maxPower": 0,
  "voltage": 400
}

charger3 = {
  "chargerID" : 202003,
  "stateOcupation" : 0,
  "newConnection" : 1,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger4 = {
  "chargerID" : 202004,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger5 = {
  "chargerID" : 202005,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger6 = {
  "chargerID" : 202006,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger7 = {
  "chargerID" : 202007,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger8 = {
  "chargerID" : 202008,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger9 = {
  "chargerID" : 202009,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

charger10 = {
  "chargerID" : 202010,
  "stateOcupation" : 0,
  "newConnection" : 0,
  "chargingMode" : 0,
  "voltageMode":  0,
  "instPower": 0,
  "maxPower": 0,
  "voltage": 400
}

chargersSet = {
  "charger1" : charger1,
  "charger2" : charger2,
  "charger3" : charger3,
  "charger4" : charger4,
  "charger5" : charger5,
  "charger6" : charger6,
  "charger7" : charger7,
  "charger8" : charger8,
  "charger9" : charger9,
  "charger10" : charger10
}
