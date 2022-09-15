#!/usr/bin/perl


$cmdx=" /sbin/iptables  -nvxL | grep Chain | cut -d \" \" -f 2 | grep -v INPUT | grep -v FORWARD | grep -v OUTPUT";
#print "\n$cmdx \n";
$cmdxx=`$cmdx`;
#print "\n$cmdxx\n";
@maclist=();
@maclist=split/\n/,$cmdxx;

$cmdz="date >> /root/test.txt ; echo  \" START \" >> /root/test.txt";
#`$cmdz`;
for($e=0;$e<@maclist;$e++)
{
@zx=();
$macx="";
@zx=split//,$maclist[$e];
$c=0;
for($z=2;$z<@zx;$z++)
{
if($c==2){$macx=$macx.":";$c=0;}
$macx=$macx.$zx[$z];
$c++;
}
print "\n --> $e -->".$maclist[$e]." -->".$macx;
$cmdx="/usr/local/webadmin/wifidirect/get-data-usage-per-mac.pl ".$macx." &";
$cmdz="date >> /root/test.txt ; echo  \" ".$cmdx."\" >> /root/test.txt";
#`$cmdz`;

## use of system for running backround process for & linux command
system($cmdx);


}
print "\n";
