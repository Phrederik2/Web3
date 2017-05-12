<?php

require_once("Modele/Primary.php");

class User extends Primary{

    private $firstName = "";
    private $lastName = "";

    function __construct($id,$firstName,$lastName,$isAdmin){
        parent::__construct($id,$isAdmin);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    function getFristName(){return $this->fristName;}
    function setFristName($fristName){$this->fristName= $fristName;}
    function getLastName(){return $this->lastName;}
    function setLastName($lastName){$this->lastName= $lastName;}
    function getIsAdmin(){return $this->isAdmin;}
    function setIsAdmin($isAdmin){$this->isAdmin= $isAdmin;}

    
}