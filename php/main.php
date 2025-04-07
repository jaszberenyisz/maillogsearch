<?php
  $q="";
  if (isset($_POST["q"])) $q=$_POST["q"];
  elseif (isset($_GET["q"])) $q=$_GET["q"];
  if (strlen($q)<=1) $q="";
  $out.='
<div id="control">
  <form action="?" method="post" enctype="multipart/form-data">
    <input type="text" name="q" id="q" placeholder="Keresés..." value="'.$q.'" />
    <input type="Submit" value="OK" />
  </form>
</div>
';
// Log reading and filtering
  if (!is_array($_SESSION["cfg"]["logfilename"]))
  {
    $fn=$_SESSION["cfg"]["logdir"].$_SESSION["cfg"]["logfilename"];
    $c=get_logfile($fn,$q);
  }
  else
  {
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
    $maxlines=count($c);
    if (((int)$_SESSION["cfg"]["maxlines"]>0)and($maxlines>(int)$_SESSION["cfg"]["maxlines"])) $maxlines=(int)$_SESSION["cfg"]["maxlines"];
    for ($i=0;$i<$maxlines;$i++)
    {
      $ctxt=$c[$i];
      $ctxt=htmlspecialchars($ctxt);
      $ctxt=make_links($ctxt);
      $out.='
  <div class="logline row">
    <div class="loglinecontent col"><div class="loglinenumber">'.(int)($i+1).'</div> '.$ctxt.'</div>
  </div><!-- class: logline -->
';
    }
    $out.="</div>\n";
  }
?>
