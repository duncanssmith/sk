<?php

require "Mailer.php";

date_default_timezone_set('GMT');
$now=date("Y-m-d H:i:s");

$m=new Mailer('duncanssmith@gmail.com','duncanssmith@gmail.com','test subject - '.$now, 'test body - '.$now);
#$m=new Mailer('','duncans.mac@local.mac','test subject - '.$now, 'test body - '.$now);

print "Mailtest:[".$m->getMailDetails()."]\n";

print $m->sendMailNow("mailtest");

#mail("duncanssmith@gmail.com","Hello from Duncans mac-mail", "test");

echo Mailer::hello();

?>
