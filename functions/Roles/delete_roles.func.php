<?php

function deleteRole($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT name FROM roles WHERE uuid=:uuid");
    $request->execute(array(
        'uuid' => $uuid
    ));
    $result = $request->fetchAll();
    $dbh = null;
    if (empty($result))
        echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=delete_roles';</script>";
    deleteAssociateRight($uuid);
    deleteAssociateUsersRoles($uuid);
    deleteFinalRole($uuid);
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=delete_roles';</script>";
}

function deleteAssociateRight($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("DELETE FROM roles_right WHERE roles_uuid=:uuid");
    $request->execute(array(
        ":uuid" => $uuid
    ));
    $dbh = null;
}

function deleteAssociateUsersRoles($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("DELETE FROM users_roles WHERE roles_uuid=:uuid");
    $request->execute(array(
        ":uuid" => $uuid
    ));
    $dbh = null;
}

function deleteFinalRole($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("DELETE FROM roles WHERE uuid=:uuid");
    $request->execute(array(
        ":uuid" => $uuid
    ));
    $dbh = null;
}
