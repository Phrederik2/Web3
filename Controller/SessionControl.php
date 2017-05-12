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

        if (isset($_SESSION['user'])) {
            Session::$user=$_SESSION['user'];
        }
        else {   
            Session::$user = DbCo::getUser("Frederic","Evrard","START123");
        }
    }
}
