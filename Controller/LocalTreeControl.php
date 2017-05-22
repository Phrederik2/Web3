<?php

require_once("Modele/DbCo.php");
/**
 * Class gestion du TreeView dans le schedule
 */
class LocalTree{
    
    private $dbCo;

    function __construct(){
        $this->dbCo = new DbCo();
    }

    /**
     * Création d'un tree view contenant l'esemble des établissement et des locaux qui leurs sont join
     *
     * @return void
     */
    public  function getLocalTree(){
        $str="";
        $estaTab = $this->dbCo->getEstaEntry();
        include("View/LocalTreeView.php");
        return $str;
    }
}