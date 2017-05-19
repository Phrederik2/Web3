<?php
class WeekTreeControl{

//Récupèrer le jour courant en fonction de la date definir date origine avec l'année courante ou précédente
// puis générer 52 semaines'

private $today;
private $origin;

    function __construct(){
        //echo "Appel de construct";
        $this->today = "patate";//date("Y-m-d");
        echo $this->today;
    }

    public function getToday(){return $this->today;}

}