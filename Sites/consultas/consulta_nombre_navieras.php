<?php include('../templates/header_38.html');   ?>
<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

 	$query = "SELECT nombre FROM navieras";
	$result = $db38 -> prepare($query);
	$result -> execute();
	$navieras = $result -> fetchAll();
  ?>

	<table class="center">
    <tr>
      <th style= "background-color: #222C45;">Nombre</th>
    </tr>
  <?php
	foreach ($navieras as $naviera) {
  		echo "<tr> <td>$naviera[0]</td> </tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
