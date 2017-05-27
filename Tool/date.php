<?php

/**
 * 
 */
class DateTool 
{
    
    function __construct()
    {
        # code...
    }

    static function moveDay($day,$shifting,$format ="Y/m/d")
    {
        return date($format,(mktime(0, 0, 0, date("m",strtotime($day))  , date("d",strtotime($day))+$shifting, date("Y",strtotime($day)))));
    }
}
