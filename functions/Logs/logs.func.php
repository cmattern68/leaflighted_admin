<?php

require_once("logs.class.php");

function generateLogObjArray()
{
    $objArr = array();
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM log ORDER BY id DESC");
    $request->execute();
    $result = $request->fetchAll();
    if (empty($result)) {
            $dbh = null;
            return null;
    }
    foreach ($result as $key => $value) {
        $objArr[] = new Log(Lib::Sanitize($value['id']));
    }
    $dbh = null;
    return $objArr;
}

function flushLogs()
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("DELETE FROM log");
    $request->execute();
    $dbh = null;
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=logs';</script>";
}
