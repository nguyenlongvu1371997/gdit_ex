<?php

class User {
    private $first_name;
    private $last_name;
    private $address;
    private $birthday;

    public function __construct($first_name, $last_name, $address, $birthday) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->address = $address;
        $this->birthday = $birthday;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }
}

?>