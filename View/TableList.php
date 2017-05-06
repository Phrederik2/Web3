<?php

$tbv = "<nav id=\"test\"><ul>";

foreach($crtList as $crtEntry){
    
    if(!isset($_GET['menu'])){
        $_GET['menu'] = "user";
    }
    
    if(isset($pivot)){
        
        switch ($pivot) {
            case 'assoc':
                 $tbv .= "<li><a href=[FILE]?menu=".$_GET['menu'].
            "&id={$crtEntry->getId()}&remove=true>";
                break;
            
            case 'freed':
                 $tbv .= "<li><a href=[FILE]?menu=".$_GET['menu'].
            "&id={$crtEntry->getId()}&add=true>";
                break;
            
            default:
                $tbv .= "<li><a href=[FILE]?menu=".$_GET['menu'].
            "&id={$crtEntry->getId()}>";
            break;  
    }
    $tbv.="{$crtEntry->getCol1()} {$crtEntry->getCol2()}</a></li>";
}
}

$tbv.="</ul></nav>";

echo $tbv;