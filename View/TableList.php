<?php
//$tbv ="<table><th>List of user</th>";
$tbv = "<nav id=\"test\"><ul>";
foreach($crtList as $crtEntry){
    if(!isset($_GET['menu'])){
        $_GET['menu'] = "user";
    }
    //$tbv .= "</td><td><a href=index.php?editUser=true&idUser={$crtEntry->getId()}&colonne1=".urlencode($crtEntry->getCol1())."&colonne2=".urlencode($crtEntry->getCol2()).">{$crtEntry->getCol1()} {$crtEntry->getCol2()}</a></td></tr>";
    $tbv .= "<li><a href=index.php?menu=".$_GET['menu'].
    "&idUser={$crtEntry->getId()}&colonne1=".$_GET['colonne1'].
    "&colonne2=".$_GET['colonne2'].
    ">{$crtEntry->getCol1()} {$crtEntry->getCol2()}</a></li>";

}
$tbv.="</ul></nav>";

echo $tbv;