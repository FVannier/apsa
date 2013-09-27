<?php

session_start();
session_destroy();
echo '<script language="Javascript">var t=setTimeout("document.location.replace(\'index.php\')", 0)</script>';

?>
