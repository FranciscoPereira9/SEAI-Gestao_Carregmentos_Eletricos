# Unit Tested

# to run python stubSolarPower.py
# install matplotlib, numpy
import math
import matplotlib.pyplot as plt
import numpy as np
from datetime import datetime


# SMALL PRODUCTION UNITY
# According to Portuguese Law: < 250kW
INSTALLED_POWER = 100 * 1000 # NOMINAL
EFFICIENCY = 90 / 100


def gaussianFunc(x, alpha, r):
    return 1./(math.sqrt(alpha**math.pi))*np.exp(-alpha*np.power((x - r), 2.))
          

def plotProduction(x, y):    
    plt.plot(x, y, label = 'dailyProduction')
    plt.plot(x, np.ones(np.size(x))*22*1000, label = 'normalCharge')
    plt.plot(x, np.ones(np.size(x))*43*1000, label = 'fastChargeAC')
    plt.plot(x, np.ones(np.size(x))*50*1000, label = 'fastChargeDC')
    plt.legend(loc='upper left', shadow=True, fontsize='medium')
    plt.show()
    return 1
    
def actualProd():
    # Current Time
    dateTime = datetime.now()
    """
    # Printing attributes of datetime.now()
    print ("Hour : ", end = "")  
    print (dateTime.hour)      
    print ("Minute : ", end = "")  
    print (dateTime.minute)
    """
    
    xAxis = np.linspace(0, 24, 1000)
    yAxis = gaussianFunc(xAxis, 0.05, 13)
    yAxis = yAxis * ( INSTALLED_POWER * EFFICIENCY / max(yAxis) )

    hour = dateTime.hour + dateTime.minute / 60
    hour = 13
    hourRounded = int((hour/24) * 1000)

    powerProd = yAxis[hourRounded]
    
    # plotProduction(xAxis, yAxis)
    
    return powerProd


def main():
    
    print(actualProd())


    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING
    # COMUNICATION MISSING


if __name__ == '__main__':
    main()

