<?php

//Inclusion des dépendances.
require_once("Modele/DbCo.php");
//Defini le nom du fichier qui execute le script afin de cr�e les URL
define ( "FILE", basename ( $_SERVER ['SCRIPT_FILENAME'] ) );
/**
 * Controller principale permet la gestion des différent éléments du site.
 */
class Controller{
    
    private $dbCo;
    private static $origin="";
    private static $destination="";
    private static $pivot="";
    private static $column1="";
    private static $column2="";
    private static $listColumn1="";
    private static $listColumn2="";
    private static $viewPath="";
    private static $form=null;
    private static $menu = Array();
    
    /**
     * Constructeur de la classe, instancie une connection vers la dataBase et lance le réglage des options.
     */
    public function __construct()
    {
        $this->dbCo = new DbCo();
        $this->setMenu();
        $this->setSetting();
    }
    
    // Accèsseurs
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
    private static function getViewPath(){return Controller::$viewPath;}
    private function setViewPath($viewPath){Controller::$viewPath= $viewPath;}
    private static function getListColumn1(){return Controller::$listColumn1;}
    private function setListColumn1($listColumn1){Controller::$listColumn1= $listColumn1;}
    private static function getListColumn2(){return Controller::$listColumn2;}
    private function setListColumn2($listColumn2){Controller::$listColumn2= $listColumn2;}
    private static function setForma($forma){Controller::$form=$forma;}
    
    /**
     * Vérifie existence d'un Get
     * Génère la tableView du formlaire
     *
     * @return void
     */
    public function switchMenu()
    {
        if (isset($_GET["menu"]) and isset($_SESSION['login'])){
            return $this->getTableView($_GET["menu"],Controller::getListColumn1(),Controller::getListColumn2());
        }
    }

    /**
     * Remplissage de l'array menu pour définir les liens du menu principal
     * 
     * exemple:  Controller::$menu["Titre dans le menu"]=["Key dans l'URL'","Value dans l'url'","Page appellée"]; 
     * @return void
     */
    private function setMenu()
    {
        $user = Session::getUser();
        if($user != null and $user->getIsAdmin()==true){
            Controller::$menu["User"]=["menu","user","index"]; 
        }
       Controller::$menu["Department"]=["menu","department","index"];
       Controller::$menu["Ressource"]=["menu","resource","index"];
       Controller::$menu["Local"]=["menu","resource","index"];
       Controller::$menu["Group"]=["menu","sgroup","index"];
       Controller::$menu["Schedule"]=["schedule","true","index"];
    }

    /**
     * Appel de la vue MenuView
     *
     * @return void
     */
    public function getMenu()
    {
        $str="";
        if(isset($_SESSION['login'])){
            include("View/MenuView.php");
        }
        return $str;
    }
    
