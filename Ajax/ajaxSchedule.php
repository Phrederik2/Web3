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
            case 'firstDay':
                Session::getUser()->setfirstDay($value);
                break;
            case 'lastDay':
                Session::getUser()->setLastDay($value);
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