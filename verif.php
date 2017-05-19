<?php
include_once("Controller/SessionControl.php");
$session = new Session();

if (isset($_GET)){

    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'activity':
               Session::getUser()->setActivity($value);
                break;
            case 'localId':
               Session::getUser()->setLocal($value);
                break;
            
            default:
                # code...
                break;
        }
    }

  var_dump(Session::getUser());
    
}

$session->saveSession();