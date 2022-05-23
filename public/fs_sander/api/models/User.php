<?php

namespace models;

use BaseModel;

class User extends BaseModel {

    public $usr_id;

    public $usr_name;

    public $usr_email;

    public $usr_password;

    public $usr_isAdmin;

    /**
     * @param $usr_id
     * @param $usr_name
     * @param $usr_email
     * @param $usr_password
     */
    public function __construct($usr_id, $usr_name, $usr_lastname, $usr_email, $usr_password, $usr_isAdmin=false) {
        $this->usr_id = $usr_id;
        $this->usr_name = $usr_name;
        $this->usr_lastname = $usr_lastname;
        $this->usr_email = $usr_email;
        $this->usr_password = $usr_password;
        $this->usr_isAdmin = $usr_isAdmin;
    }

    /**
     * @return int
     */
    public function getUsrId() {
        return $this->usr_id;
    }

    public function setUsrId($usr_id) {
        $this->usr_id = $usr_id;
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
        if (is_string($usr_name)){
            $this->usr_name = $usr_name;
        }
    }

    public function getLastName(): string{
        return $this->usr_lastname;
    }

    public function setLastName(string $lastname): void {
        $this->usr_lastname = $lastname;
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
        if (preg_match('/.+\@.+\..+', $usr_email)){
            $this->usr_email = $usr_email;
        }
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

    /**
     * 
     */
    public function IsAdmin(){
        return $this->usr_isAdmin;
    }


}