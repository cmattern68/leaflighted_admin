<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
if (!$current_user->asAuthorizationToAccess("Manage Article"))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
echo "add_article";
?>
