<?php include('../templates/header.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  $mes = $_POST["fecha_inicio"];
  $año = $_POST["fecha_fin"];
  $mes_stge = $mes + 1;
   $query = "SELECT nombre_puerto, COUNT(patente_barco) AS cantidad_barcos FROM (SELECT id_puerto, nombre_puerto, fecha_atraque, patente_barco FROM (SELECT fecha_atraque, patente_barco, id_instalacion FROM permisos_astillero UNION SELECT fecha_atraque, patente_barco, id_instalacion from permisos_muelle) AS all_permisos INNER JOIN pertenece_a AS todo ON all_permisos.id_instalacion = todo.id_instalacion ORDER BY nombre_puerto) AS tabla_grande WHERE tabla_grande.fecha_atraque BETWEEN '2020-08-01' AND '2020-08-31' GROUP BY nombre_puerto ORDER BY COUNT(patente_barco) DESC LIMIT 1;";

  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
  $result = $db -> prepare($query);
  $result -> execute();
  $nombre = $result -> fetchAll();

  ?>
	<table>
    <tr>
      <th>Nombre puerto</th>
      <th>Cantidad</th>
    </tr>
  <?php
	foreach ($nombre as $p) {
        echo "<tr><td>$p[0]</td><td>$p[1]</td></tr>";
    }
  ?>
	</table>

<?php include('../templates/footer.html'); ?>