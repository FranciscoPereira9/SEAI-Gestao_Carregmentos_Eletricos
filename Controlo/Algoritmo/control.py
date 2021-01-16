# https://www.w3schools.com/python/default.asp
# Unit Tested

# TODO
# - Green Charging

import sys
sys.path.append('../')

from threading import Lock
lock = Lock()

from Controlo.BaseDados.database import database
db = database()

from Controlo.Algoritmo import chargers_config

# Load Chargers Configs from chargers_config
chargers = chargers_config.chargersSet
chargersEmer = chargers_config.chargersEmer

# Load Charging Configs - in Kw
fastACPow = chargers_config.fastACPow
fastDCPow = chargers_config.fastDCPow
normalMaxPow = chargers_config.normalPow

# Constants
INSTALLED_POWER = len(chargers) * normalMaxPow

# Flag - Fast Charging Availability
fastChargAvail = 1 # 1 - Available ; 0 - Not Available

# Flag - Green Charging Availability
greenChargAvail = 1 # 1 - Available ; 0 - Not Available

# Individual Functions
def run_control(module, ID, state_occupation, new_connection, charging_mode, voltage_mode, inst_power, max_power):
    # Atualiza o dicionario
    updateChargersState(module, ID, state_occupation, new_connection, charging_mode, voltage_mode, inst_power, max_power)
    
    chargerKey = dictionaryKeyFromID(ID)
    return chargers.get(chargerKey)   
        
        
