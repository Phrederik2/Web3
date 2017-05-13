<?php
/**
 * Class origine contenant les attribut que la plupart des modèle ont
 */
class Primary{
    protected $id = 0;
    protected $isAdmin = false;
    protected $isChange = false;
    protected $isDelete = false;

    function __construct($id,$isAdmin=false,$isChange=false,$isDelete=false){
        $this->setId($id);
        $this->setIsAdmin($isAdmin);
        $this->setIsChange($isChange);
        $this->setIsDelete($isDelete);
    }

    function getId(){return $this->id;}
    function getIsAdmin(){return $this->isAdmin;}
    function getIsChange(){return $this->isChange;}
    function getIsDelete(){return $this->isDelete;}

    function setId($id){$this->id = $id;}
    function setIsAdmin($isAdmin){ $this->isAdmin = $isAdmin;}
    function setIsChange($isChange){$this->isChange = $isChange;}
    function setIsDelete($isDelete){$this->isDelete = $isDelete;}
}