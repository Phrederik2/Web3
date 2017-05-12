<?php

 if(isset($_SESSION['login'])){
     var_dump($_SESSION['login']);
     $user = $_SESSION['login'];
    //echo $user->getLastName();//." ".$_SESSION['User::FirstName']." Connecté";
 }