<?php
require_once("../functions/Lib.func.php");
include("roles_right.class.php");

class Roles {
    private $_id;
    private $_uuid;
    private $_rolesRight = array();

    public $_name;

    function __construct($uuid) {
        $this->_uuid = Lib::Sanitize($uuid);
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT id, name FROM roles WHERE uuid=:uuid");
        $request->execute(array(
            ":uuid" => $uuid
        ));
        $result = $request->fetch();
        if (empty($result))
            return;
        $this->_id = Lib::Sanitize($result['id']);
        $this->_name = Lib::Sanitize($result['name']);
        $this->_rolesRight = $this->generateRight($this->_uuid);
    }

    private function generateRight($uuid) {
        $objArr = array();
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT uuid FROM roles_right WHERE roles_uuid=:uuid");
        $request->execute(array(
            ":uuid" => $uuid
        ));
        $result = $request->fetchAll();
        if (empty($result))
            return NULL;
        foreach ($result as $key => $value) {
            $objArr[] = new rolesRight(Lib::Sanitize($value['uuid']));
        }
        $dbh = NULL;
        return $objArr;
    }

    public function getId() {
        return $this->_id;
    }

    public function getUuid() {
        return $this->_uuid;
    }

    public function getRolesRight() {
        return $this->_rolesRight;
    }
};
