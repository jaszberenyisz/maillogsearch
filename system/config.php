<?php
  // Title of screen and logo text
  // Default: mail.log search
  $_SESSION["cfg"]["title"]="mail.log search";

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
  $_SESSION["cfg"]["maxlines"]="5000";

  // Automatic refresh enable
  // 1 = enabled
  // 0 = disabled ( you can enable it manually)
  $_SESSION["cfg"]["refresh_enable"]="0";

  // Automatic refresh interval
  // In seconds
  // Minimum value 1
  $_SESSION["cfg"]["refresh_interval"]="3";

  // Language selection
  // Default: english (en)
  $_SESSION["cfg"]["language"]="en";
?>
