<?php

require_once("Modele/User.php");

/**
* Recupere la session en memoire, ouvre une session au besoin et la ferme si necessaire.
*/
class Session
{
    private static $user;
    
    function __construct()
    {
        if (session_status()==PHP_SESSION_DISABLED)session_start();
        //var_dump($_SESSION);
        
        if (isset($_SESSION['login'])) {
            Session::$user=$_SESSION['login'];
        }
        else {
            include("View/LoginView.php");
            if(isset($_POST['Login'])){
                
                Session::$user = DbCo::getUser($_POST['Login::lastName'], $_POST['Login::firstName'],$_POST['Login::pass']);

                $_SESSION['login'] = Session::$user;
            }
        }
    }
}