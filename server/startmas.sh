LOGDATE="date +%Y.%m.%d-%H:%M:%S"
LOGFILE="/home/akos/pitemp/server/pitemp.log"

sleep 5

#konyha
/usr/bin/gpio write 1 0
#sleep 1

#nappali
/usr/bin/gpio write 2 0
#sleep 1

#halo
/usr/bin/gpio write 3 0
#sleep 1

#furdo
/usr/bin/gpio write 6 0

sleep 60
#kazan
/usr/bin/gpio write 0 0
#sleep 1


echo "`${LOGDATE}` - Start mas" >> $LOGFILE
