<?php
include_once("Controller/SessionControl.php");
$session = new Session();

if (isset($_GET)){
    
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'activity':
                Session::getUser()->setActivity($value);
                var_dump( Session::getUser());
                break;
            case 'localId':
                Session::getUser()->setLocal($value);
                 var_dump( Session::getUser());
                break;
            case 'firstDay':
                Session::getUser()->setfirstDay($value);
                 var_dump( Session::getUser());
                break;
            case 'lastDay':
                Session::getUser()->setLastDay($value);
                 var_dump( Session::getUser());
                break;
            case 'cell':
                DbCo::addToSchedule($value);
                break;
            
            default:
                # code...
                break;
    }
}

 include_once("Controller/ScheduleControl.php");
 $schedule = new SceduleControl();
 echo $schedule->getSchedule();

}

$session->saveSession();