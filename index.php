<!DOCTYPE html>

<html lang="en">

<html lang="EN">

    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="50">
        <LINK rel="stylesheet" type="text/css" href="projInt.css">
    </head>
    <body>
    <header>
        <nav>
            <ul id="menuPrin">
                <li><a href=index.php?menu=user>User</a></li>
                <li><a href=index.php?menu=student>Student</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <aside>
            <?php
                require_once("Controller.php");
                $controller = new Controller();
                $controller->switchMenu();
            ?>
        </aside>
        <article>
            <div id="form">
                <?php
                    $controller->setForm();
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