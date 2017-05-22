<?php

 if(isset($_SESSION['login'])){
    $user = Session::$user;
    
    $str=$user->getFirstName()." ".$user->getLastName();
    if ($user->getIsAdmin()==true)$str.= " Administrator";
    $str.= "<a href=\"". FILE ."?deco=true\" >Deconnection</a>";
 }