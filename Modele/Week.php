<?php
class Week{
    
    private $mon;
    private $tue;
    private $wed;
    private $thu;
    private $fri;
    private $sat;
    private $sun;
    
    function __construt($mon, $tue, $wed, $thu, $fri, $sat, $sun){
        $this->setMon($mon);
        $this->setTue($tue);
        $this->setWed($wed);
        $this->setThu($thu);
        $this->setFri($fri);
        $this->setSat($mon);
        $this->setSun($mon);
    }
    
    function getMon(){return $this->mon;}
    function getTue(){return $this->tue;}
    function getWed(){return $this->wed;}
    function getThu(){return $this->thu;}
    function getFri(){return $this->fri;}
    function getSat(){return $this->sat;}
    function getSun(){return $this->sun;}
    
    function setMon($mon){$this->mon = $mon;}
    function setTue($tue){$this->tue = $tue;}
    function setWed($wed){$this->wed = $wed;}
    function setThu($thu){$this->thu = $thu;}
    function setFri($fri){$this->fri = $fri;}
    function setSat($sat){$this->sat = $sat;}
    function setSun($sun){$this->sun = $sun;}
    
    
}