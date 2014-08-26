#!/bin/bash
#
## change directory to the rrdtool script dir
#cd /tools/rrdtool/latency/
 
## Graph for last 24 hours 
/usr/bin/rrdtool graph /home/akos/pitemp/graphs/teszt.png \
-w 300 -h 120 -a PNG \
--slope-mode \
--start -86400 --end now \
--title "fokok" \
--vertical-label "°C" \
DEF:sen1=/home/akos/pitemp/graphs/tempmind.rrd:28-00042c641cff:AVERAGE \
DEF:sen2=/home/akos/pitemp/graphs/tempmind.rrd:28-00042c66a9ff:AVERAGE \
DEF:sen3=/home/akos/pitemp/graphs/tempmind.rrd:28-00042d40e2ff:AVERAGE \
LINE1:sen1#0000FF:"28-00042c641c" \
LINE2:sen2#00FF00:"28-00042c66a9" \
LINE3:sen3#FF0000:"28-00042d40e2"
