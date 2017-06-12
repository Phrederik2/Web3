<?php
$i = 1;
$str;//="<ul>";
foreach ($calendar as $key => $value) {
    //if($i == 13){$str.=}
    //"<a onclick=\"request(check,'localId={$value}')\" href=\"#\"><li>$key</a></li>";
    $str.="<a onclick=\"request(check,'week=".(time($value->getMon())*1000).")'\" href=\"#schedule\"><li>Sem.$key({$value->getMon()})</li></a>";
    //echo "<br/>Semaine ".$key." ".$value->getMon();
    
}
//$str.="</ul>";