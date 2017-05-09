<?php
require_once("forma.php");

$formName = Controller::getOrigin();
$id = null;
$menu = $_GET['menu'];
if(isset($_GET['id'])) $id = $_GET['id'];

$form = new Form("Student");

$form->add(new Text("LastName"));
$form->add(new Text("FirstName"));
$form->add(new Email("Email"));
$select = new Select ( "Activation", null, null, "IsDelete" );
$select->add ( new Option ( 0, "Activate" ) );
$select->add ( new Option ( 1, "Desactivate" ) );
$form->add ( $select );
$form->setAutorizeEmpty(true);

if($menu==$formName and $id != null and $id !=0){
    $form->bind(DbCo::getPDO(),$formName,"ID = '$id'");
}
if($id==0){
    
    if (isset ( $_POST ) == false or count ( $_POST ) == 0){
        $form->reinit ();
    }

    $form->setTable($formName);
    $form->setPDO(DbCo::getPDO());
    $select->setValue(0);
}

$form->initialize();

Controller::setForma($form);