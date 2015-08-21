#!/bin/bash

NOW=$(date +"%Y-%m-%d - %T")

echo "$NOW - Switch sensor $1 to $2" >> /home/akos/pitemp/log/pitemp.log
/usr/local/bin/gpio write $1 0
sleep 1
/usr/local/bin/gpio write $1 1

