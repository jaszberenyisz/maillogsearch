<?php
// Prints a logline
// ln = line number
// txt = text to print (aka logline)
// No output
function print_line($ln,$txt)
{
  global $out;
  // Some formating
  $txt=htmlspecialchars($txt);
  $txt=make_links($txt);
  $txt=make_colors($txt);
  // Print
  $out.='
  <div class="logline row">
    <div class="loglinecontent col"><div class="loglinenumber info">'.(int)$ln.'</div> '.$txt.'</div>
  </div><!-- class: logline -->
';
}

  // AJAX parameters
  $reload="true";
  $reload_f="loglines";
  $reload_id="loglines";
  // First filter
  $q="";
  if (isset($_POST["q"])) $q=$_POST["q"];
  elseif (isset($_GET["q"])) $q=$_GET["q"];
  if (strlen($q)<=1) $q="";
  // Order to permanent
  if (!isset($_SESSION["order"])) $_SESSION["order"]=0;
  if (isset($_POST["order"])) $_SESSION["order"]=$_POST["order"];

// Log reading and filtering
// Is there onyl one log file?
  if (!is_array($_SESSION["cfg"]["logfilename"]))
  {
    // Only one logfile
    $fn=$_SESSION["cfg"]["logdir"].$_SESSION["cfg"]["logfilename"];
    $c=get_logfile($fn,$q);
  }
  else
  {
    // Multiple logfiles
    $c=array();
    for ($i=0;$i<count($_SESSION["cfg"]["logfilename"]);$i++)
    {
      $fn=$_SESSION["cfg"]["logdir"].$_SESSION["cfg"]["logfilename"][$i];
      $c=get_logfile($fn,$q,$c);
    }
  }

  // Print lines
  if (count($c)>0)
  {
    $out.='<div id="loglines">'."\n";
    // Maximalize output lines
    $totallines=count($c);
    if (((int)$_SESSION["cfg"]["maxlines"]>0)and($totallines>(int)$_SESSION["cfg"]["maxlines"])) $maxlines=(int)$_SESSION["cfg"]["maxlines"];
    else $maxlines=$totallines;
    // Lets print them
    $ln=0;
    $all=$totallines-$maxlines;
    if ($all<=0) $all=1;
    if ($_SESSION["order"]=="0")
    {
      // Order by date: newest on top
      for ($i=($totallines-1);$i>=$all;$i--) { $ln++; print_line($ln,$c[$i]); }
    }
    else
    {
      // Order by date: oldest on top
      for ($i=($all-1);$i<$totallines;$i++) { $ln++; print_line($ln,$c[$i]); }
    }
    $out.="</div>\n";
  }
?>
