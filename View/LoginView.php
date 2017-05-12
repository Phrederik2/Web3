<?php
require_once("Forma.php");


$form = new Form("Login");

$form->add(new Text("Last Name"));
$form->add(new Text("First Name"));
$form->add(new Password("Password"));

$form->reinit();

$form->initialize();
echo $form->toString();