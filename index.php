<!DOCTYPE html>

<html lang="en">

<html lang="EN">

    <head>
        <title></title>
        <meta charset="UTF-8">
        <?php
        $str="";
        if(isset($_GET)){
            foreach ($_GET as $key => $value) {
                if ($str!="")$str.="?";
               $str.="$key=$value";
            }
        }
        echo $str;
        ?>
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
            article{
                display:flex;
                flex-direction:column;
            }
            #gestPivot{
                display:flex;
                flex-direction:row;
            }

        </style>
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
             <?php
                $controller->setForm();
            ?>
            <div id="gestPivot">
                <?php
                    $controller->setAssoc();
                    $controller->setFreed();
                ?>
            </div>
        </article>
    </section>
      
    </head>
    <body>

    </body>
</html>