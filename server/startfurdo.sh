LOGDATE="date +%Y.%m.%d-%H:%M:%S"
LOGFILE="/home/akos/pitemp/server/pitemp.log"

#furdo
/usr/bin/gpio write 6 0
sleep 60

#kazan
/usr/bin/gpio write 0 0
#sleep 1

echo "`${LOGDATE}` - Start furdo" >> $LOGFILE
