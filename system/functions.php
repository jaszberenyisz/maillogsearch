<?php
// --------------------------------------------------------------------
// Get contents of lofile with filtering
function get_logfile($fn,$q)
{
  global $out;
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
    }
    else $out.=' <p>Error reading file: '.$fn."</p>\n";
  }
  else $out.='<p>File does not exists: '.$fn.'</p>';
  return $c;
}
// --------------------------------------------------------------------
?>
