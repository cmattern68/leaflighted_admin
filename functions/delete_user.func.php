<?php

function getUserList()
{
    $objArr = array();
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM users_admin");
    $request->execute();
    $result = $request->fetchAll();
    foreach ($result as $key => $value)
        $objArr[] = new User($value['id']);
    $dbh = null;
    return $objArr;
}

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
