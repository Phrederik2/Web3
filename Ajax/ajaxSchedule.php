<?php
include_once("Controller/SessionControl.php");
$session = new Session();

if (isset($_POST)){
    
    foreach ($_POST as $key => $value) {
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
            case 'cell':
                DbCo::addToSchedule($value);
                break;
            case 'timestamp':
                 Session::getUser()->setTimestamp($value);
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