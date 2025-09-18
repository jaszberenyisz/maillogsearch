<?php
/*
  mail.log search
  by Szabolcs Jászberényi <info at jszabolcs dot hu>
  created in 2025

  mail.log search is a web based tool to make searching in mail.log files easier.
*/
  if (isset($_GET["muvelet"])) $muvelet=$_GET["muvelet"];
  elseif (isset($_POST["muvelet"])) $muvelet=$_POST["muvelet"];
  else $muvelet="";
  switch ($muvelet)
  {
// Automatikus frissítési időzítő bekapcsolása
    case "auto_refresh_on":
      $_SESSION["refresh"]=1;
      break;
// Automatikus frissítési időzítő kikapcsolása
    case "auto_refresh_off":
      $_SESSION["refresh"]=0;
      break;
// Default művelet ha hiba van
    default:
      break;
  }
?>
