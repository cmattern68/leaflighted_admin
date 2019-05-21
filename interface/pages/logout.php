<?php
if (preg_match("/page/i", $_SERVER['REQUEST_URI']) && !preg_match("/index.php/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=home';</script>";
if (isset($_SESSION['user_id']))
    unset($_SESSION['user_id']);
$user = null;
session_destroy();
echo "<script type=\"text/javascript\">window.location.href = '../index.php';</script>";
?>
