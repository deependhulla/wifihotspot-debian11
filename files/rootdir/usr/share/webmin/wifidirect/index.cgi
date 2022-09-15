#!/usr/bin/perl
# index.cgi
# Display commands available for execution
use DBI;
BEGIN { push(@INC, ".."); };
use WebminCore;
&init_config();
%access = &get_module_acl();
$maxdel=4;

&ReadParse();
&PrintHeader();
if($in{'macipx'}eq ""){$in{'macx'}="";}
$macxdirect=$in{'macx'};
$macipx=$in{'macipx'};
$activenow=$in{'activenow'};

$sipupdate=$in{'sipupdate'};
$wifiupdate=$in{'wifiupdate'};
$ethx="enp3s0";
#print "dvdx : ".$macx;

if($wifiupdate eq "yes")
{
$dbname="wifihotspot";
$hostname="localhost";
$username="mydbadmin";
$password='Geng0yoo';
$dbh=DBI->connect("dbi:mysql:$dbname:$hostname",$username,$password) or die("cannot connect to  database");


#### remove all mac first from iptables -start
$cmdx="iptables -L -n | grep MAC | sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' | cut -d \" \" -f 7 > /tmp/mac-list1.txt";
$cmdxx=`$cmdx`;

$cmdx="iptables -L -n -t nat | grep MAC | sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' | cut -d \" \" -f 7  >> /tmp/mac-list1.txt ; cat /tmp/mac-list1.txt | sort | uniq  > /tmp/mac-list2.txt   ";
$cmdxx=`$cmdx`;


open(OUTOAZ,"</tmp/mac-list2.txt");
while(<OUTOAZ>){
$macdel=$_;
$macdel=~ s/\n//eg;
$macdel=~ s/\r//eg;
$macdel=~ s/\t//eg;
#print "\n <br> $macdel";
$macx=$macdel;

for($e=0;$e<$maxdel;$e++)
{
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
#print "$cmdx <br>\n";
`$cmdx`;

$cmdx="iptables -t nat -D PREROUTING -i ".ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
#print "$cmdx <br>\n";
`$cmdx`;

}



}
close(OUTOAZ);
#### remove all mac first -done

$selquery="SELECT `user_mac_address` FROM `mac_user_info` WHERE `user_reg_active` =1 AND `user_mac_blocked` =0 AND `user_mobile_blocked` =0 and `full_access`=12";
#print " \n $selquery \n";
$sth=$dbh->prepare($selquery);
$sth->execute();
$fi=0;
while(@yarows=$sth->fetchrow_array()){
$macaddr=$yarows[0];
#print "\n<br> ".$macaddr;
#### Update Existing MAC -- start
$macx=$macaddr;
for($e=0;$e<$maxdel;$e++)
{
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
#print "$cmdx <br>\n";
`$cmdx`;
}
$cmdx="iptables -t nat -A PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -A FORWARD  -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
#print "$cmdx \n";
`$cmdx`;
## while over
}

for($e=0;$e<$maxdel;$e++)
{
$cmdx="iptables -D FORWARD  -i ".$ethx."  -j DROP";
#print "$cmdx \n";
`$cmdx`;
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
#print "$cmdx <br>\n";
`$cmdx`;
}
$cmdx="iptables -A FORWARD  -i ".$ethx."  -j DROP";
#print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -t nat -A PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
#print "$cmdx <br>\n";
`$cmdx`;


#### Update Existing MAC -- end


## mac while loop over
}
### wifi policy apply

