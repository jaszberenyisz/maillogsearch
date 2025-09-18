<?php
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

  require_once("php/loglines.php");
?>