def updateChargersState(module, ID, state_occupation, new_connection, charging_mode, voltage_mode, inst_power, max_power):
    # Comunica com os carregadores e interface, atualiza o estado e a db
    chargerKey = dictionaryKeyFromID(ID)
    
    # PROVENIENTE DO CARREGADOR
    # Se newConnection = 1:
    #    - maxPower = 0 -> Current maxima nula
    #    - chargingMode = 2 -> Sem tipo de carregamento atribuido
    if(module == 'stub'):
        # NEW CONNECTION
        if ((new_connection == 1) and (state_occupation == 0) and (charging_mode == 2)):
            # Update Flags DB - 1 time - "Rising Edge"
            if((new_connection == 1) and (chargers.get(chargerKey).get("newConnection") == 0)):
                updateFlagsDB(ID)
                
            # Still waiting for interface reply and not interrupted
            if ((chargers.get(chargerKey).get("chargingMode") == 2) and (chargersEmer[chargerKey] == 1)):
                lock.acquire()
                chargers.get(chargerKey).update({"newConnection": new_connection})
                chargers.get(chargerKey).update({"voltageMode": voltage_mode})
                lock.release()
                print("NEW CONNECTION", chargerKey," \n")
                # Update DB - New Charger
                try:
                    db.new_connection(ID, new_connection)
                except:
                    print("An exception occurred -> DB")
            
            # Interface already updated chargingMode and not interrupted
            elif ((chargers.get(chargerKey).get("chargingMode") != 2) and (chargersEmer[chargerKey] == 1)):
                print("INTERFACE UPDATED CHARGING MODE", chargerKey,"  \n")
                # Continue here
        
        # NEW MEASURE
        elif((new_connection == 0) and (state_occupation == 1) and (charging_mode != 2)):
            # Charging stopped
            if((chargers.get(chargerKey).get("chargingMode") == 2) or (chargersEmer[chargerKey] == 0)):
                print("CHARGING STOPPED", chargerKey,"  \n")
                # Continue Here
                
            # Everything working normal
            elif((chargers.get(chargerKey).get("chargingMode") != 2) and (chargersEmer[chargerKey] == 1)):
                # Charging continues
                if(inst_power > 0):
                    lock.acquire()
                    chargers.get(chargerKey).update({"instPower": inst_power})
                    lock.release()
                    # Update Power
                    updateMaxPowers(ID)
                    # Update DB - New Measure
                    print("NEW MEASURE", chargerKey,"  \n")
                    try:
                        db.new_measure(ID, inst_power, chargers.get(chargerKey).get("voltage"), max_power)
                    except:
                        print("An exception occurred -> DB")
        
        # BATTERY FULL - STOPPED CHARGING
        elif( (new_connection == 0) and (state_occupation == 1) and (charging_mode == 2) ):
            # Verifica se a interface ja parou
            if((chargers.get(chargerKey).get("stateOccupation") != 0) and (chargersEmer[chargerKey] == 1)):
                 # reset as variaveis do carregador
                resetCharger(chargerKey)
                print("CHARGING STOPPED")
                # Update DB - fori = true if interrompido, false if terminado
                try:
                    db.stop_charging(ID, False, 0) 
                except:
                    print("An exception occurred -> DB")
                    # Continue Here
                    
            elif((chargers.get(chargerKey).get("stateOccupation") == 0) or (chargersEmer[chargerKey] == 0)):
                print("CHARGING ALREADY STOPPED", chargerKey, "\n")
    
    # PROVENIENTE DA GESTAO
    # Se 'all':
    #       - 0 -> charging stopped, resetChargers
    #       - 1 -> charger restarted
    if(module == 'management'):
        if((state_occupation == 0) and (chargers.get(chargerKey).get("stateOccupation") != state_occupation)):
            # Stops 1 charger
            chargersEmer[chargerKey] = 0
            # Resets Chargewr Variables
            resetCharger(chargerKey)
            # Update DB - fori = true if interrompido, false se terminado
            try:
                db.stop_charging(ID, True, 0)
            except:
                print("An exception occurred -> DB")
        
        elif(state_occupation == 1 and (chargers.get(chargerKey).get("stateOccupation") != state_occupation)):
            # Restarts 1 charger
            chargersEmer[chargerKey] = 1
            resetCharger(chargerKey)
     
    
    # PROVENIENTE DA INTERFACE
    # ChargingMode:
    #    - 0 ou 1 -> Calcula Corrente
    #    - 2 -> Parou o carregamento - Reset as Variaveis
    if(module == 'interface'):        
        # Charging Mode Selected
        if ((charging_mode != 2) and (chargersEmer[chargerKey] == 1)):
            # Verifica se o carregador está ligado
            if(chargers.get(chargerKey).get("newConnection") == 1):
                # Interface atualiza o modo de carregamento
                lock.acquire() #Adicionado
                chargers.get(chargerKey).update({"chargingMode": charging_mode})
                lock.release() #Adicionado
                # update Power
                updateMaxPowers(ID)
            
            # Caso nao esteja ligado
            elif(chargers.get(chargerKey).get("newConnection") != 1):
                print("CHARGER IS NOT ACTIVE")
                # Continue Here
        
        # Charging Stopped
        elif ((charging_mode == 2) or (chargersEmer[chargerKey] == 0)):
            # Verifica se está ocupado
            if(chargers.get(chargerKey).get("stateOccupation") == 1):
                # Update DB - fori = true if interrompido, false se terminado
                # reset as variaveis do carregador
                resetCharger(chargerKey)
                try:
                    db.stop_charging(ID, False, 0) 
                except:
                    print("An exception occurred -> DB")
                    
            elif(chargers.get(chargerKey).get("stateOccupation") != 1):
                print("CHARGER ALREADY STOPPED")
                        

