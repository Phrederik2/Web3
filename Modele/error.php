<?php

/**
 * 
 */
class LogError 
{
    private $list=array();
    
    function __construct()
    {

    }
    
    public function add($title,$message)
    {
        $tmp["title"]=$title;
        $tmp["message"]=$message;
        array_push($this->list,$tmp);
    }

    public function toString()
    {
        $str="";
        if (count($this->list)>0){

            $str.="<div class=\"LogError\"";
            $str.= count($this->list)." error(s)</br>";
            foreach ($this->list as $item) {
                $str.="[".$item["title"]."] ".$item["message"]."</br>";
            }
        }
        $str.= "</div>";
        return $str;
    }
}
