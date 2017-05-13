<?php

require_once("Modele/User.php");
require_once("Modele/TableView.php");

/**
* Class connexion db
*/
class DbCo
{
    //Paramètrage des valeur pour connexion
    private static $localhost = "localhost";
    private static $user = "user";
    private static $password = "bachelier";
    private static $db = "projetintegration";
    public static $pdo=null;
    
    public function __construct()
    {
       DbCo::init();
    }

    static function init()
    {
        DbCo::$localhost="localhost";
        DbCo::$user="user";
        DbCo::$password="bachelier";
        DbCo::$db="projetintegration";
        if(DbCo::$pdo==null)
        try
        {
            //Utilisation d'une connexion pdo
            DbCo::$pdo = new PDO("mysql:host=".DbCo::$localhost.";dbname=".DbCo::$db,DbCo::$user,DbCo::$password);
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
    
    public static function getPDO(){
        if (DbCo::$pdo==null) {
            DbCo::init();
        }
        return DbCo::$pdo;
    }
    
    /**
    * Retourne les informations de l'utilisateur
    *
    * @param [type] $login
    * @param [type] $password
    * @return false or $user
    */
    static function getUser($lastName,$firstName,$password)
    {
        $Qry = "SELECT id,firstname,lastname,isadmin FROM user WHERE firstname='{$firstName}' AND lastname='{$lastName}' AND password = '{$password}' AND isdelete=0";
        $statement = DbCo::getPDO()->query($Qry);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($row == false)
        {
            return null;
        }
        
        else
        {
            $user = new User($row['id'],$row['firstname'],$row['lastname'],$row['isadmin']);
            return $user;
        }
    }
  
    function getTableViewList($table,$col1,$col2){
        $tableList = array();
        
        $Qry = "select id,{$col1},{$col2} from {$table} WHERE IsDelete=0";
        echo $Qry;

        $statement = DbCo::$pdo->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {

            $entry = new TableView();
            $entry->setId($row['id']);
            $entry->setCol1($row[$col1]);
            $entry->setCol2($row[$col2]);
             
            $tableList[] = $entry;
        }
        
        return $tableList;
    }
    
    function getTableViewFreed($table,$col1,$col2,$destination,$pivot,$idItem){
        $tableList = array();
        
        $Qry = "SELECT $destination.ID, $destination.$col1, $destination.$col2 FROM $destination WHERE  $destination.ID NOT IN (SELECT $destination FROM $pivot WHERE $table=$idItem)   AND $destination.IsDelete=0";
        //echo $Qry;
        $statement = DbCo::$pdo->query($Qry);

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {

                $entry = new TableView();
                $entry->setId($row['ID']);
                $entry->setCol1($row[$col1]);
                $entry->setCol2($row[$col2]);
                     
                $tableList[] = $entry;
            }
 
        return $tableList;
    }
    
    function getTableViewAssociate($table,$col1,$col2,$destination,$pivot,$idItem){
        $tableList = array();
        
        $Qry = "SELECT $destination.ID, $destination.$col1, $destination.$col2 FROM $destination JOIN $pivot ON $destination.ID=$pivot.$destination WHERE $pivot.$table = $idItem AND $destination.IsDelete=0";
        //echo $Qry;
        $statement = DbCo::$pdo->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $entry = new TableView();
            $entry->setId($row['ID']);
            $entry->setCol1($row[$col1]);
            $entry->setCol2($row[$col2]);
            
            
            $tableList[] = $entry;
        }
        
        return $tableList;
    }

    function removePivot($origine,$pivot,$destination,$idParent,$idChild)
    {
        $Qry = "DELETE FROM $pivot WHERE $origine=$idParent and $destination=$idChild";
        //echo $Qry;
        $statement = DbCo::$pdo->query($Qry);
    }

     function addToPivot($origine,$pivot,$destination,$idParent,$idChild)
    {
        $Qry = "INSERT INTO $pivot ($origine,$destination) VALUES ($idParent, $idChild)";
        //echo $Qry;
        $statement = DbCo::$pdo->query($Qry);
    }
    
    
}