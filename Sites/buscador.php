
<?php require("routes.php");

?>


<?php
	$tipo = $_POST["search"];
    if($_POST["search"] == 'Navieras'){
        include('templates/header.php');
        include($INDEX_GRUPO_38);   
    }
    else if ($_POST["search"] == 'Puertos')
    {
        include('templates/header.php');
        include('index2.php');
    }else if ($_POST["search"] == 'Buques')
    {
        include('templates/header.php');
        include($INDEX_GRUPO_38); 
    }else{
        include($INDEX_ROUTE);  
    }
?>