def updateMaxPowers(ID):
    totalPower = 0
    
    # PARA VEICULOS JA LIGADOS ANTERIORMENTE:
    # Verifica se consome menos que o maximo atribuido e atualiza
    for key, dict in chargers.items():
        # Se a corrente instantanea e menor que a maxima
        if ( (chargers.get(key).get("instPower") < chargers.get(key).get("maxPower")) \
        and (chargers.get(key).get("newConnection") == 0) and (chargers.get(key).get("stateOccupation") == 1) ):
            # Atualizacao o novo valor da corrente maxima
            lock.acquire()  # Adicionado
            chargers.get(key).update({"maxPower": chargers.get(key).get("instPower")})
            lock.release()  # Adicionado
            print("POWER UPDATED", key,"\n")

        # Calcula o total consumido
        totalPower = totalPower + chargers.get(key).get("instPower")
    
    
    availablePower = INSTALLED_POWER - totalPower
    chargersCount = countChargers()
    newChargersCount = countNewChargers()
    
    # Potencia a distribuir para os novos carregamentos normais: normalPower
    normalPower = 0
    # So se calcula caso haja carregamentos normais
    if ( newChargersCount[3] > 0 ):
        normalPower = (availablePower - (newChargersCount[1]) * fastDCPow  \
                       - (newChargersCount[2]) * fastACPow ) / (newChargersCount[3] )
                       
    # Garante-se que nao se ultrapassa a pMax normal
    if ( normalPower > normalMaxPow ):
        normalPower = normalMaxPow
    
    # PARA VEICULOS NOVOS LIGADOS:
    # Atribui potencia maxima aos rapidos e distribui pelos restantes
    #for key, dict in chargers.items():
    key = dictionaryKeyFromID(ID)
    # Atribui corrente maxima aos carregadores rapidos
    if ( (chargers.get(key).get("newConnection") == 1) and (chargers.get(key).get("chargingMode") == 1) and (fastChargAvail == 1) ):
        # Atualizacao da nova corrente maxima DC
        if ( chargers.get(key).get("voltageMode") == 0 ):
            lock.acquire()  # Adicionado
            chargers.get(key).update({"maxPower": fastDCPow })
            # Atualizacao de "novo carregamento"
            chargers.get(key).update({"newConnection": 0 })
            # A partir deste momento estao ocupados
            chargers.get(key).update({"stateOccupation": 1 })
            lock.release()  # Adicionado
            # Atualiza db - Rapido DC
            chargerID = chargers.get(key).get("chargerID")
            print("START CHARGING FAST DC", key," \n")
            # start_charging(self, charger_id, max_curr, charge_type_int, voltage_mode, new_connection, state_occupation_int)
            try:
                db.start_charging(chargerID, fastDCPow, 1, 0, 0, 1)
            except:
                print("An exception occurred -> DB")

        # Atualizacao da nova corrente maxima AC
        elif ( chargers.get(key).get("voltageMode") == 1 ):
            lock.acquire()  # Adicionado
            chargers.get(key).update({"maxPower": fastACPow })
            # Atualizacao de "novo carregamento"
            chargers.get(key).update({"newConnection": 0 })
            # A partir deste momento estao ocupados
            chargers.get(key).update({"stateOccupation": 1 })
            lock.release()  # Adicionado
            # Atualiza DB - Rapido AC
            chargerID = chargers.get(key).get("chargerID")
            print("START CHARGING FAST AC", key," \n")
            try:
                db.start_charging(chargerID, fastACPow, 1, 1, 0, 1)
            except:
                print("An exception occurred -> DB")

    # Atribui corrente maxima possivel aos carregadores normais
    elif ( (chargers.get(key).get("newConnection") == 1) and (chargers.get(key).get("chargingMode") == 0) ):
        # Atualizacao da nova corrente maxima
        lock.acquire()  # Adicionado
        chargers.get(key).update({"maxPower": normalPower })
        # Atualizacao de "novo carregamento"
        chargers.get(key).update({"newConnection": 0 })
        # A partir deste momento estao ocupados
        chargers.get(key).update({"stateOccupation": 1 })
        lock.release()  # Adicionado
        # Atualiza DB - Normal
        chargerID = chargers.get(key).get("chargerID")
        voltageMode = chargers.get(key).get("voltageMode")
        print("START CHARGING NORMAL", key,"  \n")
        try:
            db.start_charging(chargerID, normalPower, 0, voltageMode, 0, 1)
        except:
            print("An exception occurred -> DB")
    
  
def updateFastChargAvail():
    # Atualiza a flag que descreve a disponibilidade do carregamento rapido
    totalPower = 0
    for key, dict in chargers.items():
        totalPower = totalPower + chargers.get(key).get("instPower")
    
    global fastChargAvail
    
    if (totalPower >= (INSTALLED_POWER - 1.25 * fastDCPow)):
        fastChargAvail = 0
    else:
        fastChargAvail = 1
        
        
def updateGreenChargAvail():
    # Atualiza a flag que descreve a disponibilidade do carregamento verde
    # COMUNICA COM O STUB E ATUALIZA greenPower
    greenPower = 0
    
    global greenChargAvail
    
    if(greenPower <= 1.10 * fastDCPow):
        greenChargAvail = 0
    else:
        greenChargAvail = 1


