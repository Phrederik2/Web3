
<?php

/**
 * code hors classe "point d'entrée du programme"
 * effectue les verification et recrée la page en fonctions des elements passé en get/post
 */

/**
 * verifie si c'est une demande AJAX et l'envoi dans la class AJAX
 */
 
if (isset($_POST)){
    foreach ($_POST as $key => $value) {
        switch ($key) {
            case "ajax":
                $ajax=true;
                include_once("Ajax/ajaxSchedule.php");
                $ajax = new AjaxControl();
                break;
            
            default:
                # code...
                break;
        }
    }
}
/**
 * si ce n'etait pas une demande AJAX le programme continue inclus les données
 */
if (!isset($ajax)) {
    
    include_once("Controller/SessionControl.php");
    include_once("Controller/ViewControl.php");

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
   
        $session = new Session();
        $controller = new Controller();

    if (Session::getUser()==null){
        $section=Session::showSession();
    }
    else {

    /**
     * Si l'utilisateur est connecté: en fonctions des elements en GET, recompose les pages demandées.
     */
    if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'menu':
                $controller->setForm();
                $treemenu= $controller->switchMenu(); 
                $form=$controller->getForm();

                $section=file_get_contents("Template/tGestSection.html");

                $section = str_replace("%treemenu%",$treemenu,$section);
                $section = str_replace("%form%",$form,$section);
                break;
            case 'schedule':
                include_once("Controller/ActivityTreeControl.php");
                include_once("Controller/ScheduleControl.php");
                include_once("Controller/WeekTreeControl.php");
                require_once("Controller/LocalTreeControl.php");
                $section=file_get_contents("Template/tPlanning.html");
                $activity = new ActivityTree();
                $schedule = new SceduleControl();
                $week = new WeekTreeControl();
                $localTree = new LocalTree();
                $viewTreeActivity = $activity->toString();
                $viewSchedule = $schedule->getSchedule();
                $viewWeek = $week->getWeekList();
                $viewTreeLocal = $localTree->getLocalTree();
                $crtSetting = $schedule->getCrtSetting();

                $section = str_replace("%TreeActivity%",$viewTreeActivity,$section);
                $section = str_replace("%Schedule%",$viewSchedule,$section);
                $section = str_replace("%Week%",$viewWeek,$section);
                $section = str_replace("%LocalTree%",$viewTreeLocal,$section);
                $section = str_replace('%crtSetting%',$crtSetting,$section);
                break;
            
            default:
                # code...
                break;
        }
    }
    }

        $user=$controller->getConnectedUser();
        $menu = $controller->getMenu();
    }

    $page = file_get_contents("Template/tMaster.php");
    $content = str_replace("%section%",$section,$page);
    $content = str_replace("%user%",$user,$content);
    $content = str_replace("%menu%",$menu,$content);

    echo $content;
}
