<?php

if(!isset($correctionPath)){

    require_once("./Modele/User.php");
    require_once("./Modele/TableView.php");
}
else {
    require_once("../Modele/User.php");
    require_once("../Modele/TableView.php");
}

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
    
    /**
    * Initialisation des valeur pour la connexion et création de la connexion
    *
    * @return void
    */
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
    
    /**
    * Retourne l'ensemble des entrée nécessaire à la création des tableView
    *
    * @param String $table
    * @param String $col1
    * @param String $col2
    * @return void
    */
    function getTableViewList(String $table,String $col1,String $col2){
        $tableList = array();
        
        $Qry = "select id,{$col1},{$col2} from {$table} WHERE IsDelete=0";
        //echo $Qry;
        
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
    
    /**
    * Retourne la liste des entrée non lié à l'entrée en cours d'utilisation dans un formulaire
    *
    * @param String $table
    * @param String $col1
    * @param String $col2
    * @param String $destination
    * @param String $pivot
    * @param int $idItem
    * @return void
    */
    function getTableViewFreed(String $table,String $col1,String $col2,String $destination,String $pivot, int $idItem){
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
    
    
    /**
    * Retourne la liste des entrée lié à l'entrée en cours d'utilisation dans un formulaire
    *
    * @param String $table
    * @param String $col1
    * @param String $col2
    * @param String $destination
    * @param String $pivot
    * @param int $idItem
    * @return void
    */
    function getTableViewAssociate(String $table,String $col1,String $col2,String $destination,String $pivot,int $idItem){
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
    
    /**
    * Retire entrée de la table pivot
    *
    * @param String $origine
    * @param String $pivot
    * @param String $destination
    * @param int $idParent
    * @param int $idChild
    * @return void
    */
    function removePivot(String $origine,String $pivot,String $destination,int $idParent,int $idChild)
    {
        $Qry = "DELETE FROM $pivot WHERE $origine=$idParent and $destination=$idChild";
        //echo $Qry;
        $statement = DbCo::$pdo->query($Qry);
    }
    
    /**
    * Ajoute entrée dans table pivot
    *
    * @param String $origine
    * @param String $pivot
    * @param String $destination
    * @param int $idParent
    * @param int $idChild
    * @return void
    */
    function addToPivot(String $origine,String $pivot,String $destination,int $idParent,int $idChild)
    {
        $Qry = "INSERT INTO $pivot ($origine,$destination) VALUES ($idParent, $idChild)";
        //echo $Qry;
        $statement = DbCo::$pdo->query($Qry);
    }
    
    /**
    * Retourne une liste des slots encodés
    *
    * @return void
    */
    function getSlot(){
        $slotList = array();
        $Qry = "SELECT start,end,id FROM slot WHERE isdelete=0";
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $tmp=null;
            foreach ($row as $key => $value) {
                $tmp[$key]=$value;
            }
            array_push($slotList,$tmp);
        }
        //var_dump($tableList);
        return $slotList;
    }
    
    /**
    * Retourne une liste des jour encodés
    *
    * @return void
    */
    function getDay(){
        $dayList = array();
        $Qry = "SELECT title FROM day WHERE isdelete=0";
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $title = $row['title'];
            
            $dayList[] = $title;
        }
        //var_dump($tableList);
        return $dayList;
    }
    
    /**
     * Retourne la liste complète des établissement
     *
     * @return void
     */
    function getEstaEntry(){
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
        $Qry = "SELECT title,id FROM local WHERE idestablishment=$indice and isdelete=0";
        //echo $Qry;
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $title = $row['title'];
            $id = $row['id'];
            $tableList[$title] = $id;
        }
        return $tableList;
    }

   /**
    * Envoi de la requete de création de l'arbre et renvoi le tableau correspondant
    *
    * @return void
    */
   static function getActivityTree()
    {
        $data=Array();
        $query = 
        '
        select department.TITLE department, curriculum.TITLE curriculum, teachingunit.TITLE teachingunit, activityunit.TITLE activityunit, subactivityunit.TITLE subactivityunit, subactivityunit.ID ID from department 
        join contain on department.ID=contain.DEPARTMENT
        join curriculum on contain.CURRICULUM=curriculum.ID 
        join contain2 on curriculum.ID=contain2.Curriculum
        join teachingunit on contain2.TeachingUnit=teachingunit.ID
        join contain3 on teachingunit.ID=contain3.TEACHINGUNIT
        join activityunit on contain3.ACTIVITYUNIT=activityunit.ID
        join compose on activityunit.ID=compose.ActivityUnit
        join subactivityunit on compose.SubActivityUnit=subactivityunit.id

        where department.ISDELETE=0 and curriculum.ISDELETE=0 and teachingunit.ISDELETE=0 and activityunit.ISDELETE=0 and subactivityunit.ISDELETE=0
        '
        ;
        $statement = DbCo::getPDO()->query($query);
        while($item = $statement->fetch(PDO::FETCH_NUM)){
            array_push($data,$item);
        }

        return $data;
    }

    /**
     * recupere les cellules par rapport au donnée de l'utilisateur en session   
     * retourne le tableau de données
     * 
     * @return void
     */
    static function getCellPlanning()
    {
        $user = Session::getUser();
        
        //simulation
        //$user->setLocal(1);
        //$user->setWeek(["2017-04-17","2017-04-23"]);

        $local = $user->getLocal();
        //$dateStart = $user->getWeek()[0];
        $dateStart = $user->getfirstDay();
        //$dateEnd = $user->getWeek()[1];
        $dateEnd = $user->getlastDay();
        $data=Array();
        $query = 
        '
        SELECT subactivityunit.*, planning.* from planning  
        join subactivityunit on planning.ACTIVITY=subactivityunit.ID  
        join local on planning.LOCAL=local.ID 
        join slot on planning.SLOT=slot.ID 
        WHERE planning.local = '."'$local'".' and planning.DDATE between '."'$dateStart'".' and '."'$dateEnd'".' AND planning.isdelete=0
        '
        ;
        //echo $query;
        $statement = DbCo::getPDO()->query($query);
        while($item = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($data,$item);
        }

        return $data;
    }
}