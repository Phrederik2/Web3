<?php

 if(isset($_SESSION['login'])){
     $user = Session::$user;
    // var_dump($user);
     foreach ($user as $key => $value) {
        echo " $key => $value</br>";
     }
    $str=$user->getFirstName()." ".$user->getLastName();
    if ($user->getIsAdmin()==true)$str.= " Administrator";
    $str.= "<a href=\"". $_SERVER["REQUEST_URI"]."&deco=true\" >Deconnection</a>";
    echo $str;
 }