<?php

class SceduleControl{
    
    private function getSlot(){
        $slotList = array();
        $Qry = "SELECT start FROM slot WHERE isdelete=0";
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $start = $row['start'];
            
            $slotList[] = $start;
        }
        //var_dump($tableList);
        return $slotList;
    }
    
    public function getSchedule(){
        $slotList = $this->getSlot();
        include_once("View/ScheduleView.php");
    }
}