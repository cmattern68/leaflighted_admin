<?php

require_once("token.class.php");

function deleteToken($id)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM oauth_tok WHERE id=:id");
    $request->execute(array(
        'id' => $id
    ));
    $result = $request->fetchAll();
    if (empty($result))
        echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=delete_auth_token';</script>";
    $request = $dbh->prepare("DELETE FROM oauth_tok WHERE id=:id");
    $request->execute(array(
        ':id' => $id
    ));
    $dbh = NULL;
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=delete_auth_token';</script>";
}
