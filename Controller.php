<?php

require_once("Modele/DbCo.php");
define ( "FILE", basename ( $_SERVER ['SCRIPT_FILENAME'] ) );

class Controller{
    
    private $dbCo;//Création d'une istance de la classe de connection qui sert à appelé les différentes query
    
    public function __construct()
    {
        
        $this->dbCo = new DbCo();
    }
    
    function switchMenu()
    {
        if (isset($_GET["menu"])){
            switch ($_GET["menu"]) {
                case 'user':
                    echo "test2";
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
        if(isset($_GET['remove']) and $_GET['remove'] ==true){
            //
        }
        switch ($_GET["menu"]) {
            case 'user':
                $this->getTableViewAssoc($_GET["menu"],"title","code","department","manage",$_GET["id"]);
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

function setFreed()
{
    if (isset($_GET["menu"]) and isset($_GET["id"])){
        switch ($_GET["menu"]) {
            case 'user':
                $this->getTableViewFreed($_GET["menu"],"title","code","department","manage",$_GET["id"]);
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

function getTableView($menu,$column1,$column2){
    $pivot = "null";
    $crtList = $this->dbCo->getTableViewList($menu,$column1,$column2);
    include("view/TableList.php");
}

function getTableViewAssoc($menu,$column1,$column2,$destination,$pivot,$idItem){
    $pivot = "assoc";
    $crtList = $this->dbCo->getTableViewAssociate($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}

function getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem){
    $pivot = "freed";
    $crtList = $this->dbCo->getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}
}