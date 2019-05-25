<?php

function deleteUser($id)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM users_admin WHERE id=:id");
    $request->execute(array(
        'id' => $id
    ));
    $result = $request->fetchAll();
    if (empty($result))
        echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=delete_user';</script>";
    $request = $dbh->prepare("DELETE FROM users_admin WHERE id=:id");
    $request->execute(array(
        ':id' => $id
    ));
    $dbh = NULL;
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=delete_user';</script>";
}
