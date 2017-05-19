<?php
    session_start();
    require_once("Controller/SessionControl.php");
    $session = new Session();
    require_once("Controller/ViewControl.php");
    $controller = new Controller();
    $controller->setForm();
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="100">
        <LINK rel="stylesheet" type="text/css" href="projInt.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    </head>
    <body>
    <div id="testajax"></div>
    <?php
        $controller->getConnectedUser();
    ?>
    <header>
        <nav>      
             <?php
               $controller->getMenu();
            ?>
        </nav>
    </header>
    <section>
        <?php
               include($section);
            ?>
    </section>
    </body>
     <script src="script.js"></script>
</html>