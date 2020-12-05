<?php include('../templates/header.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");


  $tipo = $_POST["tipo"];
  $minimo = $_POST["minimo"];

 	$query = "SELECT nombre_puerto, COUNT(pertenece_a.id_instalacion) as cantidad FROM pertenece_a, (SELECT id_instalacion, rut_jefe, tipo FROM instalaciones WHERE UPPER(tipo) LIKE UPPER('%$tipo%')) as only_astilleros WHERE pertenece_a.id_instalacion = only_astilleros.id_instalacion GROUP BY nombre_puerto HAVING COUNT(pertenece_a.id_instalacion) >= $minimo";
	$result = $db -> prepare($query);
	$result -> execute();
	$listas = $result -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre puerto</th>
      <th>Cantidad</th>
    </tr>
  <?php
	foreach ($listas as $p) {
  		echo "<tr><td>$p[0]</td><td>$p[1]</td></tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
