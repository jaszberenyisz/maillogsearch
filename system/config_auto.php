<?php
  // This is an automatic config file
  // !!! DO NOT EDIT !!!

  // Automatic refresh enable/disbale based on timer value
  if (!isset($_SESSION["refresh"]))
  {
    if ($_SESSION["cfg"]["refresh_enable"]==1) $_SESSION["refresh"]=1;
    else $_SESSION["refresh"]=0;
  }
  // Automatic refresh interval must be minimum 1
  if ($_SESSION["cfg"]["refresh_interval"]<=1) $_SESSION["cfg"]["refresh_interval"]=1;

  // Custom keywords
  // Reads keywords.txt file
  // Every new line is a new keyword
  // If a line starts with # it will be skipped
  $_SESSION["cfg"]["keywords"]=array();
  $fn="system/keywords.txt";
  if (file_exists($fn))
  {
    $filecontent=file_get_contents($fn);
    $lines=explode("\n",$filecontent);
    for ($i=0;$i<count($lines);$i++)
    {
      $val=trim($lines[$i]);
      // Skip empty lines
      if ($val!="")
      {
        // Skip comment lines
        if (substr($val,0,1)!="#")
        {
          $_SESSION["cfg"]["keywords"][]=$val;
        }
      }
    }
  }
?>
