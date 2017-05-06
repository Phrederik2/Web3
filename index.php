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
            <li><a href=index.php?menu=user&colonne1=lastname&colonne2=firstName>User</a></li>
            <li><a href=index.php?menu=student&colonne1=lastname&colonne2=firstName>Student</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <aside>
            <?php

            require_once("Controller.php");
            $controller = new Controller();
            $controller->getTableView();
            ?>
        </aside>
        <article>
             <?php
                $controller->setForm();
            ?>
        </article>
    </section>
        <?php


        //$controller->setForm();
            /*include"forma.php";

            $localhost = "localhost";
            $user = "root";
            $password = "bachelier";
            $db = "projetintegration";

            $pdo = new PDO("mysql:host={$localhost};dbname=".$db,$user,$password);

            $userlist;
            $statement = $pdo->query("select lastName from user");
            //$row = $query->fetch(PDO::FETCH_ASSOC);


          while($row = $statement->fetch(PDO::FETCH_ASSOC)){
               echo $row['lastName']."</br>";
           }

            $userForm = new Form("User");

            $userForm->add(new Text("LastName"));
            $userForm->add(new Text("firstName"));
            $userForm->add(new Text("Password"));
            $userForm->add(new checkBox("Administrateur"));

            //$userForm->setPDO($pdo);

            $userForm->bind($pdo,"user","ID = 5");

            echo $userForm->toString();

            //echo("test");

            //echo("test " + $userForm->bind($pdo,"user","ID = 5"));
            //echo("test " + $userForm->bind($pdo,"user","ID = 5"));"SELECT * from FE_Category WHERE (isnull(Link) OR Link='') AND IsVisible=-1"*/
        ?>
    </body>
</html>