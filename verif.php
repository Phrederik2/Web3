<?php
include_once("Controller/SessionControl.php");
$session = new Session();

if (isset($_GET["activity"])){
  
  Session::getUser()->setActivity($_GET["activity"]);
  var_dump(Session::getUser());

    
}

$session->saveSession();