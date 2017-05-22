<?php
$str="<ul id=\"menuPrin\">";
foreach (Controller::$menu as $key => $value) {
    $str.="<li><a href=$value[2].php";
    if (strlen($value[0])) $str.= "?$value[0]=$value[1]";
    $str.= ">$key</a></li>";
}
$str.="</ul>";
