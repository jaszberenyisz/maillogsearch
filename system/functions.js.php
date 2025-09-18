<?php
  if (session_id()=="") session_start();
?>
function ajax(x,reload=false,clear=false)
{
  if ((reload==false)||(clear==true)) { clearTimeout(ajaxReload); }
  var xhttp = newxhttp();
  xhttp.open("GET","ajax.php?f="+x+"&amp;PHPSESSID=<?=session_id(); ?>",true);
  xhttp.onreadystatechange = function() {
    if (this.readyState==4 && this.status==200)
    {
      var e = document.getElementById("content");
      e.innerHTML = this.responseText;
      if (reload==true) { ajaxReload=setTimeout("ajax('"+x+"',"+reload+");",<?=(int)($_SESSION["cfg"]["refresh"]*1000); ?>); }
    }
  }
  xhttp.send(null);
}
function newxhttp()
{
  if (window.XMLHttpRequest) xhttp = new XMLHttpRequest();
  else if (window.ActiveXObject) xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  return xhttp;
}
