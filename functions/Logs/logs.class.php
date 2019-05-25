<?php

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
        $this->_location = Lib::getLocationFromIp($this->_ip);
        $this->_date = Lib::Sanitize($result['dateApp']);
        $this->_message = Lib::Sanitize($result['message']);
        $this->_success = Lib::Sanitize($result['success']);
        $this->_level = Lib::Sanitize($result['level']);
        $dbh = NULL;
    }

    public function getIp() {
        return $this->_ip;
    }

    public function getLocation() {
        return $this->_location;
    }
};
