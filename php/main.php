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
  // Print
  $out.='
  <div class="logline row">
    <div class="loglinecontent col"><div class="loglinenumber info">'.(int)$ln.'</div> '.$txt.'</div>
  </div><!-- class: logline -->
';
}

  // First filter
  $q="";
  if (isset($_POST["q"])) $q=$_POST["q"];
  elseif (isset($_GET["q"])) $q=$_GET["q"];
  if (strlen($q)<=1) $q="";
  // Order to permanent
  if (!isset($_SESSION["order"])) $_SESSION["order"]=0;
  if (isset($_POST["order"])) $_SESSION["order"]=$_POST["order"];
  // Search form
  $out.='
<div id="control" class="row w-50">
  <div id="pname" class="col-lg-4 col-6"><h1>'.$_SESSION["cfg"]["title"].'</h1></div>
  <div class="col pt-3">
    <div class="row">
      <div class="col-8">
        <form action="?" method="post" enctype="multipart/form-data">
          <input type="text" name="q" id="q" placeholder="'._search.'" value="'.$q.'" autofocus />
          <select name="order" id="order">
            <option value="0"';
  if ($_SESSION["order"]=="0") $out.=' selected="selected"';
  $out.='>'._newest_on_top.'</option>
            <option value="1"';
  if ($_SESSION["order"]=="1") $out.=' selected="selected"';
  $out.='>'._oldest_on_top.'</option>
          </select>
          <input type="Submit" value="'._OK.'" />
        </form>
      </div><!-- class:col -->
      <div class="col pt-1 info">
        '.(int)$_SESSION["cfg"]["maxlines"].' '._lines_shown.'.
      </div><!-- class:col -->
    </div><!-- class:row -->
  </div><!-- class:col -->
</div><!-- class:row -->
';
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

  // Print lines;
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
