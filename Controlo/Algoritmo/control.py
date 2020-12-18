# https://www.w3schools.com/python/default.asp
# Unit Tested

# TODO
# - Interrupcao pela Manutencao
# - Atualização da DB

import time
from Algoritmo import chargers_config

# Load Chargers Configs from chargers_config
chargers = chargers_config.chargersSet
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
    # Update Flags
    updateFastChargAvail()
    updateGreenChargAvail()
    # Atualiza o dicionario
    updateChargersState(module, ID, state_occupation, new_connection, charging_mode, voltage_mode, inst_power, max_power)
    
    # Atualiza as Correntes
    updateMaxPowers()
    
    # update database
    #updateDB()
                
    chargerKey = dictionaryKeyFromID(ID)
    print(chargers.get(chargerKey))
    return chargers.get(chargerKey)
    

def updateChargersState(module, ID, state_occupation, new_connection, charging_mode, voltage_mode, inst_power, max_power):
    # module: stub -> Carregador, interface, management -> Gestao 
    # Comunica com os carregadores, atualiza o estado
    # Atualiza o dicionario Chargers
    chargerKey = dictionaryKeyFromID(ID)
    
    # PROVENIENTE DO CARREGADOR
    # Se newConnection = 1:
    #    - maxPower = 0 -> Current maxima nula
    #    - chargingMode = 2 -> Sem tipo de carregamento atribuido
    if(module == 'stub'):
        chargers.get(chargerKey).update({"newConnection": new_connection})
        chargers.get(chargerKey).update({"voltageMode": voltage_mode})
        chargers.get(chargerKey).update({"instPower": inst_power})
    
    
    # PROVENIENTE DA GESTAO
    if(module == "management"):
        # Para
        print("Teste")
     
    
    # PROVENIENTE DA INTERFACE
    # ChargingMode:
    #    - 0 ou 1 -> Calcula Corrente
    #    - 2 -> Parou o carregamento - Reset as Variaveis
    if(module == "interface"):
        # Interface atualiza o modo de carregamento
        chargers.get(chargerKey).update({"chargingMode": charging_mode})
        
        if (charging_mode == 2):
            # reset as variaveis do carregador
            resetCharger(chargerKey)
            # EM FALTA: manda o carregador desligar
            # EM FALTA: manda o carregador desligar
            # EM FALTA: manda o carregador desligar
        
    
    #print("Hello from a function")


def updateMaxPowers():
    totalPower = 0
    
    # PARA VEICULOS JA LIGADOS ANTERIORMENTE:
    # Verifica se consome menos que o maximo atribuido e atualiza
    for key, dict in chargers.items():
        # Se a corrente instantanea e menor que a maxima
        if ( (chargers.get(key).get("instPower") < chargers.get(key).get("maxPower")) \
        and (chargers.get(key).get("newConnection") == 0) and (chargers.get(key).get("stateOcupation") == 1) ):
            # Atualizacao o novo valor da corrente maxima
            chargers.get(key).update({"maxPower": chargers.get(key).get("instPower")})
        
        # Calcula o total consumido
        totalPower = totalPower + chargers.get(key).get("instPower")
    
    
    availablePower = INSTALLED_POWER - totalPower
    chargersCount = countChargers()
    newChargersCount = countNewChargers()
    # Potencia a distribuir para os novos carregamentos normais: normalPower
    normalPower = 0
    # So se calcula caso haja carregamentos normais
    """
    OLD VERSION:
    if ( (chargersCount[3] + newChargersCount[3] ) > 0 ):
        normalPower = (availablePower - (chargersCount[1] + newChargersCount[1]) * fastDCPow  \
                       - (chargersCount[2] + newChargersCount[2]) * fastACPow ) \
                       / ( chargersCount[3] + newChargersCount[3] )
    """       
    
    # if ( (chargersCount[3] + newChargersCount[3] ) > 0 ):
    if ( newChargersCount[3] > 0 ):
        normalPower = (availablePower - (newChargersCount[1]) * fastDCPow  \
                       - (newChargersCount[2]) * fastACPow ) \
                       / (newChargersCount[3] )
                       
    # Garante-se que nao se ultrapassa a pMax normal
    if ( normalPower > normalMaxPow ):
        normalPower = normalMaxPow
    
    """
    print("Power:")   
    print(availablePower)       
    print(INSTALLED_POWER)   
    print(totalPower)   
    print(normalPower)
    """
    
    # PARA VEICULOS NOVOS LIGADOS:
    # Atribui potencia maxima aos rapidos e distribui pelos restantes
    for key, dict in chargers.items():
        # Atribui corrente maxima aos carregadores rapidos
        if ( (chargers.get(key).get("newConnection") == 1) and (chargers.get(key).get("chargingMode") == 1) ):
            # Atualizacao da nova corrente maxima DC
            if ( chargers.get(key).get("voltageMode") == 0 ):
                chargers.get(key).update({"maxPower": fastDCPow })
                # Atualizacao de "novo carregamento"
                chargers.get(key).update({"newConnection": 0 })
                # A partir deste momento estao ocupados
                chargers.get(key).update({"stateOcupation": 1 })
                
            # Atualizacao da nova corrente maxima AC
            elif ( chargers.get(key).get("voltageMode") == 1 ):
                chargers.get(key).update({"maxPower": fastACPow })
                # Atualizacao de "novo carregamento"
                chargers.get(key).update({"newConnection": 0 })
                # A partir deste momento estao ocupados
                chargers.get(key).update({"stateOcupation": 1 })
            
        
        # Atribui corrente maxima possivel aos carregadores normais
        elif ( (chargers.get(key).get("newConnection") == 1) and (chargers.get(key).get("chargingMode") == 0) ):
            # Atualizacao da nova corrente maxima
            chargers.get(key).update({"maxPower": normalPower })
            # Atualizacao de "novo carregamento"
            chargers.get(key).update({"newConnection": 0 })
            # A partir deste momento estao ocupados
            chargers.get(key).update({"stateOcupation": 1 })
    
  
def updateFastChargAvail():
    # Atualiza a flag que descreve a disponibilidade do carregamento rapido
    totalPower = 0
    for key, dict in chargers.items():
        totalPower = totalPower + chargers.get(key).get("instPower")
    
    # print(totalPower)
    # print(INSTALLED_POWER - 1.25 * fastDCPow)
    
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
  
  
def resetCharger(chargerKey):
  # Resets Charger Variables When is turned Off
  chargers.get(chargerKey).update({"stateOcupation": 0})
  chargers.get(chargerKey).update({"newConnection": 0})
  chargers.get(chargerKey).update({"chargingMode": 2})
  chargers.get(chargerKey).update({"instPower": 0})
  chargers.get(chargerKey).update({"maxPower": 0})
  

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
        if( int( dict["stateOcupation"] ) == 1 ):
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
        if( (int( dict["stateOcupation"] ) == 0) and (int( dict["newConnection"] ) == 1) ):
            countNewActive = countNewActive + 1
            
            if( (int( dict["chargingMode"] ) == 1) and (int( dict["voltageMode"] ) == 1) ):
                countNewFastAC = countNewFastAC + 1
                
            elif( (int( dict["chargingMode"] ) == 1) and (int( dict["voltageMode"] ) == 0) ):
                countNewFastDC = countNewFastDC + 1
    
    countNewNormal = countNewActive - countNewFastAC - countNewFastDC
                
    return countNewActive, countNewFastDC, countNewFastAC, countNewNormal

