#!/usr/bin/perl
# index.cgi
# Display commands available for execution

BEGIN { push(@INC, ".."); };
use WebminCore;
&init_config();
%access = &get_module_acl();


&ReadParse();
&PrintHeader();
$ipx=$in{'ipx'};
$macx=$in{'macx'};
$ethx="ens19";
#print "dvdx : ".$macx;


$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
print "$cmdx <br>\n";
`$cmdx`;



$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
print "$cmdx <br>\n";
`$cmdx`;



$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
print "$cmdx <br>\n";
`$cmdx`;



$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
print "$cmdx <br>\n";
`$cmdx`;



$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
print "$cmdx <br>\n";
`$cmdx`;




$cmdx="iptables -t nat -A PREROUTING -i ".$ethx." -m mac --mac-source ".$macx."  -p tcp -m tcp --dport 80 -j RETURN";
print "$cmdx <br>\n";
`$cmdx`;


$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
print "$cmdx <br>\n";
`$cmdx`;

$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
print "$cmdx <br>\n";
`$cmdx`;
$cmdx="iptables -t nat -D PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
print "$cmdx <br>\n";
`$cmdx`;


$cmdx="iptables -t nat -A PREROUTING -i ".$ethx." -p tcp -m tcp --dport 80 -j REDIRECT --to-ports 80";
print "$cmdx <br>\n";
`$cmdx`;


$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx <br>\n";
`$cmdx`;

$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx \n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx \n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx \n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx \n";
`$cmdx`;
$cmdx="iptables -D FORWARD -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx \n";
`$cmdx`;


$cmdx="iptables -A FORWARD  -i ".$ethx." -m mac --mac-source ".$macx." -j ACCEPT";
print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -D FORWARD  -i ".$ethx."  -j DROP";
print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -D FORWARD  -i ".$ethx."  -j DROP";
print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -D FORWARD  -i ".$ethx."  -j DROP";
print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -D FORWARD  -i ".$ethx."  -j DROP";
print "$cmdx \n";
`$cmdx`;

$cmdx="iptables -A FORWARD  -i ".$ethx."  -j DROP";
print "$cmdx \n";
`$cmdx`;

