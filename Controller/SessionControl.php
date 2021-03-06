<?php
if(!isset($correctionPath)){

    include_once("./Modele/User.php");
    include_once("./Modele/DbCo.php");
}
else {
    include_once("../Modele/User.php");
    include_once("../Modele/DbCo.php");
}

/**
* Recupere la session en memoire, ouvre une session au besoin et la ferme si necessaire.
*/
class Session
{
    public static $user=null;
    
    function __construct()
    {
        $this->checkSession();
        $this->setSession();
       // $this->showSession();
    }
    
    /**
     * Vérifie les status de la session et permet la destruction de celle-ci en cas de get deco
     *
     * @return void
     */
    private function checkSession(){
        if (session_status()!=PHP_SESSION_ACTIVE)session_start();
        
        if(isset($_GET["deco"]) AND $_GET["deco"]==true){
            unset($_SESSION['login']);
            session_destroy();
        }
    }
    
    /**
     * Vérifie l'existence d'une session et set la session en cas de connexion
     *
     * @return void
     */
    private function setSession(){
        if (isset($_SESSION['login'])) {
            Session::$user=unserialize($_SESSION['login']);
        }
        if(isset($_POST['Login'])){
            
            Session::$user = DbCo::getUser($_POST['Login::lastName'], $_POST['Login::firstName'],$_POST['Login::pass']);
            if (Session::$user !=null){
                $_SESSION['login'] = serialize(Session::$user);
            }
            else {
                unset($_SESSION['login']);
            }
        }
    }
    
    /**
     * Affichage du formulaire de connexion si il n' a pas de session
     *
     * @return void
     */
     static function showSession(){
        if(Session::$user == null){
            $str="";
            include("View/LoginView.php");
        }
        
        return $str;
    }

    /**
     * Sauvegarde le user serialiser en session
     *
     * @return void
     */
    static public function saveSession()
    {
          $_SESSION['login'] = serialize(Session::getUser());
    }

    static function getUser(){return Session::$user;}
    function setUser($user){Session::$user= $user;}

}