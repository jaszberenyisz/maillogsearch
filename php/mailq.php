<?php
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
