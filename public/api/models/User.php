<?php

namespace models;

class User {

    private $usr_id;

    private $usr_name;

    private $usr_email;

    private $usr_password;

    /**
     * @param $usr_id
     * @param $usr_name
     * @param $usr_email
     * @param $usr_password
     */
    public function __construct($usr_id, $usr_name, $usr_email, $usr_password) {
        $this->usr_id = $usr_id;
        $this->usr_name = $usr_name;
        $this->usr_email = $usr_email;
        $this->usr_password = $usr_password;
    }

    /**
     * @return int
     */
    public function getUsrId() {
        return $this->usr_id;
    }

    /**
     * @return string
     */
    public function getUsrName() {
        return $this->usr_name;
    }

    /**
     * @param string $usr_name
     */
    public function setUsrName($usr_name) {
        $this->usr_name = $usr_name;
    }

    /**
     * @return string
     */
    public function getUsrEmail() {
        return $this->usr_email;
    }

    /**
     * @param string $usr_email
     */
    public function setUsrEmail($usr_email) {
        $this->usr_email = $usr_email;
    }

    /**
     * @return string
     */
    public function getUsrPassword() {
        return $this->usr_password;
    }

    /**
     * @param string $usr_password
     */
    public function setUsrPassword($usr_password) {
        $this->usr_password = $usr_password;
    }

}