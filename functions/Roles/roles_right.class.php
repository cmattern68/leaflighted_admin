<?php

require_once("../functions/Lib.func.php");

class rolesRight {
    private $_id;
    private $_uuid;
    private $_roles_uuid;
    private $_associate_right;

    function __construct($uuid) {
        $this->_uuid = $uuid;
        $dbh = Lib::createSecureDataConnection();
        $request = $dbh->prepare("SELECT * FROM roles_right WHERE uuid=:uuid");
        $request->execute(array(
            "uuid" => $this->_uuid
        ));
        $result = $request->fetch();
        if (empty($result))
            return;
        $this->_id = Lib::Sanitize($result['id']);
        $this->_roles_uuid = Lib::Sanitize($result['roles_uuid']);
        $this->_associate_right = substr(Lib::Sanitize($result['associate_right']), 7);
        $this->_associate_right = str_replace("_", " ", $this->_associate_right);
        $dbh = NULL;
    }

    public function getId() {
        return $this->_id;
    }

    public function getUuid() {
        return $this->_uuid;
    }

    public function getRolesUuid() {
        return $this->_roles_uuid;
    }

    public function getAssociateRight() {
        return $this->_associate_right;
    }

};
