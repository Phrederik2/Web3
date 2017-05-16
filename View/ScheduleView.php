<?php
$dayTab = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi");
var_dump($dayTab);
$str= "<div id = \"ScheduleTab\">";
for($i=0;$i<count($slotList)+1;$i++){
    //echo "compte ".count($slotList);
    $str.= "<div class=\"row\">";
    for($j=0;$j<6;$j++){
        if($j==0 && $i >= 1){
        //var_dump($slotList[$i]);
        $str.= "<div class=\"cell\">".$slotList[$i-1]."</div>";
        }
        else if($i==0 and $j>=1){
        $str.= "<div class=\"cell\">".$dayTab[$i]."</div>";
        }
        else $str.= "<div class=\"cell\">-------</div>";
        }
    $str.= "</div>";
}

$str.= "</div>";

echo $str;