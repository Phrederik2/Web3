<?php
require_once("forma.php");

$formName = Controller::getOrigin();
$id = null;
$menu = $_GET['menu'];
if(isset($_GET['id'])) $id = $_GET['id'];

$userForm = new Form("User");

$userForm->add(new Text("LastName"));
$userForm->add(new Text("firstName"));
$userForm->add(new Text("Password"));
$userForm->add(new checkBox("IsAdmin"));
$select = new Select ( "Activation", null, null, "IsDelete" );
$select->add ( new Option ( - 1, "Activate" ) );
$select->add ( new Option ( 0, "Desactivate" ) );
$userForm->add ( $select );

if($menu==$formName and $id != null and $id !=0){
    $userForm->bind(DbCo::getPDO(),$formName,"ID = '$id'");
}
if($id==0){
    $userForm->setTable($formName);
    $userForm->setPDO(DbCo::getPDO());
    $userForm->reinit();
}

echo $userForm->toString();
echo $userForm->getLastItem()->getValue();