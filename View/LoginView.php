<?php
require_once("Forma.php");

if(!isset($_SESSION['lastName']))
$form = new Form("Login");

$form->add(new Text("Last name","lastName"));
$form->add(new Text("First name","firstName"));
$form->add(new Password("Password","pass"));

$form->reinit();

$form->initialize();
$str=$form->toString();