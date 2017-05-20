<?php
class WeekTreeControl{

//Récupèrer le jour courant en fonction de la date definir date origine avec l'année courante ou précédente
// puis générer 52 semaines'

private $today;
private $origin;
public $start;

    function __construct(){
        echo "</br>Appel de construct</br>";
        $this->today = date("Y-m-d");
        $test = date_parse($this->today);
        $this->origin = "2017-01-01";
        $parseOrigin = date_parse($this->origin);
        if($test['month'] > $parseOrigin['month']){$this->start = ($test['year']-1)."-08-29";echo $this->start;}
        else{$this->start = ($test['year'])."-08-29";echo $this->start;}
    }

    public function getToday(){return $this->today;}

}