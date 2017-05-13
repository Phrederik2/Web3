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
            $this->getTableView($_GET["menu"],Controller::getListColumn1(),Controller::getListColumn2());
        }
    }

    /**
     * Remplissage de l'array menu pour définir les liens du menu principal
     *
     * @return void
     */
    private function setMenu()
    {
       Controller::$menu["User"]="user"; 
       Controller::$menu["Department"]="department";
    }

    /**
     * Appel de la vue MenuView
     *
     * @return void
     */
    public function getMenu()
    {
        if(isset($_SESSION['login']))
            include("View/MenuView.php");
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
    if (isset($_GET["menu"])){
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
    if(Controller::$form!=null and isset($_SESSION['login'])){
        echo Controller::$form->toString();
        echo"<div id=gestPivot>";
        $this->getAssoc();
        $this->getFreed();
        echo"</div>";
    }
}

/**
 * Gestion table pivot reprenant les élément qui sont lié entre deux tables
 *
 * @return void
 */
public function getAssoc()
{
    if (isset($_GET["menu"]) and isset($_GET["id"]) and isset($_SESSION['login'])){
        
        $this->setTableViewAssoc(
        Controller::getOrigin(),
        Controller::getColumn1(),
        Controller::getColumn2(),
        Controller::getDestination(),
        Controller::getPivot(),
        $_GET["id"]);
    }
}

/**
 * Gestion table pivot reprenant les élément qui ne sont pas lié aux deux tables.
 *
 * @return void
 */
public function getFreed()
{
    if (isset($_GET["menu"]) and isset($_GET["id"]) and isset($_SESSION['login'])){
        
        $this->setTableViewFreed(
        Controller::getOrigin(),
        Controller::getColumn1(),
        Controller::getColumn2(),
        Controller::getDestination(),
        Controller::getPivot(),
        $_GET["id"]);
    }
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
    $GEToption = "";
    $title = $menu;
    $crtList = $this->dbCo->getTableViewList($menu,$column1,$column2);
    include("view/TableList.php");
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
    $GEToption = "assoc";
    $title = $destination." lié";
    $crtList = $this->dbCo->getTableViewAssociate($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
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
    $GEToption = "freed";
    $title = $destination." non lié";
    $crtList = $this->dbCo->getTableViewFreed($menu,$column1,$column2,$destination,$pivot,$idItem);
    include("view/TableList.php");
}

function getConnectedUser(){
    include("View/ConnexInfo.php");
}

function getTabletest(){
    echo "<div id = \"SceduleTab\">";
    for($i=0;$i<5;$i++){
        echo "<div class=\"row\">";
        for($j=0;$j<5;$j++){
            echo "<div class=\"cell\">content</div>";
        }
        echo "</div>";
    }
    echo "</div>";
}
}