def updateFlagsDB(ID):
    # Update Flags
    updateFastChargAvail()
    updateGreenChargAvail()
    
    # Function to Update Flags
    # db.update_all_green_power(greenChargAvail)
    # db.update_all_fc_availability(fastChargAvail)
    try:
        db.update_fc_availability(ID, fastChargAvail)
    except:
        print("An exception occurred -> updateFlagsDB - FC") 
        
    try:
        db.update_green_power(ID, greenChargAvail)
    except:
        print("An exception occurred -> updateFlagsDB - GC")
    
    
def startUp():
    # Resets Chargers on DB
    try:
        db.reset_chargers()
    except:
        print("An exception occurred -> startup DB") 
        
    # Cleans DB History
    try:
        db.clean_historic_charging()
    except:
        print("An exception occurred -> clean historic DB") 
        
    # Resets Dict
    for key, dict in chargers.items():
        resetCharger(key)
    
  
def resetCharger(chargerKey):
  # Resets Charger Variables When is turned Off
  lock.acquire()  # Adicionado
  chargers.get(chargerKey).update({"stateOccupation": 0})
  chargers.get(chargerKey).update({"newConnection": 0})
  chargers.get(chargerKey).update({"chargingMode": 2})
  chargers.get(chargerKey).update({"instPower": 0})
  chargers.get(chargerKey).update({"maxPower": 0})
  lock.release()  # Adicionado
  

def dictionaryKeyFromID(ID):
    # Retorna a key ("charger1") do dicionario a partir do ID
    for key, dict in chargers.items():
        if( int( dict["chargerID"] ) == ID ):
            return key


def countChargers():
    countActive = 0
    countFastDC = 0
    countFastAC = 0
    countNormal = 0
    
    for key, dict in chargers.items():
        if( int( dict["stateOccupation"] ) == 1 ):
            countActive = countActive + 1
            
            if( (int( dict["chargingMode"] ) == 1) and (int( dict["voltageMode"] ) == 1) ):
                countFastAC = countFastAC + 1
                
            elif( (int( dict["chargingMode"] ) == 1) and (int( dict["voltageMode"] ) == 0) ):
                countFastDC = countFastDC + 1
    
    countNormal = countActive - countFastAC - countFastDC
                
    return countActive, countFastDC, countFastAC, countNormal


def countNewChargers():
    #Counts New Chargers Connected
    countNewActive = 0
    countNewFastDC = 0
    countNewFastAC = 0
    countNewNormal = 0
    
    for key, dict in chargers.items():
        if( (int( dict["stateOccupation"] ) == 0) and (int( dict["newConnection"] ) == 1) ):
            countNewActive = countNewActive + 1
            
            if( (int( dict["chargingMode"] ) == 1) and (int( dict["voltageMode"] ) == 1) ):
                countNewFastAC = countNewFastAC + 1
                
            elif( (int( dict["chargingMode"] ) == 1) and (int( dict["voltageMode"] ) == 0) ):
                countNewFastDC = countNewFastDC + 1
    
    countNewNormal = countNewActive - countNewFastAC - countNewFastDC
                
    return countNewActive, countNewFastDC, countNewFastAC, countNewNormal


# EXAMPLE SEQUENCE WITH SUCCESS
# run_control(module, ID, state_occupation, new_connection, charging_mode, voltage_mode, inst_power, max_power):
# UNCOMMENT
# run_control('stub', 202001, 0, 1, 2, 0, 0, 0)           # NEW CONNECTION
# run_control('interface', 202001, 0, 0, 0, 0, 0, 0)      # CONNECTION TYPE SELECTED - START CHARGING
# run_control('stub', 202001, 1, 0, 0, 0, 50, 200)        # NEW MEASURE
# run_control('stub', 202001, 1, 0, 0, 0, 40, 50)         # NEW MEASURE
# run_control('interface', 202001, 1, 0, 2, 0, 0, 0)     # STOP CHARGING - FROM INTERFACE
