<?php

/**
 * Class gestion Schedule
 */
class SceduleControl{
    
    /**
     * Retourne une liste des slots encodés
     *
     * @return void
     */
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

    /**
     * Retourne une liste des jour encodés
     *
     * @return void
     */
    private function getDay(){
        $dayList = array();
        $Qry = "SELECT title FROM day WHERE isdelete=0";
        $statement = DbCo::getPDO()->query($Qry);
        
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $title = $row['title'];
            
            $dayList[] = $title;
        }
        //var_dump($tableList);
        return $dayList;
    }
    
    /**
     * Affichage du Schedule généré en fonction des deux liste récupèrer
     *
     * @return void
     */
    public function getSchedule(){
        $slotList = $this->getSlot();
        $dayList = $this->getDay();
        include_once("View/ScheduleView.php");
    }
}