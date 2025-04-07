<?php
// --------------------------------------------------------------------
// Get contents of lofile with filtering
// fn = filename
// q = search query
// c = content from a previous search to expand with new file
// output: content of merged input content and filtered actual file content
function get_logfile($fn,$q,$c=array())
{
  global $out;
  if (file_exists($fn))
  {
// Debugging purposes...
//    $out.='<p>Log file: '.$fn."</p>\n";
    $f=fopen($fn,"r");
    if ($f)
    {
      while (($line = fgets($f)) !== false)
      {
        if (strlen(trim($q))>0)
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
// Replace mail IDs with query links for better user experience
// c = log line content
// Output: HTML formatted content
function make_links($c)
{
  // E-mail IDs
  $c=preg_replace('/]\: ([A-Z0-9]{10})\:/', ']: <a href="?q=$1">$1</a>: ', $c);
  // queue as IDs
  $c=preg_replace('/queued as (.*)\)/', 'queued as <a href="?q=$1">$1</a>)', $c);
  // forward as IDs
  $c=preg_replace('/forwarded as (.*)\)/', 'forwarded as <a href="?q=$1">$1</a>)', $c);
  // E-mail addresses
  $c=preg_replace('/\&lt\;([^\&]*)/', '&lt;<a href="?q=$1">$1</a>', $c);
  // Normal status
  $c=preg_replace('/Passed CLEAN/', '<span class="passed_clean">Passed CLEAN</span>', $c);
  $c=preg_replace('/250 2\.0\.0 Ok/', '<span class="message_250_ok">250 2.0.0 Ok</span>', $c);
  // Error status
  $c=preg_replace('/removed/', '<span class="removed">removed</span>', $c);
  $c=preg_replace('/authentication failed: /', '<span class="authentication_failed">authentication failed</span>: ', $c);
  return $c;
}
// --------------------------------------------------------------------
?>
