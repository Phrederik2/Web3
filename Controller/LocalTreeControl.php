<?php

require_once("Modele/DbCo.php");

class LocalTree{
    
    /**
     * Retourne la liste complète des établissement
     *
     * @return void
     */
    private function getEstaEntry(){
        $tableList = array();
        $Qry = "SELECT id,title FROM establishment WHERE isdelete=0";
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $title = $row['title'];
            $id = $row['id'];
            $tableList[$title] = $id;
        }
        //var_dump($tableList);
        return $tableList;
    }

    /**
     * Retourne la liste complète des locaux en fonction d'un de l'index passé en paramètre équivalent à l'id de l'établissement(foreign key)
     *
     * @param [type] $indice
     * @return void
     */
    static function getLocalEntry($indice){
        $tableList = array();
        $Qry = "SELECT title FROM local WHERE idestablishment=$indice and isdelete=0";
        //echo $Qry;
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $entry = $row['title'];
            $tableList[] = $entry;
        }
        return $tableList;
    }

    /**
     * Création d'un tree view contenant l'esemble des établissement et des locaux qui leurs sont join
     *
     * @return void
     */
    public  function getLocalTree(){

        $estaTab = $this->getEstaEntry();
        //$localTab = $this->getLocalEntry();
        include("View/LocalTreeView.php");
    }
}