<?php

require_once("Modele/DbCo.php");
/**
 * Class gestion Schedule
 */
class SceduleControl{

    private $dbCo;
    private $data;

    public function __construct(){
        $this->dbCo = new DbCo();
        $this->data = DbCo::getCellPlanning();

    }


    
    
    /**
     * Affichage du Schedule généré en fonction des deux liste récupèrer
     *
     * @return void
     */
    public function getSchedule(){
        $str="";
        $slotList = $this->dbCo->getSlot();
        $dayList = $this->dbCo->getDay();
        $week=["2017-04-17","2017-04-18","2017-04-19","2017-04-20","2017-04-21"];
        include_once("View/ScheduleView.php");
        return $str;
    }

    private function searchActivity($slot,$date)
    {
        $str="";
       foreach ($this->data as $item) {
           if ($item["DDATE"]==$date AND $item["SLOT"]==$slot){
               if (strlen($str)>0)$str.= "</br>";
               $str.= "<a href\"#\">".$item["TITLE"] ." (".$item["CODE"].")</a>";
           }
       }

       return $str;
    }

}