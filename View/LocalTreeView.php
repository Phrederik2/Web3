<?php
$str = "<ul>";
//Pour chaque entrée de la liste estaTab on récupère une clé->valeur 
foreach($estaTab as $key => $value){ 
    $str .= "<li>".$key."</li>";
    //On récupère la liste des locaux en rapport avec l'établissement en passent la valeur qui correspond à l'id de l'établissement
    if($localTab = LocalTree::getLocalEntry($value)){
        $str.="<ul>";
        foreach($localTab as $crtEntry){
           $str.="<li>".$crtEntry."</li>";
        }
        $str.="</ul>";
    }
}
$str .= "</ul>";
echo $str;