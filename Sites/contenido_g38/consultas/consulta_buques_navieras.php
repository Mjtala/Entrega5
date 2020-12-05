<?php include('../templates/header_38.html');   ?>
<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  $nombre_naviera = $_POST["nombre_naviera"];

 	$query = "SELECT buques.patente, buques.nombre, pais FROM navieras, buques, buquesdenavieras WHERE navieras.nid = buquesdenavieras.nid
    AND buques.patente = buquesdenavieras.patente AND LOWER(navieras.nombre) LIKE LOWER('%$nombre_naviera%');";
	$result = $db -> prepare($query);
	$result -> execute();
	$buques = $result -> fetchAll();
  ?>

	<table class="center">
    <tr>
      <th style= "background-color: rgb(38, 166, 216);">Patente</th>
      <th style= "background-color: rgb(38, 166, 216);">Nombre</th>
      <th style= "background-color: rgb(38, 166, 216);">País</th>
    </tr>
  <?php
	foreach ($buques as $buque) {
  		echo "<tr><td>$buque[0]</td><td>$buque[1]</td><td>$buque[2]</td></tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
