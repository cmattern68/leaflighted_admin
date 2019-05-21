<?php
if (preg_match("/page/i", $_SERVER['REQUEST_URI']) && !preg_match("/index.php/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=home';</script>";
echo "add_game";
?>
