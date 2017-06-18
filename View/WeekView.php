<?php
$i = 1;
$str;//="<ul>";
foreach ($calendar as $key => $value) {
    //if($i == 13){$str.=}
    //"<a onclick=\"request(check,'localId={$value}')\" href=\"#\"><li>$key</a></li>";
    $date = strtotime($value->getMon())*1000;

    $str.="<a onclick=\"request(check,'week=".$date."')\" href=\"#schedule\"><li>Sem.$key({$value->getMon()})</li></a>";
    //echo "<br/>Semaine ".$key." ".$value->getMon();
    
}
//$str.="</ul>";