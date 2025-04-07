<?php
$out.='
<div id="control">
  <form action="?" method="post" enctype="multipart/form-data">
    <input type="text" name="q" id="q" placeholder="Keresés..." value="'.$_POST["q"].'" />
    <input type="Submit" value="OK" />
  </form>
</div>
<div id="log">
  '.$log.'
</div>
';
?>
