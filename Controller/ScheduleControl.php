<?php

require_once("Modele/DbCo.php");
/**
 * Class gestion Schedule
 */
class SceduleControl{

    private $dbCo;

    public function __construct(){
        $this->dbCo = new DbCo();
    }
    
    
    /**
     * Affichage du Schedule généré en fonction des deux liste récupèrer
     *
     * @return void
     */
    public function getSchedule(){
        $slotList = $this->dbCo->getSlot();
        $dayList = $this->dbCo->getDay();
        include_once("View/ScheduleView.php");
    }
}