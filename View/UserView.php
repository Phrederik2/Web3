<?php
require_once("forma.php");

$formName = "user";
$id = null;
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
$menu = $_GET['menu'];

$userForm = new Form("User");

$userForm->add(new Text("LastName"));
$userForm->add(new Text("firstName"));
$userForm->add(new Text("Password"));
$userForm->add(new checkBox("IsAdmin"));
$select = new Select ( "Activation", null, null, "IsDelete" );
$select->add ( new Option ( - 1, "Activate" ) );
$select->add ( new Option ( 0, "Desactivate" ) );
$userForm->add ( $select );

if($_GET['menu']=$formName and $id != null){
    $userForm->bind(DbCo::getPDO(),$formName,"ID = '$id'");
}

echo $userForm->toString();