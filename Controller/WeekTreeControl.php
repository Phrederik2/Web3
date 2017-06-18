<?php

require_once("Modele/Week.php");

class WeekTreeControl{
    
    //Récupèrer le jour courant en fonction de la date definir date origine avec l'année courante ou précédente
    // puis générer 52 semaines'
    
    private $today;
    private $check1;
    private $check2;
    private $start;
    private $startDate;
    
    function __construct(){
 
        $this->today = date("Y-m-d");//récupère la date du jour
        $crtYear = date('Y');

        $test = date_parse($this->today);
        $this->check1 = new DateTime(); //"2017-01-01";//on définie l'origine début d'année
        $this->check2 = new DateTime();
        $this->check1->setDate($crtYear,1,1);
        $this->check2->setDate($crtYear,8,31);

        
        $parseCheck1 = date_parse($this->check1->format('Y-m-d'));
        $parseCheck2 = date_parse($this->check2->format('Y-m-d'));
        //Si la date le mois de la date du jour est supérieur à au mois de la date d'origine(1) et inférieur à alors l'origine...
        if($test['month'] > $parseCheck1['month'] and $test['month'] < $parseCheck2['month']){$this->start = ($test['year']-1)."-08-22";/*echo "start :".$this->start;*/}
        else{$this->start = ($test['year'])."-08-22";/*echo "start :".$this->start;*/}
        
        $this->startDate = strtotime($this->start);
         $this->startDate = strtotime("next monday",$this->startDate);
    }
    
    public function getToday(){return $this->today;}
    public function getStartDate(){return $this->startDate;}
    
    /**
     * Création de l'année courante sous forme de semaines
     *
     * @return void
     */
    private function weekListInit(){
        $weekList = array();
        for($i=0;$i<52;$i++){
            $week = new Week();
            $week->setMon(date('Y-m-d',$this->startDate));
            $week->setTue(date('Y-m-d',strtotime("+1 day",$this->startDate)));
            $week->setWed(date('Y-m-d',strtotime("+2 day",$this->startDate)));
            $week->setThu(date('Y-m-d',strtotime("+3 day",$this->startDate)));
            $week->setFri(date('Y-m-d',strtotime("+4 day",$this->startDate)));
            $week->setSat(date('Y-m-d',strtotime("+5 day",$this->startDate)));
            $week->setSun(date('Y-m-d',strtotime("+6 day",$this->startDate)));
            $weekList[date('W',$this->startDate)] = $week;
            $this->startDate = strtotime("next monday",$this->startDate);
        }
        return $weekList;
    }
    
    /**
     * Création d'une liste en fonction du tableau de semaines
     *
     * @return void
     */
    public function getWeekList(){
        $str="";
        $calendar = $this->weekListInit();
        include_once("View/WeekView.php");
        return $str;
    }
}