######### SIP update start
if($sipupdate eq "yes")
{
$dbname="wifihotspot";
$hostname="localhost";
$username="mydbadmin";
$password="Geng0yoo";
$dbh=DBI->connect("dbi:mysql:$dbname:$hostname",$username,$password) or die("cannot connect to officedb database");

$selquery="SELECT `sipexten`,`sipextpassword`,`sipcallerid`,`uid` FROM `voip_sip_info` WHERE `sipactive` =1";
#print " \n $selquery \n";
$sth=$dbh->prepare($selquery);
$sth->execute();
$fi=0;
$datax="";
$extdatax="";
while(@yarows=$sth->fetchrow_array()){
#($a1,$a2)=split/\(/,$yarows[1];
$sipexten=$yarows[0];
$sipextpassword=$yarows[1];
$sipcallerid=$yarows[2];
$sipuid=$yarows[3];
$datax=$datax."\n\n";
$extdatax=$extdatax."\n\n";
$extdatax=$extdatax."exten => ".$sipexten.",1,Dial(SIP/".$sipexten.")\n";
$extdatax=$extdatax."exten => 0".$sipexten.",1,Dial(SIP/".$sipexten.")\n";
$extdatax=$extdatax."exten => 91".$sipexten.",1,Dial(SIP/".$sipexten.")\n";
$extdatax=$extdatax."exten => +91".$sipexten.",1,Dial(SIP/".$sipexten.")\n";


##$datax=$datax."###WIFISIPAUTO ".$sipuid." START\n\n";
$datax=$datax."[".$sipexten."]\n";
$datax=$datax."deny=0.0.0.0/0.0.0.0\n";
$datax=$datax."secret=".$sipextpassword."\n";
$datax=$datax."dtmfmode=rfc2833\n";
$datax=$datax."canreinvite=no\n";
$datax=$datax."context=from-internal\n";
$datax=$datax."host=dynamic\n";
$datax=$datax."type=friend\n";
$datax=$datax."nat=yes\n";
$datax=$datax."port=5060\n";
$datax=$datax."qualify=yes\n";
$datax=$datax."callgroup=\n";
$datax=$datax."pickupgroup=\n";
$datax=$datax."dial=SIP/".$sipexten."\n";
$datax=$datax."mailbox=".$sipexten."@device\n";
$datax=$datax."permit=0.0.0.0/0.0.0.0\n";
$datax=$datax."callerid=".$sipcallerid."\n";
$datax=$datax."callcounter=yes\n";
$datax=$datax."faxdetect=no\n";
$datax=$datax."###WIFISIPAUTO ".$sipuid." END\n\n";

}
$sipdata="";
open(OUTOAZ,"<sip.conf");
while(<OUTOAZ>){$sipdata=$sipdata.$_;}
close(OUTOAZ);
$sipdata=$sipdata.$datax;
open(OUTOAZA,">/etc/asterisk/sip.conf");
print OUTOAZA $sipdata;
close(OUTOAZA);


$extsipdata="";
open(OUTOAZ,"<extensions.conf");
while(<OUTOAZ>){$extsipdata=$extsipdata.$_;}
close(OUTOAZ);
$extsipdata=$extsipdata.$extdatax;
open(OUTOAZA,">/etc/asterisk/extensions.conf");
print OUTOAZA $extsipdata;
close(OUTOAZA);
$siprelaod=" /etc/rc.d/init.d/asterisk reload";
$cmdxz=`$siprelaod`;

}
###### sip done 

if($macxdirect ne "" && $ethx ne "")
{
$macx=$macxdirect;
$macdirect=$macxdirect;

$macdirect=~ s/://eg;


for($e=0;$e<$maxdel;$e++)
{
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -D FORWARD  -i ".$ethx."  -j DROP";
#print "$cmdx \n";
`$cmdx`;
$cmdx="/sbin/iptables -D INPUT -j M-".$macdirect." ;/sbin/iptables -D OUTPUT -j M-".$macdirect." ;/sbin/iptables -D FORWARD -j M-".$macdirect." ;/";
#print "$cmdx \n";
`$cmdx`;
}

#################################
#if($activenow==1)
#{
$cmdx="iptables -t nat -A PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -A FORWARD  -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
#print "$cmdx \n";
`$cmdx`;
$cmdx="/sbin/iptables -F M-".$macdirect." ;/sbin/iptables -N M-".$macdirect." ;/sbin/iptables -I INPUT -j M-".$macdirect." ;/sbin/iptables -I OUTPUT -j M-".$macdirect." ;/sbin/iptables -I FORWARD -j M-".$macdirect." ;/sbin/iptables  -I M-".$macdirect."  -s ".$macipx." -d   0.0.0.0/0;/sbin/iptables  -I M-".$macdirect."  -s  0.0.0.0/0  -d  ".$macipx." ";
#print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -t nat -A PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
#print "$cmdx <br>\n";
`$cmdx`;


#}
#################################


$cmdx="iptables -A FORWARD  -i ".$ethx."  -j DROP";
#print "$cmdx \n";
`$cmdx`;


if($activenow==0)
{

$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
#print "$cmdx <br>\n";
`$cmdx`;
$cmdx="/sbin/iptables -D INPUT -j M-".$macdirect." ;/sbin/iptables -D OUTPUT -j M-".$macdirect." ;/sbin/iptables -D FORWARD -j M-".$macdirect." ;/sbin/iptables  -D M-".$macdirect."  -s ".$macipx." -d   0.0.0.0/0;/sbin/iptables  -D M-".$macdirect."  -s  0.0.0.0/0  -d  ".$macipx." ; /sbin/iptables -F M-".$macdirect." ; /sbin/iptables -X M-".$macdirect." ; ";

#print "$cmdx \n";
`$cmdx`;


}


}

print "\nWorkDone.\n";
##############################
