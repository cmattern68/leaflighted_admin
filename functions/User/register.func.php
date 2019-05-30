<?php

function initRegisterProcedure() {
    $name = Lib::Sanitize($_POST['name']);
    $lastname = Lib::Sanitize($_POST['lastname']);
    $email = Lib::Sanitize($_POST['email']);
    $password = Lib::Sanitize($_POST['password']);
    $repeatpassword = Lib::Sanitize($_POST['repeatpassword']);
    $errors = array();

    if (empty($name))
        $errors[] = "Error: no name completed.";
    if (empty($lastname))
        $errors[] = "Error: no last name completed.";
    if (empty($email))
        $errors[] = "Error: no email completed.";
    if (empty($password))
        $errors[] = "Error: no password completed.";
    if (empty($repeatpassword))
        $errors[] = "Error: no repeat password completed.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Error: email is not valid";
    if ($password !== $repeatpassword)
        $errors[] = "Error: password and repeat password does not match.";
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
        Lib::Log($email, FALSE, "New register attempts.", "info");
    } else
        startRegisteringProcedure($name, $lastname, $email, $password);
}

function startRegisteringProcedure($name, $lastname, $email, $password)
{
    $login = strtoupper($name[0]).strtoupper($lastname[0]).strtoupper($lastname[strlen($lastname) - 1]);
    $errors = array();
    if (alreadyRegistered($email))
        $errors[] = "Error: an account is already created for this account.";
    $password = encryptPass($password);
    if ($password == null)
        $errors[] = "Error: cannot encrypt password. Please Retry.";
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
        Lib::Log($email, FALSE, "New register attempts.", "info");
    } else
        register($name, $lastname, $login, $email, $password);
}

function alreadyRegistered($email)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT email FROM users_admin WHERE email=:email");
    $request->execute(array(":email" => $email));
    $result = $request->fetch();
    $dbh = null;
    if (!empty($result))
        return true;
    return false;
}

function encryptPass($password)
{
    $options = [
        'cost' => 15
    ];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hash;
}

function register($name, $lastname, $login, $email, $password)
{
    $dbh = Lib::createSecureDataConnection();
    $uuid = uniqid();
    $request = $dbh->prepare("INSERT INTO users_admin (uuid, name, lastname, login, email, password) VALUES (:uuid, :name, :lastname, :login, :email, :password)");
    $request->execute(array(
        'uuid' => $uuid,
        ':name' => $name,
        ':lastname' => $lastname,
        ':login' => $login,
        ':email' => $email,
        ':password' => $password
    ));
    $dbh = NULL;
    insertUserDefaultRight($uuid);
    Lib::Log($email, TRUE, "New register attempts.", "info");
    $message = "Sucess: user ".$name." ".$lastname." added.";
    echo "
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
    ".$message."
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
    </button>
    </div>
    ";
}

function insertUserDefaultRight($uuid)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare('INSERT INTO users_roles (uuid, user_uuid) VALUES (:uuid, :user_uuid)');
    $request->execute(array(
        ':uuid' => uniqid(),
        ':user_uuid' => $uuid
    ));
    $dbh = null;
}
