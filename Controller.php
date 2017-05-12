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
    private static $listColumn1="";
    private static $listColumn2="";
    private static $viewItem="";
    private static $form=null;
    private static $menu = Array();
    
    public function __construct()
    {
        $this->dbCo = new DbCo();
        $this->setMenu();
        $this->setSetting();
    }
    
    private static function getOrigin(){return Controller::$origin;}
    private function setOrigin($origin){Controller::$origin= $origin;}
    private static function getDestination(){return Controller::$destination;}
    private function setDestination($destination){Controller::$destination= $destination;}
    private static function getPivot(){return Controller::$pivot;}
    private function setPivot($pivot){Controller::$pivot= $pivot;}
    private static function getColumn1(){return Controller::$column1;}
    private function setColumn1($column1){Controller::$column1= $column1;}
    private static function getColumn2(){return Controller::$column2;}
    private function setColumn2($column2){Controller::$column2= $column2;}
    private static function getViewItem(){return Controller::$viewItem;}
    private function setViewItem($viewItem){Controller::$viewItem= $viewItem;}
    private static function getListColumn1(){return Controller::$listColumn1;}
    private function setListColumn1($listColumn1){Controller::$listColumn1= $listColumn1;}
    private static function getListColumn2(){return Controller::$listColumn2;}
    private function setListColumn2($listColumn2){Controller::$listColumn2= $listColumn2;}
    private static function setForma($forma){Controller::$form=$forma;}
    
    public function switchMenu()
    {
        if (isset($_GET["menu"])){
            $this->getTableView($_GET["menu"],Controller::getListColumn1(),Controller::getListColumn2());
        }
    }

    private function setMenu()
    {
       Controller::$menu["User"]="user"; 
       Controller::$menu["Department"]="department";
    }

    public function getMenu()
    {
        include("View/MenuView.php");
    }
    
    private function setSetting(){
        if (session_status()==PHP_SESSION_DISABLED)session_start();
        if (!isset($_GET["menu"]))return;
        switch ($_GET["menu"]) {
            
            case 'user':
                $this->setView("firstname","lastname","user","manage","department","title","code","view/UserView.php");
                break;
            case 'department':
                $this->setView("title","code","department","manage","user","lastName","firstName","view/ReferenceView.php");
                break;
            case 'resource':
                $this->setView("title","code","resource","dispose","local","title","code","view/ReferenceView.php");
                break;
            case 'sgroup':
                $this->setView("title","code","sgroup","linksgroupstudent","student","lastName","firstName","view/ReferenceView.php");
                break;
            case 'student':
                $this->setView("firstname","lastname","student","linksgroupstudent","sgroup","title","code","view/StudentView.php");
                break;
            case 'professor':
                $this->setView("firstname","lastname","professor","request","unavailability","firstday","lastday","view/ProfessorView.php");
                break;
            
            default:
                # code...
                break;
    }
    $this->checkData();
}

private function checkData()
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

private function setView($listColumn1,$listColumn2,$origin,$pivot,$destination,$column1,$column2,$viewItem)
{
    Controller::setListColumn1($listColumn1);
    Controller::setListColumn2($listColumn2);
    Controller::setOrigin($origin);
    Controller::setPivot($pivot);
    Controller::setDestination($destination);
    Controller::setColumn1($column1);
    Controller::setColumn2($column2);
    Controller::setViewItem($viewItem);
}

public function setForm(){
    if (isset($_GET["menu"])){
        include(Controller::getViewItem());
        
    }
}

public function getForm()
{
    if(Controller::$form!=null){
        echo Controller::$form->toString();
    }
}

public function setAssoc()
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

public function setFreed()
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

public function getTableView(String $menu,String $column1,String $column2){
    $GEToption = "";
    $crtList = $this->dbCo->getTableViewList($menu,$column1,$column2);
    include("view/TableList.php");
}

public function getTableViewAssoc(String $menu,String $column1,String $column2,String $destination,String $pivot,$idItem){
    $GEToption = "assoc";
    $crtList = $this->dbCo->getTableViewAssociate($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}

public function getTableViewFreed(String $menu,String $column1,String $column2,String $destination,String $pivot,$idItem){
    $GEToption = "freed";
    $crtList = $this->dbCo->getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}
}