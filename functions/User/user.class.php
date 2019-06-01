<?php
require_once("../functions/Lib.func.php");
require_once("../functions/Roles/roles.class.php");
include("../functions/Token/token.class.php");

class User {
    private $_id;
    private $_uuid;
    private $_email;
    private $_isadmin;
    private $_tokenList = array();
    private $_roles = array();

    public $_name;
    public $_lastname;
    public $_login;
    public $_avatar;

    function __construct($id) {
        $this->_id = Lib::Sanitize($id);
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT uuid, email, isadmin, name, lastname, login, avatar FROM users_admin WHERE id=:id");
        $request->execute(array(":id" => $this->_id));
        $result = $request->fetch();
        if (empty($result))
            return;
        $this->_uuid = Lib::Sanitize($result['uuid']);
        $this->_tokenList = $this->generateTokenClassArray($this->_id);
        $this->_roles = $this->generateRoles($this->_uuid);
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

    private function generateRoles($uuid) {
        $objArr = array();
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT roles_uuid FROM users_roles WHERE user_uuid=:uuid");
        $request->execute(array(
            ":uuid" => $uuid
        ));
        $result = $request->fetchAll();
        if (empty($result))
            return NULL;
        foreach ($result as $key => $value) {
            $objArr[] = new Roles(Lib::Sanitize($value['roles_uuid']));
        }
        $dbh = null;
        return $objArr;
    }

    public function getId() {
        return $this->_id;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getGrade() {
        return $this->_isadmin;
    }

    public function getTokens() {
        return $this->_tokenList;
    }

    public function getRoles() {
        return $this->_roles;
    }

    public function getUuid() {
        return $this->_uuid;
    }

    public function setEmail($email) {
        $this->_email = $email;
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare('UPDATE users_admin SET email=:email WHERE id=:id');
        $request->execute(array(
            ':email' => $this->_email,
            ':id' => $this->_id
        ));
        Lib::Log($this->_email, TRUE, "User ".$this->_login." as change his email.", "info");
        $dbh = null;
    }

    public function setAvatar($avatar) {
        $this->_avatar = $avatar;
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare('UPDATE users_admin SET avatar=:avatar WHERE id=:id');
        $request->execute(array(
            ':avatar' => $this->_avatar,
            ':id' => $this->_id
        ));
        Lib::Log($this->_email, TRUE, "User ".$this->_login." as change his profil picture.", "info");
        $dbh = null;
    }
};
