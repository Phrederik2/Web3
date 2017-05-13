<?php

require_once("Modele/User.php");

/**
* Recupere la session en memoire, ouvre une session au besoin et la ferme si necessaire.
*/
class Session
{
    public static $user;
    
    function __construct()
    {
        if (session_status()!=PHP_SESSION_ACTIVE)session_start();
        
        if(isset($_GET["deco"]) AND $_GET["deco"]==true){
           session_destroy();
        }
        
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

        if(Session::$user == null){
            include("View/LoginView.php");
        }
    }


}