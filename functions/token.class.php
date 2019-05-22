<?php

require_once("Lib.func.php");

class Token {
    private $_id;
    private $_user_id;
    private $_isvalidate;
    private $_associate_ip_adress;
    private $_value;

    function __construct($value) {
        $this->_value = Lib::Sanitize($value);
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT id, user_id, isvalidate, associate_ip_adress FROM oauth_tok WHERE token_value=:value");
        $request->execute(array(":value" => $this->_value));
        $result = $request->fetch();
        if (empty($result))
            return;
        $this->_id = Lib::Sanitize($result['id']);
        $this->_user_id = Lib::Sanitize($result['user_id']);
        $this->_isvalidate = Lib::Sanitize($result['isvalidate']);
        $this->_associate_ip_adress = Lib::Sanitize($result['associate_ip_adress']);
        $dbh = NULL;
    }

    public function getId() {
        return $this->_id;
    }

    public function getUserAssociateId() {
        return $this->_user_id;
    }

    public function getValidation() {
        return $this->_isvalidate;
    }

    public function getAssociateIpAdress() {
        return $this->_associate_ip_adress;
    }

    public function getValue() {
        return $this->_value;
    }
};
