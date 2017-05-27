<?php
include_once("Modele/Primary.php");


class User extends Primary{
    
    private $firstName = "";
    private $lastName = "";

    // Variable d'environement (Planning)

    private $activity=null;
    private $week=null;
    private $local=null;
    private $firstDay=null;
    private $lastDay=null;
    private $timestamp=null;
    
    function __construct($id,$firstName,$lastName,$isAdmin){
        parent::__construct($id,$isAdmin);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }
    
    function getFirstName(){return $this->firstName;}
    function setFirstName($firstName){$this->firstName= $firstName;}
    function getLastName(){return $this->lastName;}
    function setLastName($lastName){$this->lastName= $lastName;}
    function getIsAdmin(){return $this->isAdmin;}
    function setIsAdmin($isAdmin){$this->isAdmin= $isAdmin;}
    function getActivity(){return $this->activity;}
    function setActivity($activity){$this->activity= $activity;}
    function getWeek(){return $this->week;}
    function setWeek($week){$this->week= $week;}
    function getfirstDay(){return $this->firstDay;}
    function setFirstDay($firstDay){$this->firstDay= $firstDay;}
    function getLastDay(){return $this->lastDay;}
    function setLastDay($lastDay){$this->lastDay= $lastDay;}
    function getLocal(){return $this->local;}
    function setLocal($local){$this->local= $local;}
    function getTimestamp(){return $this->timestamp;}
    function setTimestamp($timestamp){
        $timestamp=$timestamp/1000;
        $date=null;
        $date=date("Y/m/d",strtotime("2017/05/27"));
        $date=date("Y/m/d",$timestamp);
        $date= date(DATE_RFC2822);
        $date=time();
        
        $this->timestamp= $timestamp;}


    
    
}