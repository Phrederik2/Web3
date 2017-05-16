<?php
$str = "<ul>";
//var_dump($estaTab);
//echo "test".$estaTab["Etab2"]; 
//var_dump($localTab);
foreach($estaTab as $key => $value){ 
    $str .= "<li>".$key."</li>";
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