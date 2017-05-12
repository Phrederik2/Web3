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
        
        if (isset($_SESSION['login'])) {
            Session::$user=$_SESSION['login'];
        }
        else {
            include("View/LoginView.php");
            if(isset($_POST)){
                
                Session::$user = DbCo::getUser($_POST['login::LastName'], $_POST['login::firstName'],$_POST['login::password']);

                $_SESSION['lastName'] = $user->getLastName();
                $_SESSION['firstName'] = $user->getFirstName();
            }
        }
    }
}