<?php include('../templates/header_38.html');   ?>
<body>

  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $buque = $_POST["buque"];
  $puerto = $_POST["puerto"];

  $query = "SELECT buques.patente, nombre, pais FROM Atraques, atraquesrealizados, buques, (SELECT fecha_atraque, fecha_salida 
  FROM Atraques, AtraquesRealizados, Buques WHERE atraques.aid = atraquesrealizados.aid AND buques.patente = atraquesrealizados.patente
   AND LOWER(buques.nombre) LIKE LOWER('%$buque%') AND LOWER(atraques.puerto) LIKE LOWER('%$puerto%')) AS AtraqueBuqueEnPuerto WHERE 
   atraques.aid = atraquesrealizados.aid AND buques.patente = atraquesrealizados.patente AND ((atraques.fecha_atraque >= 
   AtraqueBuqueEnPuerto.fecha_atraque AND atraques.fecha_salida <= AtraqueBuqueEnPuerto.fecha_salida) OR (atraques.fecha_atraque <= 
   AtraqueBuqueEnPuerto.fecha_atraque AND atraques.fecha_salida <= AtraqueBuqueEnPuerto.fecha_salida AND atraques.fecha_salida > 
   AtraqueBuqueEnPuerto.fecha_atraque) OR (atraques.fecha_atraque <= AtraqueBuqueEnPuerto.fecha_atraque AND atraques.fecha_salida >= 
   AtraqueBuqueEnPuerto.fecha_salida) OR (atraques.fecha_atraque >= AtraqueBuqueEnPuerto.fecha_atraque AND atraques.fecha_atraque <= 
   AtraqueBuqueEnPuerto.fecha_salida)) AND LOWER(atraques.puerto) LIKE LOWER('%$puerto%');";
  $result = $db38 -> prepare($query);
  $result -> execute();
  $buques = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table class="center">
    <tr>
    <th style= "background-color: #222C45;">Patente</th>
    <th style= "background-color: #222C45;">Nombre</th>
    <th style= "background-color: #222C45;">País</th>
    </tr>
  <?php
  foreach ($buques as $b) {
    echo "<tr> <td>$b[0]</td> <td>$b[1]</td> <td>$b[2]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>
