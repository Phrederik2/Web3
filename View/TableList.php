<?php

$tbv = "<nav id=\"test\"><ul>";
foreach($crtList as $crtEntry){
    if(!isset($_GET['menu'])){
        $_GET['menu'] = "user";
    }

$tbv .= "<li><a href=index.php?menu=".$_GET['menu'].
"&id={$crtEntry->getId()}>{$crtEntry->getCol1()} {$crtEntry->getCol2()}</a></li>";

}
$tbv.="</ul></nav>";

echo $tbv;