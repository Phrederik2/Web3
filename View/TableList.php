<?php

$tbv = "<nav id=\"test\"><ul>";

foreach($crtList as $crtEntry){
    
    $item=$crtEntry->getCol1()." ".$crtEntry->getCol2();

    if(isset($GEToption)){
        
        switch ($GEToption) {
            case "assoc":
                 $tbv .= "<li><a href=".FILE."?menu=".$_GET['menu'].
            "&id={$crtEntry->getId()}&remove=true>".$item."</a></li>";
                break;
            
            case "freed":
                 $tbv .= "<li><a href=".FILE."?menu=".$_GET['menu'].
            "&id={$crtEntry->getId()}&add=true>".$item."</a></li>";
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