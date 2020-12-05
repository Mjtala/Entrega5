<?php include('../templates/header.html');   ?>

<body>

  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $var = $_POST["id_puerto"];
  $query = "SELECT id_puerto, nombre_puerto, AVG(edad) FROM (SELECT id_puerto, nombre_puerto, edad FROM (SELECT rut, nombre_puerto, id_puerto FROM trabajar_en AS t1 INNER JOIN pertenece_a as t2 ON t1.id_instalacion = t2.id_instalacion AND t2.id_puerto = $var) AS p1 INNER JOIN persona AS p2 ON p1.rut = p2.rut) AS promedios GROUP BY nombre_puerto, id_puerto;";
  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>ID</th>
      <th>Nombre Puerto</th>
      <th>Edad Promedio</th>
    </tr>
  <?php
  foreach ($dataCollected as $p) {
    echo "<tr><td>$p[0]</td><td>$p[1]</td><td>$p[2]</td></tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>
