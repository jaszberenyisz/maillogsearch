<?php
  if (isset($_POST["q"]))
  {
    $q=$_POST["q"];
    if (strlen($q)<=1) unset($q);
  }
  $out.='
<div id="control">
  <form action="?" method="post" enctype="multipart/form-data">
    <input type="text" name="q" id="q" placeholder="Keresés..." value="'.$q.'" />
    <input type="Submit" value="OK" />
  </form>
</div>
';
// Log reading and filtering
  $fn=$_SESSION["cfg"]["logdir"].$_SESSION["cfg"]["logfilename"];
  if (file_exists($fn))
  {
    $out.='<p>Log file: '.$fn."</p>\n";
    $f=fopen($fn,"r");
    if ($f)
    {
      $c=array();
      while (($line = fgets($f)) !== false)
      {
        if (isset($q))
        {
          if (strstr($line,$q)==true) $c[]=$line;
        }
        else $c[]=$line;
      }
      fclose($f);
      // Print lines;
      if (count($c)>0)
      {
        $out.='<div id="loglines">'."\n";
        for ($i=0;$i<count($c);$i++)
        {
          $out.='
  <div class="logline row">
    <div class="loglinecontent col"><div class="loglinenumber">'.(int)($i+1).'</div> '.$c[$i].'</div>
  </div><!-- class: logline -->
';
        }
        $out.="</div>\n";
      }
    }
    else $out.=' <p>Error reading file: '.$fn."</p>\n";
  }
  else $out.='<p>File does not exists: '.$fn.'</p>';
?>
