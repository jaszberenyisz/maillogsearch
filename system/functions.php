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
  $c=preg_replace('/]\: ([A-Z0-9]{10})\:/', ']: <a href="?q=$1">$1</a>: ', $c);
  $c=preg_replace('/queued as (.*)\)/', 'queued as <a href="?q=$1">$1</a>)', $c);
  $c=preg_replace('/forwarded as (.*)\)/', 'forwarded as <a href="?q=$1">$1</a>)', $c);
  $c=preg_replace('/to=\&lt\;([^\&]*)/', 'to=&lt;<a href="?q=$1">$1</a>', $c);
  $c=preg_replace('/from=\&lt\;([^\&]*)/', 'from=&lt;<a href="?q=$1">$1</a>', $c);
  $c=preg_replace('/removed/', '<span class="removed">removed</span>', $c);
  $c=preg_replace('/authentication failed: /', '<span class="authentication_failed">authentication failed</span>: ', $c);
  return $c;
}
// --------------------------------------------------------------------
?>
