<?php

require_once("Modele/Primary.php");

class User extends Primary{

    private $lastName = "";
    private $firstName = "";
    private $password = "";

    function __construct($id,$isAdmin,$isChange,$isDelete,$lastName, $firstName, $password){
        parent::__construct($id,$isAdmin,$isChange,$isDelete);
        $this->setLastName($lastName);
        $this->setFirstName($firstName);
        $this->setPasswaord($password);
    }

    function getLastName(){
        return $this->lastName;        
    }

    function getFirstName(){
        return $this->firstName;       
    }

    function getPasswaord(){
        return $this->password;
    }


    function setLastName($lastName){
        $this->lastName = $lastName;
    }

    function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    function setPasswaord($password){
        $this->password = $password;
    }
}