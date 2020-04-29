  机制1：
   1034  ifconfig
   1035  ifdown enp0s9 && ifup enp0s3
   1036  nc  -v 10.2.1.81 3306
   1037  ifconfig
   1038  ifdown enp0s3
   1039  ifup enp0s9
   1040  nc  -v 10.2.1.81 3306
   1041  ifconfig
   1042  ping baidu.com
   1043  nc  -v 10.2.1.81 3306
   1044  nc  -v 10.2.1.81 80
   1045  ping 10.2.1.81
   1046  cd /etc/
   1047  ifconfig
   1048  grep enp0s9 -r .
   1049  cd sysconfig/network-scripts/
   1050  cat ifcfg-enp0s9 
   1051  ifconfig
   1052  ping 10.88.49.1
   1053  netstat -rn
   1054  ping 10.88.48.1
   1055  ping 10.2.0.1
   1056  nc  -v 10.2.1.81 80
   1057  ifconfig
   1058  ifup enp0s3
   1059  ifdown enp0s9
   1060  ping baidu.com
   1061  nc  -v 10.2.1.81 80
   1062  ifdown enp0s3
   1063  ifup enp0s9
   1064  nc  -v 10.2.1.81 80
   1065  ifup enp0s9
   1066  nc  -v 10.2.1.81 80
   1067  ifdown enp0s9
   1068  ifup enp0s3
   1069  ifdown enp0s3
   1070  ifup enp0s9
   1071  nc  -v 10.2.1.81 80
   1072  nc  -v 10.2.1.81 3306
   1073  ifconfig
   1074  history 
  
  
  机制2：
  
  10:21:32.505173 IP6 fe80::e91c:4316:7448:1ac7.mdns > ff02::fb.mdns: 0 A (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.505225 IP 10.88.55.250.mdns > 224.0.0.251.mdns: 0 AAAA (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.505984 IP6 fe80::e91c:4316:7448:1ac7.mdns > ff02::fb.mdns: 0 AAAA (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.506028 IP 10.88.55.250.mdns > 224.0.0.251.mdns: 0 A (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.506634 IP6 fe80::e91c:4316:7448:1ac7.mdns > ff02::fb.mdns: 0 A (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.507023 IP 10.88.55.250.mdns > 224.0.0.251.mdns: 0 AAAA (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.507985 IP6 fe80::e91c:4316:7448:1ac7.mdns > ff02::fb.mdns: 0 AAAA (QM)? win-pfuf0fsmepi.local. (39)
  10:21:32.712209 IP 0.0.0.0.bootpc > 255.255.255.255.bootps: BOOTP/DHCP, Request from 08:00:27:51:b8:c3, length 300
  10:21:32.714594 IP 10.88.48.1.bootps > 10.88.49.51.bootpc: BOOTP/DHCP, Reply, length 305
  10:21:33.006875 IP 10.88.55.250.netbios-ns > 10.88.55.255.netbios-ns: NBT UDP PACKET(137): QUERY; REQUEST; BROADCAST
  10:21:33.122442 IP 10.88.48.32.55890 > 239.255.255.250.ssdp: UDP, length 174
  10:21:33.454768 IP 10.88.48.19.52470 > 239.255.255.250.ssdp: UDP, length 174
  10:21:33.645204 IP 10.88.48.56.netbios-ns > 10.88.55.255.netbios-ns: NBT UDP PACKET(137): QUERY; REQUEST; BROADCAST
  10:21:33.646091 IP6 fe80::18eb:4cf6:23cf:8616.51475 > ff02::1:3.hostmon: UDP, length 22
  10:21:33.646761 IP 10.88.48.56.51475 > 224.0.0.252.hostmon: UDP, length 22
  10:21:33.647428 IP 10.88.48.56.52844 > 224.0.0.252.hostmon: UDP, length 22
  10:21:33.647474 IP6 fe80::18eb:4cf6:23cf:8616.52844 > ff02::1:3.hostmon: UDP, length 22
  ^C
  48 packets captured
  48 packets received by filter
~~~~
~~~~  
  996  tcpdump
  997  yum -i tcpdump
  998  yum install tcpdump
  999  tcpdump
 1000  tcpdump -i enp0s3 -n
 1001  tcpdump -i enp0s9 -n
 1002  tcpdump -i enp0s9 -n port 80
 1003  tcpdump -i enp0s9 -n
 1004  tcpdump -i enp0s9 -n tcp
 1005  ps auxwww|grep dhc
 1006  ifdown enp0s3
 1007  ps auxwww|grep dhc
 1008  kill 1990
 1009  ifdown enp0s9
 1010  ps auxwww|grep dhc
 1011  ifup enp0s9
 1012  ps auxwww|grep dhc
 1013  ifdown enp0s9
 1014  cd enp0s3
 1015  cd /var/lib/NetworkManager/
 1016  ks 0k
 1017  ls -l
 1018  mv *enp0s9* bak
 1019  ls -l
 1020  ls *enp0s9* 
 1021  rm *enp0s9* 
 1022  ps auxwww|grep dhc
 1023  ifup enp0s9
 1024  ps auxwww|grep dhc
 1025  ifconfig
 1026  ls -l
 1027  vim dhclient-93d13955-e9e2-a6bd-df73-12e3c747f122-enp0s9.lease 
 1028  ifdown enp0s9
 1029  tcpdump -i enp0s9 -n udp
 1030  tcpdump -i enp0s9 -n dhcp
 1031  tcpdump -i enp0s9 -d dhcp
 1032  tcpdump -i enp0s9 -n dhcp
 1033  man tcpdump
 1034  history 