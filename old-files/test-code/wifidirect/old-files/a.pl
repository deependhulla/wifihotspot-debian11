$cmdx="iptables -L -n | grep MAC | sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' |  sed 's/  / /g' | cut -d \" \" -f 7";

@cx=();
$cmdxx=`$cmdx`;
@cx=split("\n",$cmdxx);

for($x=0;$x<@cx;$x++)
{
print "$x -->".$cx[$x]."<--";
}

