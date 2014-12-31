#!/bin/bash

echo "Switch sensor $1" >> /home/akos/pitemp/log/pitemp.log
/usr/local/bin/gpio write $1 0
sleep 1
/usr/local/bin/gpio write $1 1

