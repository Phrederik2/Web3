<?php

require_once("Modele/DbCo.php");

class Controller{
    
    private $dbCo;//Création d'une istance de la classe de connectin qui sert à appelé les différentes query
    
    public function __construct()
    {
        $this->dbCo = new DbCo();
    }
    
    function setForm(){
        //$userList = $this->dbCo->getUserList();
        /*foreach($userList as $test){
        echo $test->getLastName();
        }*/
        include("view/UserView.php");
    }
    
    function getTableView(){
        if(isset($_GET['menu'])){
            $crtList = $this->dbCo->getTableViewList($_GET['menu'],$_GET['colonne1'],$_GET['colonne2']);
        }else{
            $crtList = $this->dbCo->getTableViewList('user','lastName','firstName');
        }
        include("view/TableView.php");
    }
}