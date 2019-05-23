<?php

Class Lib {
    function Sanitize($str) {
        $sanitizeStr = trim($str);
        $sanitizeStr = strip_tags($sanitizeStr);
        $sanitizeStr = htmlentities($sanitizeStr, ENT_NOQUOTES);
        $sanitizeStr = filter_var($sanitizeStr, FILTER_SANITIZE_STRIPPED);
        return $sanitizeStr;
    }

    function createSecureDataConnection() {
        $dbh = NULL;
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=leaflighted', 'root', '');
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
        return $dbh;
    }

    function Log($name, $succeed, $message, $level)
    {
        $dateApp = date('Y-m-d H:i:s');
        $ip = Lib::getClientIp();
        $dbh = Lib::createSecureDataConnection();
        $level = $level;
        $request = $dbh->prepare("INSERT INTO log (dateApp, ip, message, success, level) VALUES (:dateApp, :ip, :message, :success, :level)");
        $request->execute(array(
            ':dateApp' => $dateApp,
            ':ip' => $ip,
            ':message' => $message,
            ':success' => $succeed,
            ':level' => $level
        ));
        $dbh = NULL;
    }

    function getClientIp() {
        $ip = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    function getLocationFromIp($ip)
    {
        return "test";
    }
}
