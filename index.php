
<?php
/**
 * Inclusion
 */
if (isset($_GET)){
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case "ajax":
                $ajax=true;
                include_once("Ajax/ajaxSchedule.php");
                break;
            
            default:
                # code...
                break;
        }
    }
}
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
    session_start();
        $session = new Session();
        $controller = new Controller();
        $controller->setForm();

    if (Session::getUser()==null){
        $section=Session::showSession();
    }
    else {

    if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'menu':
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

                $section = str_replace("%TreeActivity%",$viewTreeActivity,$section);
                $section = str_replace("%Schedule%",$viewSchedule,$section);
                $section = str_replace("%Week%",$viewWeek,$section);
                $section = str_replace("%LocalTree%",$viewTreeLocal,$section);
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
