<?php

/**
 * Controller qui sert a gerer la création de l'arbre des activity  (multi-niveau)
 * 
 */
class ActivityTree 
{
    private $dbco = null;
    private $data = Array();
    private $query = 
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
    /**
     * Constructeur, recupere le PDO et lance la requete
     */
    function __construct()
    {
        $this->dbco = DbCo::getPDO();
        $this->getData();
    }

/**
 * Lance la requete et envoi le resultat dans un tableau
 *
 * @return void
 */
    private function getData()
    {
        $statement = $this->dbco->query($this->query);
        while($item = $statement->fetch(PDO::FETCH_NUM)){
            array_push($this->data,$item);
        }
    }

    /**
     * Construit les liste a puces imbriquée sur base des elements qui sont different uniquement
     * 
     * exemple:
     * Feuille 1, Feuille2, Feuille3.
     * Feuille 1, Feuille2, Feuille4.
     * 
     * Sera traduit par
     * Feuille 1
     *      Feuille2
     *          Feuille3
     *          Feuille4
     *
     * @param int $retrait le retrait est une façon d'indiqué la fin des valeurs a afficher, 
     *                      donc que la collones en retrait sera utilisée comme clé dans le lien ou l'appel JS
     * @return void
     */
    private function constructTree($retrait=1){

        $retrait = 1;
        $limit=null;
        $tree = array();
        $temp=null;
        $level=-1;

        $str="";

       foreach ($this->data as $item) {
        
            if ($temp==null){
                $temp=array();
                $limit=count($item)-1-$retrait;
                foreach ($item as $key => $value) {
                    $temp[$key]="";
                }
            }
            foreach ($item as $key => $value) {
                if ($key<=$limit){
                    if($temp[$key] != $value){
                    $temp[$key] = $value;

                    if($level<$key){
                        $level=$key;
                        $str.= "<ul>";
                    }
                    if ($key<$level){
                        for ($i=$level; $i != $key ; $i--) { 
                            $level--;
                            $str.= "</ul>";
                        }
                    }

                        switch ($key+1) {
                            case ($key+1 == $limit+1):
                                $str.= "<a onclick=\"request('index.php?index={$item[$limit+1]}')\" href=\"#\"><li>$temp[$key]</li></a>";
                                break;
                            case ($key+1 < $limit+1):
                                $str.= "<li>$temp[$key]</li>";
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
             $str.= "</ul>";
        }

        return $str;
    }

    /**
     * lance la construction et l'ecris *
     * @return void
     */
    public function toString()
    {
        echo $this->constructTree();
    }

}


