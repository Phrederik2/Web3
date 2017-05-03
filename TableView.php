<?php
class TableView{
    /**
     * test
     * test phred//
     */

    protected $id;
    protected $col1;
    protected $col2;

    function __construct(){
        $this->setId(0);
        $this->setCol1("null");
        $this->setCol2("null");
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