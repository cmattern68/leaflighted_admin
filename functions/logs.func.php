<?php

require_once("Lib.func.php");

class Log {
    private $_id;
    private $_ip;
    private $_location;

    public $_date;
    public $_message;
    public $_success;
    public $_level;

    function __construct($id) {
        $this->_id = Lib::Sanitize($id);
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT dateApp, ip, message, success, level FROM log WHERE id=:id");
        $request->execute(array(":id" => $this->_id));
        $result = $request->fetch();
        if (empty($result)) {
            $this->_message = null;
            return;
        }
        $this->_ip = Lib::Sanitize($result['ip']);
        $this->_location = $this->setLocation($this->_ip);
        $this->_date = Lib::Sanitize($result['dateApp']);
        $this->_message = Lib::Sanitize($result['message']);
        $this->_success = Lib::Sanitize($result['success']);
        $this->_level = Lib::Sanitize($result['level']);
        $dbh = NULL;
    }

    private function setLocation($ip) {
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"), true);
        if (!isset($city))
            return "Undefined";
        $city = Lib::Sanitize($details['city']);
        if (empty($city) || $city == "")
            return "Undefined";
        return $city;
    }

    public function getIp() {
        return $this->_ip;
    }

    public function getLocation() {
        return $this->_location;
    }
};

function generateLogObjArray()
{
    $objArr = array();
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM log");
    $request->execute();
    $result = $request->fetchAll();
    if (empty($result)) {
            $dbh = null;
            return null;
    }
    foreach ($result as $key => $value) {
        $objArr[] = new Log(Lib::Sanitize($value['id']));
    }
    $dbh = null;
    return $objArr;
}

function flushLogs()
{
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("DELETE FROM log");
    $request->execute();
    $dbh = null;
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=logs';</script>";
}
