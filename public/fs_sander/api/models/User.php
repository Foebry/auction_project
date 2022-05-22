<?php

namespace models;

use BaseModel;

class User extends BaseModel {

    protected $usr_id;

    protected $usr_name;

    protected $usr_email;

    protected $usr_password;

    protected $usr_isAdmin;

    /**
     * @param $usr_id
     * @param $usr_name
     * @param $usr_email
     * @param $usr_password
     */
    public function __construct($usr_id, $usr_name, $usr_email, $usr_password, $usr_isAdmin=false) {
        $this->usr_id = $usr_id;
        $this->usr_name = $usr_name;
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