<?php
require_once("token.class.php");

function initLogin() {
    $email = Lib::Sanitize($_POST['email']);
    $password = Lib::Sanitize($_POST['password']);
    $errors = array();
    $token = null;

    if (empty($email))
        $errors[] = "Error: no email completed.";
    if (empty($password))
        $errors[] = "Error: no password completed.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Error: email is not valid";
    if (!isset($_COOKIE['oauth_tok']))
        $errors[] = "Error: no authentification token available.";
    else {
        $token = new Token($_COOKIE['oauth_tok']);
        if (!isValidToken($token, true)) {
            $error = "Error: invalid token provided.";
            Lib::Log($email, FALSE, "New login attempts with bad authentification token.", "danger");
        }
    }
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
    } else if ($token != null)
        startLoginProcedure($email, $password, $token);
    else {
        echo "
        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        An error occured. Please, retry later.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>
        ";
    }
}

function startLoginProcedure($email, $password, $token) {
    $dbh = Lib::createSecureDataConnection();
    $errors = array();

    $request = $dbh->prepare("SELECT id, email, name, lastname, login, password, isadmin FROM users_admin WHERE email=:email");
    $request->execute(array(":email" => $email));
    $result = $request->fetch();
    if (empty($result))
        $errors[] = "Error: no user found for this email";
    else if (!password_verify($password, $result['password']))
        $errors[] = "Error: incorrect password";
    else if ($token->getUserAssociateId() !== Lib::Sanitize($result['id'])) {
        $errors[] = "Error: no associate authentification token for this account.";
        Lib::Log($email, FALSE, "New login attempts with bad authentification token.", "danger");
    }
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
