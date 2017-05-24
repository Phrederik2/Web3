<?php
$user= new Session();
$Cells= array();
$str= "<div id = \"ScheduleTab\">";
for($i=0;$i<count($slotList)+1;$i++){

    $str.= "<div class=\"row\">";

    for($j=0;$j<count($dayList)+1;$j++){

        if($j==0 && $i >= 1){
            $str.= "<div class=\"cell\">".$slotList[$i-1]["start"]."</div>";
        }
        else if($i==0 and $j>=1){
            $str.= "<div class=\"cell\">".$dayList[$j-1]."</div>";
        }
        else {
            if ($i and $j){
                /**
                 * Création list en session et codage onclick
                 */
                
                 $tmp=array();
                 $tmp["date"]=Session::getUser()->getFirstDay();
                 $tmp["slot"]=$slotList[$i-1]["id"];
                 $tmp["local"]=session::getUser()->getLocal();
                 $sha1=sha1(serialize($tmp));
                 $Cells[$sha1]=$tmp;

                $str.= "<div onclick=\"request(check,'cell=".$sha1."')\" class=\"cell\">".$this->searchActivity($slotList[$i-1]["id"],$week[$j-1])."</div>";
            }
            else {
                $str.= "<div class=\"cell\"></div>";
            }
        }
    }
        
    $str.= "</div>";
}

$_SESSION["cells"]=serialize($Cells);

$str.= "</div>";
