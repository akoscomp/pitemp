#!/usr/bin/env python
# -*- coding: utf-8 -*-
# 1-15-ig parameterrel lehet megadni, hogy az 1, 2, 3, 4 rele zarodjon, binaris ertekekkel: 1 2 4 8
# sudo i2cdetect -y 1 -megadja, hogy milyen porton van az i2c

import smbus
import time
import sys
bus = smbus.SMBus(1)
address = 0x58

if len(sys.argv) < 2:
    port = 8
else:
    port = int(sys.argv[1])

print "Starting relay"
bus.write_byte_data(address, 0x10, port)
time.sleep(1)
bus.write_byte_data(address, 0x10, 0x00)
time.sleep(1)
print "Relay stopped"
