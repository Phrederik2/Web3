<?php

class AjaxControl  
{
    public function __construct()
    {
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
                case 'cell':
                    DbCo::addToSchedule($value);
                    break;
                case 'removeCell':
                    DbCo::removeToSchedule($value);
                    break;
                case $key == 'timestamp' or $key == 'week':
                    Session::getUser()->setTimestamp($value);
                    break;
                
                
                default:
                    # code...
                    break;
        }
}

 include_once("Controller/ScheduleControl.php");
 $schedule = new SceduleControl();
 $str= $schedule->getSchedule();
 echo $str;

}

$session->saveSession();
    }
}


