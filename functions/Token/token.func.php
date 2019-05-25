<?php

function getUserForTokList()
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

function isValidToken($token, $by)
{
    if ($token->getValue() == null || $token->getValidation() == false) {
        if ($by == false) {
            return "
            <div class=\"row\">
            <div class=\"col-lg-7\">
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            Error: Invalid token.
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
            </button>
            </div>
            </div>
            </div>
            ";
        } else
            return false;

    }
    if ($by ==false)
        return "";
    else
        return true;
}
