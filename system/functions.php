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
// Colorize output based on status for better user experience
// Text based files for storing statuses
// c = log line content
// Output: HTML formatted content
function make_colors($c)
{
  // Info status/messages
  $c=make_colors_readfile($c,"system/status/info.txt","msg_info");
  // Normal status/messages
  $c=make_colors_readfile($c,"system/status/normal.txt","msg_normal");
  // Warning status/messages
  $c=make_colors_readfile($c,"system/status/warning.txt","msg_warning");
  // Error status/messages
  $c=make_colors_readfile($c,"system/status/error.txt","msg_error");
  return $c;
}
// --------------------------------------------------------------------
// Add SPAN tags for colorizing
// c     = Content
// txt   = Text to find/replace
// class = CSS class name
// Output: HTML formatted content
function make_colors_addclass($c,$txt,$class)
{
  if (strpos($txt,"(.+)")>0)
  {
    $txt1=str_replace("(.+)","$1",$txt);
    $txt2="";
  }
  elseif (substr($txt,-1)==":")
  {
    $txt1=substr($txt,0,strlen($txt)-1);
    $txt2=":";
  }
  elseif (substr($txt,-2)==": ")
  {
    $txt1=substr($txt,0,strlen($txt)-2);
    $txt2=": ";
  }
  else
  {
    $txt1=$txt;
    $txt2="";
  }
  if (str_contains($txt,"\\")) $txt1=str_replace("\\","",$txt1);
  return preg_replace('/'.$txt.'/', '<span class="'.$class.'">'.$txt1.'</span>'.$txt2, $c);
}
// --------------------------------------------------------------------
// Sub function for make_colors
// Reads file line by line and calls make_colors_addclass() function with correct parameters
// Output: make_colors_addclass() output
function make_colors_readfile($c,$file,$class)
{
  global $fc;
  // Has file been used before?
  if (!isset($fc[$file])) $fc[$file]=file_get_contents($file);
  // Set content
  $filecontent=$fc[$file];
  $lines=explode("\n",$filecontent);
  for ($i=0;$i<count($lines);$i++)
  {
    $txt=$lines[$i];
    if ($txt) $c=make_colors_addclass($c,$txt,$class);
  }
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
  $c=preg_replace('/queued as ([A-Z0-9]{10})/', 'queued as <a href="?q=$1">$1</a>', $c);
  $c=preg_replace('/queued_as: ([A-Z0-9]{10}),/', 'queued_as: <a href="?q=$1">$1</a>,', $c);
  // forward as IDs
  $c=preg_replace('/forwarded as ([A-Z0-9]{10})/', 'forwarded as <a href="?q=$1">$1</a>', $c);
  // sender non-delivery notification
  $c=preg_replace('/ sender non-delivery notification: ([A-Z0-9]{10})/', ' sender non-delivery notification: <a href="?q=$1">$1</a>', $c);
  // E-mail addresses
  $c=preg_replace('/\&lt\;([^\&]*)/', '&lt;<a href="?q=$1">$1</a>', $c);
  return $c;
}
// --------------------------------------------------------------------
?>
