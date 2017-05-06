<?php
require_once("forma.php");

/*$tbvUser ="<table><th>List of user</th>";
foreach($userList as $crtUser){
    
    $tbvUser .= "</td><td><a href=index.php?editUser=true&idUser={$crtUser->getId()}&lastName=".urlencode($crtUser->getLastName())."&firstName=".urlencode($crtUser->getfirstName())."&isAdmin={$crtUser->getIsAdmin()}&isChange={$crtUser->getIsChange()}.&isDelete={$crtUser->getIsDelete()} >{$crtUser->getLastName()} {$crtUser->getFirstName()}</a></td></tr>";
    
}
$tbvUser.="</table>";

echo $tbvUser;*/

$userForm = new Form("User");

$userForm->add(new Text("LastName"));
$userForm->add(new Text("firstName"));
$userForm->add(new Text("Password"));
$userForm->add(new checkBox("Administrateur"));
$userForm->add(new checkBox("Delete"));

//test

//$userForm->setPDO($pdo);

if(isset($_GET['idUser'])){
    $userForm->bind(DbCo::getPDO(),"user","ID = '{$_GET['idUser']}'");
}else{
$userForm->bind(DbCo::getPDO(),"user","ID = 5");
}

echo $userForm->toString();