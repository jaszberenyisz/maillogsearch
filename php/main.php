<?php
  if (isset($_POST["q"]))
  {
    $q=$_POST["q"];
    if (strlen($q)<=1) unset($q);
  }
  else $q="";
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
    for ($i=0;$i<count($c);$i++)
    {
      $ctxt=htmlspecialchars(make_links($c[$i]));
      $out.='
  <div class="logline row">
    <div class="loglinecontent col"><div class="loglinenumber">'.(int)($i+1).'</div> '.$ctxt.'</div>
  </div><!-- class: logline -->
';
    }
    $out.="</div>\n";
  }
?>
