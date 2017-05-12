<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="en">

    <head>
            <?php
                require_once("Controller/ViewControl.php");
                require_once("Controller/SessionControl.php");
                $session = new Session();
                $controller = new Controller();
                $controller->setForm();
            ?>
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
        <aside>
            <?php
                $controller->switchMenu();
            ?>
        </aside>
        <article>
            <div id="form">
                <?php
                    
                    $controller->getForm();
                ?>
                <div id="gestPivot">
                <div>
                    
                <h3>Item lié</h3></br>
                    <?php
                        $controller->setAssoc();
                    ?>
                </div>
                <div>
                    
                <h3>Item non lié</h3></br>                    
                    <?php
                        $controller->setFreed();
                    ?>
                </div>
                </div>
            </div>
        </article>
    </section>
      
    </head>
    <body>

    </body>
</html>