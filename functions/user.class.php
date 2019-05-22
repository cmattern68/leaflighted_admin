<?php

require_once("Lib.func.php");

class User {
    private $_id;
    private $_email;
    private $_isadmin;

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
        $this->_email = $result['email'];
        $this->_isadmin = $result['isadmin'];
        $this->_name = $result['name'];
        $this->_lastname = $result['lastname'];
        $this->_login = $result['login'];
        $this->_avatar = $result['avatar'];
        $dbh = NULL;
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
};
