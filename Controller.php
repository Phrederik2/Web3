<?php

require_once("Modele/DbCo.php");
define ( "FILE", basename ( $_SERVER ['SCRIPT_FILENAME'] ) );

class Controller{
    
    private $dbCo;//Création d'une istance de la classe de connection qui sert à appelé les différentes query
    private static $origin="";
				private static $destination="";
				private static $pivot="";
				private static $column1="";
				private static $column2="";

    public function __construct()
    {
        $this->dbCo = new DbCo();
        $this->setSetting();
    }

static function getOrigin(){return Controller::$origin;}
function setOrigin($origin){Controller::$origin= $origin;}
static function getDestination(){return Controller::$destination;}
function setDestination($destination){Controller::$destination= $destination;}
static function getPivot(){return Controller::$pivot;}
function setPivot($pivot){Controller::$pivot= $pivot;}
static function getColumn1(){return Controller::$column1;}
function setColumn1($column1){Controller::$column1= $column1;}
static function getColumn2(){return Controller::$column2;}
function setColumn2($column2){Controller::$column2= $column2;}

    
    function switchMenu()
    {
        if (isset($_GET["menu"])){
            switch ($_GET["menu"]) {
                case 'user':
                    $this->getTableView($_GET["menu"],"lastname","firstname");
                    break;
                case 'student':
                    # code...
                    break;
                
                default:
                    # code...
                    break;
        }
    }
}

function setSetting(){
   if (session_status()==PHP_SESSION_DISABLED)session_start();

switch ($_GET["menu"]) {
    
                case 'user':
               
																$this->setView($_GET["menu"],"manage","department","title","code");
                    break;
                case 'student':
                    # code...
                    break;
                
                default:
                    # code...
                    break;
        }
        $this->checkData();
}

function checkData()
{

    if(isset($_GET['remove']) and Controller::getOrigin()== $_GET["menu"]){
            $this->dbCo->removePivot(
           	Controller::getOrigin(),
            Controller::getPivot(), 
            Controller::getDestination(),
            $_GET['id'],
            $_GET['remove']);
        }

    if(isset($_GET['add']) and Controller::getOrigin()== $_GET["menu"]){
            $this->dbCo->addToPivot(
            Controller::getOrigin(),
            Controller::getPivot(), 
            Controller::getDestination(),
            $_GET['id'],
            $_GET['add']);
        }
}

private function setView($origin,$pivot,$destination,$column1,$column2)
{
     Controller::setOrigin($origin);
     Controller::setPivot($pivot);
     Controller::setDestination($destination);
     Controller::setColumn1($column1);
     Controller::setColumn2($column2);
}

function setForm(){
    if (isset($_GET["menu"])){
        switch ($_GET["menu"]) {
            case 'user':
                include("view/UserView.php");
                break;
            case 'student':
                # code...
                break;
            
            default:
                # code...
                break;
    }
}
}

function setAssoc()
{
    if (isset($_GET["menu"]) and isset($_GET["id"])){
         
        $this->getTableViewAssoc(
           Controller::getOrigin(),
           Controller::getColumn1(),
           Controller::getColumn2(),
           Controller::getDestination(),
           Controller::getPivot(),
            $_GET["id"]);
    }         
}

function setFreed()
{
     if (isset($_GET["menu"]) and isset($_GET["id"])){
         
        $this->getTableViewFreed(
           Controller::getOrigin(),
           Controller::getColumn1(),
           Controller::getColumn2(),
           Controller::getDestination(),
           Controller::getPivot(),
            $_GET["id"]);
    }  
}

function getTableView($menu,$column1,$column2){
    $GEToption = "";
    $crtList = $this->dbCo->getTableViewList($menu,$column1,$column2);
    include("view/TableList.php");
}

function getTableViewAssoc($menu,$column1,$column2,$destination,$pivot,$idItem){
    $GEToption = "assoc";
    $crtList = $this->dbCo->getTableViewAssociate($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}

function getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem){
    $GEToption = "freed";
    $crtList = $this->dbCo->getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}
}