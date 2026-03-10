<?php
/*
  You can dump the output of mailq to a file with a shell script.

  For example:
  mailq > /var/log/mailq.log

  You can create a cron job running this short command (like every minute or so) and get the output of mailq on this program to show.
  This tool allows you to view your mail queue remotely with a simple browser.
  Be aware, that exposing it to the public internet is not a good idea! Always use VPN, or strong authenticated access to access this page!
*/

function print_line($txt)
{
  global $out;
  // Some formating
  $txt=htmlspecialchars($txt);
  $txt=make_links($txt);
  $txt=make_colors($txt);
  // Print
  if (trim($txt)=="") $txt="&nbsp;";
  $out.='
  <div class="logline row">
    <div class="loglinecontent col">'.$txt.'</div>
  </div><!-- class: logline -->
';
}

  $fn=$_SESSION["cfg"]["logdir"]."mailq.log";
  $c=get_logfile($fn,"");
  $out.='<div id="loglines" class="mailq">'."\n";
  for ($i=0;$i<count($c);$i++)
  {
    $txt=$c[$i];
    print_line($txt);
  }
  $out.="</div><!-- id:loglines -->\n";
?>
