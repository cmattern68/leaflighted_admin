<?php

function getSections()
{
    $arr = array(
        "manage_usr" => "Manage Users",
        "manage_tok" => "Manage Tokens",
        "manage_rls" => "Manage Roles",
        "manage_logs" => "Consult Logs",
        "project_adm" => "Project Administration",
        "utilities" => "Utilities",
        "calendar" => "Calendar",
        "manage_atc" => "Manage Article",
        "manage_gms" => "Manage Games"
    );
    return $arr;
}

function createRoles()
{
    $errors = array();
    if (empty($_POST['label']))
        $errors[] = "Error: no label specified.";
    $actions = array();
    foreach ($_POST as $key => $value) {
        if (preg_match("/action-/i", Lib::Sanitize($key))) {
            if ($value != "on" && $value != "off") {
                $errors[] = "Error: unexpected value.";
                break;
            } else
                $actions[Lib::Sanitize($key)] = Lib::Sanitize($value);
        }
    }
    if (empty($actions))
        $errors[] = "Error: you must specified at least 1 authorisation.";
    if (isAlreadyExistant(Lib::Sanitize($_POST['label'])))
        $errors[] = "Error: roles ".Lib::Sanitize($_POST['label'])." already exist.";
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
    } else {
        $roles_uuid = uniqid();
        insertLabel($roles_uuid);
        inserRoles($actions, $roles_uuid);
        echo "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Success: new roles created.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>
        ";
    }
}

function insertLabel($uuid)
{
    $label = Lib::Sanitize($_POST['label']);
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('INSERT INTO roles(uuid, name) VALUES (:uuid, :name)');
    $request->execute(array(
        ':uuid' => $uuid,
        ':name' => $label
    ));
    $dbh = null;
}

function inserRoles($actions, $roles_uuid)
{
    $dbh = Lib::createSecureDataConnection();
    foreach ($actions as $key => $value) {
        if ($value == 'on') {
            $request = $dbh->prepare('INSERT INTO roles_right(uuid, roles_uuid, associate_right) VALUES (:uuid, :roles_uuid, :associate_right)');
            $request->execute(array(
                ':uuid' => uniqid(),
                ':roles_uuid' => $roles_uuid,
                ':associate_right' => $key
            ));
            $request->closeCursor();
        }
    }
    $dbh = null;
}

function isAlreadyExistant($label)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('SELECT name FROM roles WHERE name=:label');
    $request->execute(array(
        ':label' => $label
    ));
    $result = $request->fetchAll();
    $dbh = null;
    if (!empty($result))
        return true;
    return false;
}
