<?php
class TableView{

    protected $id=0;
    protected $col1=null;
    protected $col2=null;

    function __construct(){
        
    }

    function getId(){
        return $this->id;
    }
    function getCol1(){
        return $this->col1;
    }
    function getCol2(){
        return $this->col2;
    }

    function setId($id){
        $this->id = $id;
    }
    function setCol1($col1){
        $this->col1 = $col1;
    }
    function setCol2($col2){
        $this->col2 = $col2;
    }
}