#!/bin/bash

NOW=$(date +"%Y-%m-%d - %T")
RETURN=0

if [ $2 == "OFF" ]; then
  if [ -a /mnt/1wire/3A.970413000000/PIO.B ]; then
    echo "$NOW - Switch sensor 1w $1 to $2" >> /home/akos/pitemp/log/pitemp.log
    /bin/echo "1" > /mnt/1wire/3A.970413000000/PIO.B
    sleep 25
    /bin/echo "0" > /mnt/1wire/3A.970413000000/PIO.B
#    RETURN=1
  fi
fi

if [ $2 == "ON" ]; then
  if [ -a /mnt/1wire/3A.970413000000/PIO.A ]; then
    echo "$NOW - Switch sensor 1w $1 to $2" >> /home/akos/pitemp/log/pitemp.log
    /bin/echo "1" > /mnt/1wire/3A.970413000000/PIO.A
    sleep 25
    /bin/echo "0" > /mnt/1wire/3A.970413000000/PIO.A
#    RETURN=1
  fi
fi

#echo $RETURN
