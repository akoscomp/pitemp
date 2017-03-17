LOGDATE="date +%Y.%m.%d-%H:%M:%S"
LOGFILE="/home/akos/pitemp/server/pitemp.log"

/usr/bin/gpio write 0 1  #kazen
#sleep 1
/usr/bin/gpio write 1 1
#sleep 1
/usr/bin/gpio write 2 1
#sleep 1
/usr/bin/gpio write 3 1
#sleep 1
/usr/bin/gpio write 4 1
#sleep 1
/usr/bin/gpio write 5 1 #gyerek
#sleep 1
/usr/bin/gpio write 6 1
sleep 3

echo "`${LOGDATE}` - Stop heat" >> $LOGFILE
