<?php
require_once("forma.php");

$userForm = new Form("User");

$userForm->add(new Text("LastName"));
$userForm->add(new Text("firstName"));
$userForm->add(new Text("Password"));
$userForm->add(new checkBox("IsAdmin"));
$select = new Select ( "Activation", null, null, "IsDelete" );
$select->add ( new Option ( - 1, "Activate" ) );
$select->add ( new Option ( 0, "Desactivate" ) );
$userForm->add ( $select );

if($_GET['menu']="user" and isset($_GET['id'])){
    $userForm->bind(DbCo::getPDO(),"user","ID = '{$_GET['id']}'");
}else{
$userForm->bind(DbCo::getPDO(),"user","ID = 5");
}

echo $userForm->toString();