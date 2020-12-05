<?php include('../templates/header_38.html');   ?>
<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

 	$query = "SELECT nombre FROM navieras";
	$result = $db -> prepare($query);
	$result -> execute();
	$navieras = $result -> fetchAll();
  ?>

	<table class="center">
    <tr>
      <th style= "background-color: rgb(38, 166, 216);">Nombre</th>
    </tr>
  <?php
	foreach ($navieras as $naviera) {
  		echo "<tr> <td>$naviera[0]</td> </tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
