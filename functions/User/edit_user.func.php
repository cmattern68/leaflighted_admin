<?php

function changeUserRank()
{
    $errors = array();
    foreach ($_POST['roles'] as $role) {
        $role = Lib::Sanitize($role);
        $arr = explode("-", $role);
        $user_uuid = $arr[0];
        $roles_uuid = $arr[1];
        if (!valideUserUuid($user_uuid))
            $errors[] = "Error: no user for uuid ".$user_uuid.".";
        if (!valideRolesUuid($roles_uuid))
            $errors[] = "Error: no user for uuid ".$user_uuid.".";
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "
                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                ".$error."
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                </button>
                </div>
                ";
            }
        } else
            insertUserRoles($user_uuid, $roles_uuid);
    }
}

function valideUserUuid($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('SELECT name FROM users_admin WHERE uuid=:uuid');
    $request->execute(array(
        ':uuid' => $uuid
    ));
    $result = $request->fetchAll();
    $dbh = null;
    if (empty($result))
        return false;
    else
        return true;
}

function valideRolesUuid($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('SELECT name FROM roles WHERE uuid=:uuid');
    $request->execute(array(
        ':uuid' => $uuid
    ));
    $result = $request->fetchAll();
    $dbh = null;
    if (empty($result))
        return false;
    else
        return true;
}

function insertUserRoles($user_uuid, $roles_uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('INSERT INTO users_roles(uuid, user_uuid, roles_uuid) VALUES(:uuid, :user_uuid, :roles_uuid)');
    $request->execute(array(
        ':uuid' => uniqid(),
        ':user_uuid' => $user_uuid,
        ':roles_uuid' => $roles_uuid,
    ));
    $dbh = null;
}
