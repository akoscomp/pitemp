#!/bin/bash

/usr/bin/gpio write 0 1
/usr/bin/gpio write 1 1
/usr/bin/gpio write 2 1
/usr/bin/gpio write 3 1
/usr/bin/gpio write 4 1
/usr/bin/gpio write 5 1
/usr/bin/gpio write 6 1

/usr/bin/gpio mode 0 out
/usr/bin/gpio mode 1 out
/usr/bin/gpio mode 2 out
/usr/bin/gpio mode 3 out
/usr/bin/gpio mode 4 out
/usr/bin/gpio mode 5 out
/usr/bin/gpio mode 6 out

cp /home/akos/pitemp/data/* /ramdisk
