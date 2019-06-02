<?php

function editRoles()
{
    unset($_POST['submit']);
    fillPost();
    doAction();
}

function fillPost()
{
    $uuid = "";
    $str = "";
    foreach ($_POST as $key => $value) {
    $key = Lib::Sanitize($key);
    $arr = explode("-", $key);
    $uuid = $arr[0]."-".$arr[1]."-";
    break;
    }
    $sections = Lib::getSections();
    foreach ($sections as $section) {
        $str = $uuid.$section;
        $str = str_replace(" ", "_", $str);
        if (!isset($_POST[$str]))
            $_POST[$str] = "off";
    }
}

function doAction()
{
    foreach ($_POST as $key => $value) {
        $key = Lib::Sanitize($key);
        $arr = explode("-", $key);
        if ($arr[0] == "action") {
            $rolesUuid = $arr[1];
            $section = $arr[2];
            if (isAlreadyInsert($rolesUuid, $section) && $value == "off")
                deleteRight($rolesUuid, $section);
            else if (!isAlreadyInsert($rolesUuid, $section) && $value == "on")
                insertRight($rolesUuid, $section);
        }
    }
}

function isAlreadyInsert($rolesUuid, $section)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('SELECT id FROM roles_right WHERE roles_uuid=:uuid AND associate_right=:section');
    $request->execute(array(
        ':uuid' => $rolesUuid,
        ':section' => "action-".$section
    ));
    $result = $request->fetch();
    $dbh = null;
    if (!empty($result))
        return true;
    else
        return false;
}

function deleteRight($rolesUuid, $section)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('DELETE FROM roles_right WHERE roles_uuid=:uuid AND associate_right=:section');
    $request->execute(array(
        ':uuid' => $rolesUuid,
        ':section' => "action-".$section
    ));
    $dbh = null;
}

function insertRight($rolesUuid, $section)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('INSERT INTO roles_right(uuid, roles_uuid, associate_right) VALUES (:uuid, :roles_uuid, :associate_right)');
    $request->execute(array(
        ':uuid' => uniqid(),
        ':roles_uuid' => $rolesUuid,
        ':associate_right' => "action-".$section
    ));
    $dbh = null;
}
