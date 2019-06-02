<?php

Class Lib {
    public function Sanitize($str) {
        $sanitizeStr = trim($str);
        $sanitizeStr = strip_tags($sanitizeStr);
        $sanitizeStr = htmlentities($sanitizeStr, ENT_NOQUOTES);
        $sanitizeStr = filter_var($sanitizeStr, FILTER_SANITIZE_STRIPPED);
        return $sanitizeStr;
    }

    public function SanitizeArr($arr) {
        $sanitizeArr = array();
        foreach ($arr as $key => $str) {
            $sanitizeArr[] = Lib::Sanitize($str);
        }
        return $sanitizeArr;
    }

    public function createSecureDataConnection() {
        $dbh = NULL;
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=leaflighted', 'root', '');
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
        return $dbh;
    }

    public function Log($name, $succeed, $message, $level)
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

    public function getClientIp() {
        $ip = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    public function getUserList()
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

    public function getLocationFromIp($ip)
    {
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"), true);
        if (!isset($details['city']))
            return "Undefined";
        $city = Lib::Sanitize($details['city']);
        return $city;
    }

    public function print_r2($things) {
        echo "<pre>";
        print_r($things);
        echo "</pre>";
    }

    public function getSections()
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

    public function getRolesList()
    {
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare('SELECT * FROM roles');
        $request->execute();
        $arr = $request->fetchAll();
        $dbh = null;
        return $arr;
    }
}
