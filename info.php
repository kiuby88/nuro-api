<pre>
<?php

print "NURO CaseStudy (http://seaclouds-project.eu/) System Information (DO NOT DEPLOY ON PRODUCTION SERVERS!)\n\n";
print "_ENV:\n";
print_r( $_ENV);
print "_SERVER:\n";
print_r( $_SERVER);
phpinfo();
print "\n\nOS by uname:\n"
      . `uname -a` 
      . "\n";

print "OS by /etc/os-release:\n"
      . `cat /etc/os-release`
      . "\n";

print "OS by /etc/*version*:\n"
      . `ls -ld /etc/*version*` 
      . `cat /etc/*version*` 
      . "\n\n";

print "df:\n" . `df -h` . "\n\n";

print "RAM:\n" . `free -m` . "\n\n";

print "CPU:\n" . `cat /proc/cpuinfo` . "\n\n";

print "\ntop:\n" . `top -bn1` . "\n\n";
?>