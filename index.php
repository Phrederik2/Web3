
<?php
/**
 * Inclusion
 */
include_once("Controller/SessionControl.php");
include_once("Controller/ViewControl.php");
include_once("Controller/SessionControl.php");

/**
 * initialisation
 */
$page="";
$section="";
$form="";
$content="";
$user="";
$menu="";

/**
 * Verification
 */
 session_start();
    $session = new Session();
    $controller = new Controller();
    $controller->setForm();

 if (Session::getUser()==null){
    $section=Session::showSession();
}
else {

    if (isset($_GET["menu"])) {
        $treemenu= $controller->switchMenu();    
        $form=$controller->getForm();
        $section=file_get_contents("Template/tGestSection.html");
        $section = str_replace("%treemenu%",$treemenu,$section);
        $section = str_replace("%form%",$form,$section);
        
    }

    $user=$controller->getConnectedUser();
    $menu = $controller->getMenu();
}

$page = file_get_contents("Template/tMaster.php");
$content = str_replace("%section%",$section,$page);
$content = str_replace("%user%",$user,$content);
$content = str_replace("%menu%",$menu,$content);

echo $content;

