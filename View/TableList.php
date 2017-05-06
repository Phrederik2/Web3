<?php

$isOptionValid=0;
$tbv = "<nav id=\"test\"><ul>";

foreach($crtList as $crtEntry){
    $item=$crtEntry->getCol1()." ".$crtEntry->getCol2();

    if(isset($GEToption)){
        
        switch ($GEToption) {
            case "assoc":
             $isOptionValid=1;
            if($_GET["id"]==0)break;
                 $tbv .= "<li><a href=".FILE."?menu=".$_GET['menu'].
             "&id={$_GET["id"]}&remove={$crtEntry->getId()}>".$item."</a></li>";
                break;
            
            case "freed":
            $isOptionValid=1;
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

if ($isOptionValid==0){
    $tbv.="<li><a href=".FILE."?menu=".$_GET['menu'].
            "&id=0>"."Add"."</a></li>";
}

$tbv.="</ul></nav>";

echo $tbv;