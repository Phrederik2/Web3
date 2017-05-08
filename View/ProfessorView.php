<?php
require_once("forma.php");

$formName = Controller::getOrigin();
$id = null;
$menu = $_GET['menu'];
if(isset($_GET['id'])) $id = $_GET['id'];

$form = new Form("Professor");
        
$form->add(new Text("FirstName"));
$form->add(new Text("LastName"));     
$form->add(new Text("Code"));
$form->add(new Email("Email"));
$select = new Select("Local",DbCo::getPDO(),"SELECT id,title from Local","idLocal");
$form->add($select);
$select = new Select ( "Activation", null, null, "IsDelete" );
$select->add ( new Option ( 0, "Activate" ) );
$select->add ( new Option ( 1, "Desactivate" ) );
$form->add($select);

if($menu==$formName and $id != null and $id !=0){
    $form->bind(DbCo::getPDO(),$formName,"ID = '$id'");
}
if($id==0){
    $form->setTable($formName);
    $form->setPDO(DbCo::getPDO());
    $form->reinit();
}

echo $form->toString();