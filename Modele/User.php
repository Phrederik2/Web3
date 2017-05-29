<?php
include_once("Modele/Primary.php");
include_once("Tool/Date.php");

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
    private $listDay=[];
    
    function __construct($id,$firstName,$lastName,$isAdmin){
        parent::__construct($id,$isAdmin);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setTimestamp(time()*1000);
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
    function getFirstDay(){return $this->firstDay;}
    function setFirstDay($firstDay){$this->firstDay= $firstDay;}
    function getLastDay(){return $this->lastDay;}
    function setLastDay($lastDay){$this->lastDay= $lastDay;}
    function getLocal(){return $this->local;}
    function setLocal($local){$this->local= $local;}
    function getListDay(){return $this->listDay;}
    function setListDay($listDay){$this->listDay= $listDay;}
    function getTimestamp(){return $this->timestamp;}
    function setTimestamp($timestamp){
        
        date_default_timezone_set("Europe/Paris");
        
        $date=date('Y/m/d',($timestamp/1000));
        $jour = date("w",strtotime($date));
        
        if ($jour){
            $this->setFirstDay(DateTool::moveDay($date,-($jour-1)));
        }
        else{
            $this->setFirstDay($date);
        }
        
        $this->setLastDay(DateTool::moveDay($this->getFirstDay(),+7));
        
        $this->listDay=[];
        
        for ($i=0; $i < 7 ; $i++) {
            $this->listDay[] = DateTool::moveDay($this->getFirstDay(),$i);
        }
        
        
        $this->timestamp= $timestamp;
        Session::saveSession();
    }
    
    
}