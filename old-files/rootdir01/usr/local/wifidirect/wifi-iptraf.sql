LOAD DATA LOCAL INFILE '/tmp/wifi_iptraf.log' INTO TABLE wifi_iptraf.ip_logs FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n'(day,month,date,hh,mm,ss,year,protocol,eth,num_bytes1,bytes1,froms,ip_from,port1,tos,ip_to,port2,f_packet,packets,num_pkt1,pkts1,num_bytes2,bytes2,
avg1,flow1,rate1,num_kbits1, kbits1,opposites,directions,num_pkt2,pkts2,num_bytes3,bytes3,avg2,flow2,rate2,num_kbits2,kbits2);
