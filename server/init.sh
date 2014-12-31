#!/bin/bash

/usr/local/bin/gpio write 0 1
/usr/local/bin/gpio write 1 1
/usr/local/bin/gpio write 2 1
/usr/local/bin/gpio write 3 1
/usr/local/bin/gpio write 4 1
/usr/local/bin/gpio write 5 1
/usr/local/bin/gpio write 6 1

/usr/local/bin/gpio mode 0 out
/usr/local/bin/gpio mode 1 out
/usr/local/bin/gpio mode 2 out
/usr/local/bin/gpio mode 3 out
/usr/local/bin/gpio mode 4 out
/usr/local/bin/gpio mode 5 out
/usr/local/bin/gpio mode 6 out

