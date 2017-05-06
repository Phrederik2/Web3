<!DOCTYPE html>
<html lang="EN">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php 
        include 'Forma.php';
        include 'connect.php';


        $display = new Display(Connect::getPDO(),"ID","SELECT ID, FirstName,LastName FROM Professor WHERE IsDelete=0");
       
        echo $display->toString();

        $where=null; 
        
        if (isset($_GET["id"])){
            $where = "ID={$_GET["id"]}";
        }

        $form = new Form("Professor");
        
        $form->bind(Connect::getPDO(),"Professor",$where);
        
        $form->add(new Text("FirstName"));
        $form->add(new Text("LastName"));     
        $form->add(new Text("Code"));
        $form->add(new Email("Email"));
        $select = new Select("Local",Connect::getPDO(),"SELECT id,title from Local","idLocal");
        $form->add($select);
        $select = new Select ( "Activation", null, null, "IsDelete" );
		$select->add ( new Option ( 0, "Activate" ) );
		$select->add ( new Option ( 1, "Desactivate" ) );
        $form->add($select);
        
        echo $form->toString();
    
        ?>
    </head>
    <body>
    
    </body>
</html>