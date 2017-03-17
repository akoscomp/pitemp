LOGDATE="date +%Y.%m.%d-%H:%M:%S"
LOGFILE="/home/akos/pitemp/server/pitemp.log"

sleep 5
#gyerek
/usr/bin/gpio write 5 0
sleep 60

#kazan
/usr/bin/gpio write 0 0
#sleep 1


echo "`${LOGDATE}` - Start gyerekek" >> $LOGFILE
