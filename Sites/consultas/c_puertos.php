
<?php require("../routes.php");?>
<?php require("../templates/header.php");?>

<body>

<?php
  # <?php include('../templates/header.html') ;? >
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");
	$tipo = $_POST["c_puertos"];
 	$query = "SELECT id_puerto, nombre_puerto,ciudad FROM puertos WHERE id_puerto = $tipo;";
	$result = $db -> prepare($query);
	$result -> execute();
	$lista = $result -> fetchAll();
  ?>

	<table>
    <tr>
	<th>ID</th>
      <th>Nombre Puerto</th>
      <th>Ciudad</th>
    </tr>
  <?php
	foreach ($lista as $puerto) {
  		echo "<tr> <td>$puerto[0]</td> <td>$puerto[1]</td><td>$puerto[2]</td> </tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
