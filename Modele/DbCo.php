<?php

require_once("Modele/User.php");
require_once("Modele/TableView.php");

/**
* Class connexion db
*/
class DbCo
{
    //Paramètrage des valeur pour connexion
    private $localhost = "localhost";
    private $user = "root";
    private $password = "bachelier";
    private $db = "projetintegration";
    private static $pdo;
    
    public function __construct()
    {
        try
        {
            //Utilisation d'une connexion pdo
            DbCo::$pdo = new PDO("mysql:host={$this->localhost};dbname=".$this->db,$this->user,$this->password);      
        } 
        catch(Exception $e)   
        {      
            die('Erreur : '.$e->getMessage());       
        }
    }
    
    static function getPDO(){
        return DbCo::$pdo;
    }
    
    /**
    * Retourne les informations de l'utilisateur
    *
    * @param [type] $login
    * @param [type] $password
    * @return false or $user
    */
    function getUser($login,$password)
    {
        $user = new User();
        $getUserQry = "select * from sauser where login='{$login}' and password = '{$password}' and deleted=0";
        $statement = DbCo::$pdo->query($getUserQry);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($row == false)
        {
            return false;
        }
        
        else
        {
            $user->setIdUser($row['idUser']);
            $user->setLogin($row['login']);
            //$user->setPassword($row['password']);
            $user->setLevel($row['level']);
            //$user->
            
            return $user;
        }
    }
    
    /**
    * Retourne la liste complète des utilisateur inscrit
    *
    * @return tableau d'objet $user'
    */
    function getUserList()
    {
        $userList = array();
        
        $getUserQry = "select * from user";
        $statement = DbCo::$pdo->query($getUserQry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $user = new User($row["ID"],$row["ISADMIN"],$row["ISCHANGE"],$row["ISDELETE"],$row["LASTNAME"],$row["FIRSTNAME"],$row["PASSWORD"]);
           /*$user->setId($row['idUser']);
            //$user->setLogin($row['login']);
            $user->setlastName($row['lastName']);
            $user->setfirstName($row['firstName']);
            $user->setPassword($row['password']);
            $user->setIsAdmin($row['isAdmin']);
            $user->setIsChange($row['isChange']);
            $user->setDeleted($row['isDeleted']);*/
            
            
            $userList[] = $user;
        }
        
        return $userList;
    }
    
    /**
    * Ajout d'utlisateur dans la db'
    *
    * @param [type] $user
    * @return void
    */
    function addUser($user)
    {
        $addUserQry = "insert into sauser values (null,'{$user->getlogin()}','{$user->getPassword()}',0,0)";
        $statement = DbCo::$pdo->query($addUserQry);
        var_dump($addUserQry);
    }
    
    /**
    * Modification utilisateur dans la db
    *
    * @param [type] $user
    * @return void
    */
    function editUser($user)
    {
        // try
        // {
            $editUserQry = "update sauser set login='{$user->getlogin()}',level={$user->getLevel()},deleted={$user->getDeleted()} where idUser={$user->getIdUser()}";
            $statement = DbCo::$pdo->query($editUserQry);
        //}
        // catch(Exception $e)
        // {
           // echo('Erreur : '.$e->getMessage());
            //return;
        //}
        //var_dump($editUserQry);
    }

    function getTableViewList($table,$col1,$col2){
         $tableList = array();
        
        $Qry = "select id,{$col1},{$col2} from {$table}";
        echo $Qry;
        $statement = DbCo::$pdo->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $entry = new TableView();
           /*$user->setId($row['idUser']);
            //$user->setLogin($row['login']);
            $user->setlastName($row['lastName']);
            $user->setfirstName($row['firstName']);
            $user->setPassword($row['password']);
            $user->setIsAdmin($row['isAdmin']);
            $user->setIsChange($row['isChange']);
            $user->setDeleted($row['isDeleted']);*/
            $entry->setId($row['id']);
            $entry->setCol1($row[$col1]);
            $entry->setCol2($row[$col2]);
            
            
            $tableList[] = $entry;
        }
        
        return $tableList;
    }
}