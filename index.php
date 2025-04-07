<?php
/*
  mail.log search
  by SZabolcs Jászberényi
  created in 2025

  mail.log search is a web based tool to make searching in mail.log files easier.
*/
  (require_once("system/config.php")) || die("No configuration (system/config.php) present!");
  (require_once("system/functions.php")) || die("Missing required system files (system/functions.php)!");
  (require_once("system/action.php")) || die("Missing required system files (system/action.php)!");
  $a="main";
  $fn=$a.".php";
  $out="";
  if (file_exists("php/".$fn))
  {
    require_once("php/".$fn);
    $body=$out;
  }
  else die("Missing required system files (php/".$fn.")!");
  $out="";
  (require_once("system/style.php")) || die("Missing required system files (system/style.php)!");
  print($out);
?>
