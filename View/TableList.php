<?php

$tbv = "<nav class=\"tableView\"><ul>";

if ($GEToption==""){
    $tbv.="<li><a href=".FILE."?menu=".$_GET['menu'].
            "&id=0>"."Add"."</a></li>";
}

foreach($crtList as $crtEntry){
    $item=$crtEntry->getCol1()." - ".$crtEntry->getCol2();

    if(isset($GEToption)){
        
        switch ($GEToption) {
            case "assoc":
            if($_GET["id"]==0)break;
                 $tbv .= "<li><a href=".FILE."?menu=".$_GET['menu'].
             "&id={$_GET["id"]}&remove={$crtEntry->getId()}>".$item."</a></li>";
                break;
            
            case "freed":
            if($_GET["id"]==0)break;            
                 $tbv .= "<li><a href=".FILE."?menu=".$_GET['menu'].
            "&id={$_GET["id"]}&add={$crtEntry->getId()}>".$item."</a></li>";
                break;
            
            default:
                $tbv .= "<li><a href=".FILE."?menu=".$_GET['menu'].
            "&id={$crtEntry->getId()}>".$item."</a></li>";
            break;  
    }
}
}

$tbv.="</ul></nav>";

echo $tbv;