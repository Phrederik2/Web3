<?php
$i = 1;
$str;//="<ul>";
foreach ($calendar as $key => $value) {
    //if($i == 13){$str.=}
    //"<a onclick=\"request(check,'localId={$value}')\" href=\"#\"><li>$key</a></li>";
<<<<<<< HEAD
    $str.="<a onclick=\"request(check,'week=".(time($value->getMon())*1000).")'\" href=\"#schedule\"><li>Sem.$key({$value->getMon()})</li></a>";
=======
    $date = strtotime($value->getMon())*1000;

    $str.="<a onclick=\"request(check,'week=".$date."')\" href=\"#schedule\"><li>Sem.$key({$value->getMon()})</li></a>";
>>>>>>> fc3c6ba3d6006c2a496df0bff3034ce9d5faa0bf
    //echo "<br/>Semaine ".$key." ".$value->getMon();
    
}
//$str.="</ul>";