<?php

require_once("Lib.func.php");
include("token.class.php");

class User {
    private $_id;
    private $_email;
    private $_isadmin;
    private $_tokenList = array();

    public $_name;
    public $_lastname;
    public $_login;
    public $_avatar;

    function __construct($id) {
        $this->_id = Lib::Sanitize($id);
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT email, isadmin, name, lastname, login, avatar FROM users_admin WHERE id=:id");
        $request->execute(array(":id" => $this->_id));
        $result = $request->fetch();
        if (empty($result))
            return;
        $this->_tokenList = $this->generateTokenClassArray($this->_id);
        $this->_email = Lib::Sanitize($result['email']);
        $this->_isadmin = Lib::Sanitize($result['isadmin']);
        $this->_name = Lib::Sanitize($result['name']);
        $this->_lastname = Lib::Sanitize($result['lastname']);
        $this->_login = Lib::Sanitize($result['login']);
        $this->_avatar = Lib::Sanitize($result['avatar']);
        $dbh = NULL;
    }

    private function generateTokenClassArray($id) {
        $objArr = array();
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT token_value FROM oauth_tok WHERE user_id=:id");
        $request->execute(array(
            ':id' => $id
        ));
        $result = $request->fetchAll();
        foreach ($result as $key => $value)
            $objArr[] = new Token(Lib::Sanitize($value['token_value']));
        $dbh = null;
        return $objArr;
    }

    public function getId() {
        return $this->_id;
    }

    public function getEmail() {
        return $this->_Email;
    }

    public function getGrade() {
        return $this->_isadmin;
    }

    public function getTokens() {
        return $this->_tokenList;
    }
};
