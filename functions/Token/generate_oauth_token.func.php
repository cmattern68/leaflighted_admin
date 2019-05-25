<?php

function generateNewToken($id)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM users_admin WHERE id=:id");
    $request->execute(array(
        'id' => $id
    ));
    $result = $request->fetch();
    if (empty($result))
        echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=generate_auth_token';</script>";
    $uuid = uniqid();
    $user_id =  Lib::Sanitize($result['id']);
    $tokenValue = bin2hex(random_bytes(64));
    $associate_ip_adress = Lib::getClientIp();
    $request = $dbh->prepare("INSERT INTO oauth_tok (uuid, user_id, token_value, isvalidate, associate_ip_adress, generate_date) VALUES (:uuid, :user_id, :token_value, :isvalidate, :associate_ip_adress, NOW())");
    $request->execute(array(
        ':uuid' => Lib::Sanitize($uuid),
        ':user_id' => $user_id,
        ':token_value' => Lib::Sanitize($tokenValue),
        ':isvalidate' => false,
        ':associate_ip_adress' => Lib::Sanitize($associate_ip_adress)
    ));
    $dbh = null;
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=generate_auth_token';</script>";
    sendAuthTokenByMail($tokenValue);
}

function sendAuthTokenByMail($token)
{
    $message = wordwrap($message, 70, "\r\n");
    $to = "corentin.mattern@epitech.eu";
    $link = "https://manage.leaflighted.com/index.php?token=".$token;
    $subject = $lang['contact']['sendmail'].": ".$reason;
    $content = "Hello, here is your OAuth link activation:".$link;
    $headers = 'From: noreply@leaflighted.com'."\r\n".
    'X-Mailer: PHP/'.phpversion();
    mail($to, $subject, $content, $headers);
}

function setValidationAndCookie($token)
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("UPDATE oauth_tok SET isvalidate=:isvalidate WHERE user_id=:id");
    $request->execute(array(
        ':isvalidate' => true,
        ':id' => $token->getUserAssociateId()
    ));
    $dbh = NULL;
    setcookie("oauth_tok", $token->getValue(), time()+31556926);
    return "
    <div class=\"row\">
    <div class=\"col-lg-7\">
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
    Token validate.
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
    </button>
    </div>
    </div>
    </div>
    ";
}
