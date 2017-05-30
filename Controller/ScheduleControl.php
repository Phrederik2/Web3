<?php

require_once("Modele/DbCo.php");
/**
 * Class gestion Schedule
 */
class SceduleControl{

    private $dbCo;
    private $data;
    private $cells= array();
    private $cellsItem=array();

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
        $week=Session::getUser()->getListDay();
        include_once("View/ScheduleView.php");
        return $str;
    }

    private function searchActivity($slot,$date)
    {
        $str="";
       foreach ($this->data as $item) {
           $t = str_replace("-","/",$item["DDATE"]);
           if (str_replace("-","/",$item["DDATE"])==$date AND $item["SLOT"]==$slot){
                if (strlen($str)>0)$str.= "</br>";

                $tmp["id"] = $item["ID"];
                $sha1=sha1(serialize($tmp));
                $this->cellsItem[$sha1]=$tmp; 

                $onclick= "onclick=\"request(check,'removeCell=".$sha1."')\"";
                $str.= "<a $onclick href=\"#\">".$item["TITLE"] ." (".$item["CODE"].")</a>";
           }
       }

       return $str;
    }

    public function getCrtSetting(){
        include("View/CrtSettingView.php");
        //return $str;
    }

    public function resumeCache()
    {
        
    }
    public function saveCache()
    {
        $_SESSION["cells"]=serialize($this->cells);
        $_SESSION["cellsItem"]=serialize($this->cellsItem);
    }


}