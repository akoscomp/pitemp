LOGDATE="date +%Y.%m.%d-%H:%M:%S"
LOGFILE="/home/akos/pitemp/server/pitemp.log"

#konyha
/usr/bin/gpio write 1 0
sleep 60

#kazan
/usr/bin/gpio write 0 0
#sleep 1

echo "`${LOGDATE}` - Start konyha" >> $LOGFILE
