<?php

require_once("Lib.func.php");
include("user.class.php");

function initLogin() {
    $email = Lib::Sanitize($_POST['email']);
    $password = Lib::Sanitize($_POST['password']);
    $errors = array();

    if (empty($email))
        $errors[] = "Error: no email completed.";
    if (empty($password))
        $errors[] = "Error: no password completed.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Error: email is not valid";
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
        Lib::Log($email, FALSE, "New login attempts.", "warning");
    } else
        startLoginProcedure($email, $password);
}

function startLoginProcedure($email, $password) {
    $dbh = Lib::createSecureDataConnection();
    $errors = array();

    $request = $dbh->prepare("SELECT id, email, name, lastname, login, password, isadmin FROM users_admin WHERE email=:email");
    $request->execute(array(":email" => $email));
    $result = $request->fetch();
    if (empty($result))
        $errors[] = "Error: no user found for this email";
    else if ($password != $result['password'])
        $errors[] = "Error: incorrect password";
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
        Lib::Log($email, FALSE, "New login attempts.", "warning");
    } else {
        unset($result['password']);
        unset($result[5]);
        login($result);
    }
    $dbh = NULL;
}

function login($result) {
    Lib::Log($result["email"], TRUE, "New login attempts.", "info");
    session_start();
    $_SESSION['user_id'] = $result['id'];
    echo "<script type=\"text/javascript\">window.location.href = 'interface/';</script>";
}

function checkValideData($id) {
    $dbh = Lib::createSecureDataConnection();
    if ($id <= 0) {
        unset($_SESSION['user_id']);
        session_destroy();
        return;
    }
    $request = $dbh->prepare("SELECT id FROM users_admin WHERE id=:id");
    $request->execute(array(":id" => $id));
    $result = $request->fetch();
    if (empty($result)) {
        unset($_SESSION['user_id']);
        session_destroy();
        return;
    }
    echo "<script type=\"text/javascript\">window.location.href = 'interface/';</script>";
}