    /**
     * Envoie des paramètre à setView en fonction du $_GET['menu']
     *
     * @return void
     */
    private function setSetting(){
        if (session_status()==PHP_SESSION_DISABLED)session_start();
        if (!isset($_GET["menu"]))return;
        switch ($_GET["menu"]) {
            
            case $_GET["menu"]=='user' and Session::getUser()!=null and Session::getUser()->getIsAdmin()==true:
                $this->setView("firstname","lastname","user","manage","department","title","code","View/UserView.php");
                break;
            case 'department':
                $this->setView("title","code","department","manage","user","lastName","firstName","View/ReferenceView.php");
                break;
            case 'resource':
                $this->setView("title","code","resource","dispose","local","title","code","View/ReferenceView.php");
                break;
            case 'sgroup':
                $this->setView("title","code","sgroup","linksgroupstudent","student","lastName","firstName","View/ReferenceView.php");
                break;
            case 'student':
                $this->setView("firstname","lastname","student","linksgroupstudent","sgroup","title","code","View/StudentView.php");
                break;
            case 'professor':
                $this->setView("firstname","lastname","professor","request","unavailability","firstday","lastday","View/ProfessorView.php");
                break;
            
            default:
                # code...
                break;
    }
    $this->checkData();
}

/**
 * Gestion de la table pivot d'un formulaire, retire ou ajoute une entrée des item lié à l'objet courant
 * si il y a un GET [remove/add].
 *
 * @return void
 */
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

/**
 * Réglage des différents attibuts nécessaire à la construction des vue en fonction des paramètre envoyé depuis setSettings
 *
 * @param String $listColumn1
 * @param String $listColumn2
 * @param String $origin
 * @param String $pivot
 * @param String $destination
 * @param String $column1
 * @param String $column2
 * @param String $viewPath
 * @return void
 */
private function setView(string $listColumn1,string $listColumn2,string $origin,string $pivot,string $destination,string $column1,string $column2,string $viewPath)
{
    Controller::setListColumn1($listColumn1);
    Controller::setListColumn2($listColumn2);
    Controller::setOrigin($origin);
    Controller::setPivot($pivot);
    Controller::setDestination($destination);
    Controller::setColumn1($column1);
    Controller::setColumn2($column2);
    Controller::setviewPath($viewPath);
}

/**
 * Appel le formulaire via les setting passé dans setSettings
 *
 * @return void
 */
public function setForm(){
    if (isset($_GET["menu"]) and Controller::getviewPath()!=""){
        include(Controller::getviewPath());
        
    }
}

/**
 * Affichage du formulaire pré-défini dans setForm
 *
 * @return void
 */
public function getForm()
{
    $str="";
    if(Controller::$form!=null and isset($_SESSION['login'])){
        $str.= Controller::$form->toString();
        $str.="<div id=gestPivot>";
        $str.= $this->getAssoc();
        $str.= $this->getFreed();
        $str.="</div>";
    }
    return $str;
}

/**
 * Gestion table pivot reprenant les élément qui sont lié entre deux tables
 *
 * @return void
 */
public function getAssoc()
{
    $str="";
    if (isset($_GET["menu"]) and isset($_GET["id"]) and isset($_SESSION['login'])){
        
       $str.= $this->setTableViewAssoc(
        Controller::getOrigin(),
        Controller::getColumn1(),
        Controller::getColumn2(),
        Controller::getDestination(),
        Controller::getPivot(),
        $_GET["id"]);
    }
    return $str;
}

/**
 * Gestion table pivot reprenant les élément qui ne sont pas lié aux deux tables.
 *
 * @return void
 */
public function getFreed()
{
    $str="";
    if (isset($_GET["menu"]) and isset($_GET["id"]) and isset($_SESSION['login'])){
        
        $str.=$this->setTableViewFreed(
        Controller::getOrigin(),
        Controller::getColumn1(),
        Controller::getColumn2(),
        Controller::getDestination(),
        Controller::getPivot(),
        $_GET["id"]);
    }
    return $str;
}

    /**
     * Affichage des entrée d'une table en rapport avec le formulaire appelé
     *
     * @param String $menu
     * @param String $column1
     * @param String $column2
     * @return void
     */
    public function getTableView(String $menu,String $column1,String $column2){
        $str="";
        
        if ($column1!="" and $column2!=""){
            $GEToption = "";
            $title = $menu;
            $crtList = $this->dbCo->getTableViewList($menu,$column1,$column2);
            include("View/TableList.php");
        }
        return $str;
}

    /**
     * Affichage des élément lié à une table
     *
     * @param String $menu
     * @param String $column1
     * @param String $column2
     * @param String $destination
     * @param String $pivot
     * @param int $idItem
     * @return void
     */
    public function setTableViewAssoc(String $menu,String $column1,String $column2,String $destination,String $pivot, int $idItem){
        $str="";
        $GEToption = "assoc";
        $title = $destination." lié";
        $crtList = $this->dbCo->getTableViewAssociate($menu,$column1,$column2,$destination,$pivot,$idItem);
        include("view/TableList.php");
        return $str;
}

    /**
     * Affichage des élément existant mais non lié à la table actuelle
     *
     * @param String $menu
     * @param String $column1
     * @param String $column2
     * @param String $destination
     * @param String $pivot
     * @param int $idItem
     * @return void
     */
    public function setTableViewFreed(String $menu,String $column1,String $column2,String $destination,String $pivot,int $idItem){
        $str="";
        $GEToption = "freed";
        $title = $destination." non lié";
        $crtList = $this->dbCo->getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem);
        include("view/TableList.php");
        return $str;
    }

    function getConnectedUser(){
        $str="";
        include("View/ConnexInfo.php");
        return $str;
    }

}