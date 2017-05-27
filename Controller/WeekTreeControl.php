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
        //echo "</br>Appel de construct</br>";
        $this->today = date("Y-m-d");//récupère la date du jour
        $crtYear = date('Y');
        //echo"<br/>Date Courante: ".$this->today."<br/>Année : ".$crtYear."<br/>";
        $test = date_parse($this->today);
        $this->check1 = new DateTime(); //"2017-01-01";//on définie l'origine début d'année
        $this->check2 = new DateTime();
        $this->check1->setDate($crtYear,1,1);
        $this->check2->setDate($crtYear,8,31);
        //var_dump($this->check1);
        //var_dump($this->check2);
        //echo "check1 :".$this->check1->format('Y-m-d')."</br>check2 :".$this->check2->format('Y-m-d')."</br>";
        //$formatOrigin = strtotime($this->check1);
        //echo "<br/>Num Semaine :".date('W',$formatOrigin)."<br/>";
        //echo "<br/>Jour : ".date('D',$formatOrigin)."<br/>";
        
        $parseCheck1 = date_parse($this->check1->format('Y-m-d'));
        $parseCheck2 = date_parse($this->check2->format('Y-m-d'));
        //Si la date le mois de la date du jour est supérieur à au mois de la date d'origine(1) et inférieur à alors l'origine...
        if($test['month'] > $parseCheck1['month'] and $test['month'] < $parseCheck2['month']){$this->start = ($test['year']-1)."-08-22";/*echo "start :".$this->start;*/}
        //if($test > $this->check1->format('Y-m-d') and $test < $this->check2->format('Y-m-d')){$this->start = ($test['year']-1)."-08-29";echo "start :".$this->start;}
        else{$this->start = ($test['year'])."-08-22";/*echo "start :".$this->start;*/}
        
        //var_dump($this->start);
        $this->startDate = strtotime($this->start);
         $this->startDate = strtotime("next monday",$this->startDate);

        //echo "<br/> startDate: ".date('Y-m-d',$this->startDate)."<br/>";

        //echo "<br/> startDate: ".date('D',$this->startDate)."<br/>";
        //var_dump($this->startDate);
        // echo "next monday: ".date('Y-m-d',strtotime("next monday",$this->startDate));
        
    }
    
    public function getToday(){return $this->today;}
    public function getStartDate(){return $this->startDate;}
    //public function setStartDate($startDate){$this->startDate = $startDate;}
    
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
            $weekList[date('W',$this->startDate)] = $week;//date('Y-m-d',$this->startDate);//$this->start;
            $this->startDate = strtotime("next monday",$this->startDate);
        }
        return $weekList;
    }
    
    public function getWeekList(){
        $str="";
        $calendar = $this->weekListInit();
        include_once("View/WeekView.php");
        return $str;
    }
}