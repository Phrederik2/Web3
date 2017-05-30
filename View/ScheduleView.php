<?php
include_once("Modele/error.php");
$error = new LogError;
$local= session::getUser()->getLocal();
$firstDay = session::getUser()->getFirstDay();
$activity = session::getUser()->getActivity();

if (!Session::getUser()->getLocal()>0) $error->add("Local","Ne peux etre vide!");
if (!Session::getUser()->getActivity()>0) $error->add("Activity","Ne peux etre vide!");
if (count(Session::getUser()->getListDay())==0) $error->add("Date","Ne peux etre vide!");

$str= "<div id = \"ScheduleTab\">";
$str .= "<div>Date: $firstDay</div><div>Local: $local</div><div>Activitée: $activity</div>";
for($i=0;$i<count($slotList)+1;$i++){

    $str.= "<div class=\"row\">";

    for($j=0;$j<count($dayList)+1;$j++){

        if($j==0 && $i >= 1){
            $str.= "<div class=\"cell\">".$slotList[$i-1]["start"]."</div>";
        }
        else if($i==0 and $j>=1){
            $str.= "<div class=\"cell\">".$dayList[$j-1];
            if (isset($week[$j-1])) $str.= "</br>".$week[$j-1];
            $str.= "</div>";
        }
        else {
            if ($i and $j){
                /**
                 * Création list en session et codage onclick
                 */
                
                 
                 $tmp=array();
                 $tmp["date"]=$week[$j-1];
                 $tmp["slot"]=$slotList[$i-1]["id"];
                 $tmp["item"]=$this->searchActivity($slotList[$i-1]["id"],$week[$j-1]); 
                 $tmp["local"]=session::getUser()->getLocal();
                 $sha1=sha1(serialize($tmp));
                 $this->cells[$sha1]=$tmp;

                 $onclick= "onclick=\"request(check,'cell=".$sha1."')\"";
                $str.= "<div ";
                if(strlen($tmp["item"])==0)$str.=$onclick;
                $str.= " class=\"cell\">".$tmp["item"]."</div>";
            }
            else {
                $str.= "<div class=\"cell\"></div>";
            }
        }
    }
        
    $str.= "</div>";
}



$str.= "</div>";
$this->saveCache();
$str = $error->toString().$str;
