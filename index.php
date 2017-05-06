<!DOCTYPE html>

<html lang="en">

    <head>
        <title></title>
        <meta charset="UTF-8">
       
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style type="text/css">
            body{
                display : flex;
                flex-direction :column;
            }
            #menuPrin,section{
                display : flex;
                flex-direction : row;
                margin:10px;
                padding:10px;
                border:1px solid black;
            }
            li{
                list-style-type:none;
                margin-left:10px;
                padding-left:10px;
            }
            #test{
                 border:1px solid black;
                 /*margin:5px;
                padding-bottom:5px;*/
            }

        </style>
    </head>
    <body>
    <header>
        <nav>
            <ul id="menuPrin">
            <li><a href=index.php?menu=user>User</a></li>
            <li><a href=index.php?menu=student&colonne1=lastname&colonne2=firstName>Student</a></li>
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
             <?php
                $controller->setForm();
            ?>
        </article>
    </section>
      
    </head>
    <body>

    </body>
</html>