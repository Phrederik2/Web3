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
    </head>
    <body>
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
      
    </head>
    <body>

    </body>
</html>