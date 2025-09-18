<?php
  $out.='<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>'.$_SESSION["cfg"]["title"].'</title>
    <meta name="author" content="Jászberényi Szabolcs" />
    <meta name="copyright" content="Készítette: Jászberényi Szabolcs" />
    <meta name="robots" content="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="lib/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="system/style.css?'.filemtime("system/style.css").'" rel="stylesheet" type="text/css" />
    <script src="system/functions.js.php?PHPSESSID='.session_id().'" type="text/javascript"></script>
  </head>
  <body>
    <div id="content">
      '.$body.'
    </div>
    <div id="footer">mail.log search by Szabolcs Jászberényi</div>
    <script href="lib/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      var ajaxReload;
      ajax("'.$fn.'&amp;q='.$q.'",'.$reload.');
    </script>
  </body>
</html>
';
?>
