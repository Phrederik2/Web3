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

    /**
     * Effectue un move de jours
     * passe en agument $day = 01/02/2017
     * demande un move ($shifting) de +1 retournera le 02/02/2017
     * demande un move de -1 retournera 31/01/2017
     * 
     * le format de sortie peux etre modifier mais est placé par defaut sur un format "européen"
     *
     * @param string $day
     * @param int $shifting
     * @param string $format
     * @return string
     */
    static function moveDay($day,$shifting,$format ="Y/m/d")
    {
        return date($format,(mktime(0, 0, 0, date("m",strtotime($day))  , date("d",strtotime($day))+$shifting, date("Y",strtotime($day)))));
    }
}
