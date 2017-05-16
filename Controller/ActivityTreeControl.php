<?php

/**
 * 
 */
class ActivityTree 
{
    private $dbco;
    
    function __construct()
    {
        $this->dbco = DbCo::getPDO();
    }

    function getData(){

        $query = 
        '
        select department.TITLE department, curriculum.TITLE curriculum, teachingunit.TITLE teachingunit, activityunit.TITLE activityunit, subactivityunit.TITLE subactivityunit, subactivityunit.ID ID from department 
        join contain on department.ID=contain.DEPARTMENT
        join curriculum on contain.CURRICULUM=curriculum.ID 
        join contain2 on curriculum.ID=contain2.Curriculum
        join teachingunit on contain2.TeachingUnit=teachingunit.ID
        join contain3 on teachingunit.ID=contain3.TEACHINGUNIT
        join activityunit on contain3.ACTIVITYUNIT=activityunit.ID
        join compose on activityunit.ID=compose.ActivityUnit
        join subactivityunit on compose.SubActivityUnit=subactivityunit.id

        where department.ISDELETE=0 and curriculum.ISDELETE=0 and teachingunit.ISDELETE=0 and activityunit.ISDELETE=0 and subactivityunit.ISDELETE=0
        '
        ;

        $statement = $this->dbco->query($query);

        $retrait = 1;
        $limit=null;
        $tree = array();
        $temp=null;
        $level=-1;

        while($row = $statement->fetch(PDO::FETCH_NUM)){
            if ($temp==null){
                $temp=array();
                $limit=count($row)-1-$retrait;
                foreach ($row as $key => $value) {
                    $temp[$key]="";
                }
            }
            foreach ($row as $key => $value) {
                if ($key<=$limit){
                    if($temp[$key] != $value){
                    $temp[$key] = $value;

                    if($level<$key){
                        $level=$key;
                        echo "<ul>";
                    }
                    if ($key<$level){
                        $level--;
                        echo "</ul>";
                    }

                        switch ($key+1) {
                            case ($key+1 == $limit+1):
                                echo "<a href=\"index.php?index={$row[$limit+1]}\"><li>$temp[$key]</li></a>";
                                break;
                            case ($key+1 < $limit+1):
                                echo "<li>$temp[$key]</li>";
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    
                }   
                }
                
            }

        }
        for ($i=$level+1; $i !=0; $i--) { 
             echo "</ul>";
        }
    }

}


