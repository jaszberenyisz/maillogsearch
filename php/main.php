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

  // AJAX reload?
  $reload="true";
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
<div id="control" class="row border-bottom">
  <div id="pname" class="col-xl-3 col-md-4 col-12 text-md-start text-center ps-lg-5 px-3"><h1><a href="?">'.$_SESSION["cfg"]["title"].'</a></h1></div>
  <div class="col pt-3 text-lg-start text-center">
    <form action="?" method="post" enctype="multipart/form-data">
      <input type="text" name="q" id="q" placeholder="'._search.'" value="'.$q.'" autofocus class="w-50 " />
      <select name="order" id="order">
        <option value="0"';
  if ($_SESSION["order"]=="0") $out.=' selected="selected"';
  $out.='>'._newest_on_top.'</option>
        <option value="1"';
  if ($_SESSION["order"]=="1") $out.=' selected="selected"';
  $out.='>'._oldest_on_top.'</option>
      </select>
      <input type="submit" value="'._OK.'" />
    </form>
';
  if (count($_SESSION["cfg"]["keywords"])>0)
  {
    $out.='    <div id="quicksearch">
      <span>'._quick_search.':</span>
';
    // Show maximum 10 keywords
    $maxkeywords=count($_SESSION["cfg"]["keywords"]);
    if ($maxkeywords>10) $maxkeywords=10;
    for ($i=0;$i<$maxkeywords;$i++)
    {
      $keyword=stripslashes($_SESSION["cfg"]["keywords"][$i]);
      $out.='<a href="?q='.$keyword.'" class="px-1">'.$keyword.'</a> ';
    }
  $out.='    </div><!-- id:quicksearch -->
';
  }
  $out.='    <div class="info">'.(int)$_SESSION["cfg"]["maxlines"].' '._lines_shown.'.</div>
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
