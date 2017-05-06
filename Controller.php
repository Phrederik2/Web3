<?php

require_once("Modele/DbCo.php");

class Controller{
    
    private $dbCo;//Création d'une istance de la classe de connectin qui sert à appelé les différentes query
    
    public function __construct()
    {

        $this->dbCo = new DbCo();
    }

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
    
    function setForm(){
        
        include("view/UserView.php");
    }
    
    function getTableView($menu,$column1,$column2){
            $crtList = $this->dbCo->getTableViewList($menu,$column1,$column2); 
        include("view/TableList.php");
    }
}