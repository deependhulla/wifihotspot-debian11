#!/bin/sh
sysctl -w net.ipv6.conf.default.disable_ipv6=1 1>/dev/null
sysctl -w net.ipv6.conf.all.disable_ipv6=1 1>/dev/null
echo 1 > /proc/sys/net/ipv4/ip_forward

iptables -F
iptables -F -t nat
iptables -F -t mangle

#iptables -N UDPLIMIT
#iptables -F UDPLIMIT
# Only accept 300/second, ignore the rest
#iptables -A UDPLIMIT --match hashlimit --hashlimit-upto 300/second --hashlimit-mode srcip --hashlimit-name udp_rate_limit -j ACCEPT 
## Log the attacker (optional)
## iptables -A UDPLIMIT --match limit --limit 5/min -j LOG --log-prefix "UDP Flood DROP: " 
# Drop anything over 300 pps
#iptables -A UDPLIMIT -j DROP 

#https://www.cyberciti.biz/faq/iptables-connection-limits-howto/
#iptables -A INPUT -p tcp --syn --dport 80 -m connlimit --connlimit-above 100 -j REJECT --reject-with tcp-reset
#iptables -t nat -A POSTROUTING -p udp -m udp --dport 53 -j MASQUERADE 
#iptables -t nat -A POSTROUTING -p tcp -m tcp --dport 53 -j MASQUERADE 

iptables -A INPUT  -p udp -m udp --dport 53 -j ACCEPT
iptables -A INPUT  -p udp -m udp --dport 445 -j DROP
iptables -A INPUT  -p udp -m udp --dport 130:150 -j DROP
iptables -A FORWARD  -p udp -m udp --dport 445 -j DROP
iptables -A FORWARD  -p udp -m udp --dport 130:150 -j DROP

iptables -t nat -A POSTROUTING -s 172.16.0.0/16 -j MASQUERADE
#iptables -t nat -A PREROUTING -i ens19 -d 111.125.234.24  -p tcp -m tcp --dport 80 -j RETURN
iptables -t nat -A PREROUTING -i enp3s0 -d 172.16.0.254  -p tcp -m tcp --dport 80 -j RETURN
#iptables -t nat -A PREROUTING -i ens19 -d 192.168.223.254  -p tcp -m tcp --dport 80 -j RETURN

#iptables -t nat -A PREROUTING -d 111.125.234.24 -p tcp -m tcp --dport 80 -j DNAT --to-destination 192.168.3.254
#iptables -A FORWARD  -i eth3 -m mac --mac-source 94:0c:6d:cd:87:fc -j ACCEPT
#iptables -A FORWARD  -i eth3 -m mac --mac-source 80:D2:1D:47:65:A0 -j ACCEPT
#iptables -A FORWARD  -i eth3 -m mac --mac-source 80:D2:1D:48:36:DD -j ACCEPT
#iptables -A FORWARD  -i eth3 -d 111.125.234.24 -j ACCEPT
#iptables -A FORWARD  -i eth3 -d 192.168.3.254 -j ACCEPT
#

#echo wifihotspot is getting register mac  with full access ON..like Printer.
echo WifihotSpot startup...
#service iptables restart
/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' "https://127.0.0.1:8383/wifidirect/index.cgi?wifiupdate=yes" >/tmp/a

