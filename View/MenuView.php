<?php
$str="<ul id=\"menuPrin\">";
foreach (Controller::$menu as $key => $value) {
    $str.="<li><a href=".FILE."?menu=$value>$key</a></li>";
}
$str.="</ul>";
echo $str;