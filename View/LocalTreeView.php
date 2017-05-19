<?php
$str = "<ul>";
//Pour chaque entrée de la liste estaTab on récupère une clé->valeur 
foreach($estaTab as $key => $value){ 
    $str .= "<li>".$key;
    //On récupère la liste des locaux en rapport avec l'établissement en passent la valeur qui correspond à l'id de l'établissement
    if($localTab = DbCO::getLocalEntry($value)){
        $str.="<ul>";
        foreach($localTab as $key=>$value){
           // <a onclick=\"request('index.php?index={$item[$limit+1]}')\" href=\"#\"><li>$temp[$key]</a>
           $str.="<a onclick=\"request(check,'localId={$value}')\" href=\"#\"><li>$key</a></li>";
        }
        $str.="</ul>";
    }
}
$str .= "</ul></li>";
echo $str;