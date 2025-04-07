<?php
  // Log files directory
  // Default: /var/log/
  $_SESSION["cfg"]["logdir"]="/var/log/";
  
  // Default mail.log file name
  // Default: mail.log
  // you can specify more than one filename on the same location
  // Or leave the logdir parameter empty and use full path filenames instead
//  $_SESSION["cfg"]["logfilename"]="mail.log";
  $_SESSION["cfg"]["logfilename"]=array("mail.log.1","mail.log");

  // Maximum lines to show on the web interface
  // 0 means no limit
  // Be carefull with no limit as it can consume a huge amount of memory on the client side too!
  $_SESSION["cfg"]["maxlines"]="1000";

  // Language selection
  // Default: english (en)
  $_SESSION["cfg"]["language"]="en";
?>
