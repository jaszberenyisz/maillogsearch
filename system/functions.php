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
  $c=preg_replace('/queued as ([A-Z0-9]{10})/', 'queued as <a href="?q=$1">$1</a>', $c);
  $c=preg_replace('/queued_as: ([A-Z0-9]{10}),/', 'queued_as: <a href="?q=$1">$1</a>,', $c);
  // forward as IDs
  $c=preg_replace('/forwarded as ([A-Z0-9]{10})/', 'forwarded as <a href="?q=$1">$1</a>', $c);
  // E-mail addresses
  $c=preg_replace('/\&lt\;([^\&]*)/', '&lt;<a href="?q=$1">$1</a>', $c);
  // Normal status/messages
  $c=preg_replace('/Passed CLEAN/', '<span class="msg_normal">Passed CLEAN</span>', $c);
  $c=preg_replace('/250 2\.0\.0 Ok/', '<span class="msg_normal">250 2.0.0 Ok</span>', $c);
  // Warning status/messages
  $c=preg_replace('/warning:/', '<span class="msg_warning">warning</span>:', $c);
  $c=preg_replace('/_WARN:/', '<span class="msg_warning">_WARN</span>:', $c);
  // Error status/messages
  $c=preg_replace('/authentication failed: /', '<span class="msg_error">authentication failed</span>: ', $c);
  $c=preg_replace('/lost connection after /', '<span class="msg_error">lost connection</span> after ', $c);
  $c=preg_replace('/removed/', '<span class="msg_error">removed</span>', $c);
  $c=preg_replace('/SSL_accept error from /', '<span class="msg_error">SSL_accept error</span> from ', $c);
  $c=preg_replace('/unknown user: /', '<span class="msg_error">unknown user</span>: ', $c);
  $c=preg_replace('/failed: Permission denied/', '<span class="msg_error">failed: Permission denied</span>', $c);
  $c=preg_replace('/ URIBL_BLOCKED /', ' <span class="msg_error">URIBL_BLOCKED</span> ', $c);
  $c=preg_replace('/temporarily deferred/', '<span class="msg_error">temporarily deferred</span>', $c);
  $c=preg_replace('/key retrieval failed/', '<span class="msg_error"> key retrieval failed</span>', $c);
  return $c;
}
// --------------------------------------------------------------------
?>
