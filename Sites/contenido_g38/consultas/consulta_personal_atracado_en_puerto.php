<?php include('../templates/header_38.html');   ?>
<body>

  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $cargo = $_POST["cargo"];
  $sexo = $_POST["sexo"];
  $puerto = $_POST["puerto"];

  if ($cargo == 'capitán') {
    $cargo = "capitan";
  } elseif ($cargo == 'tripulación') {
    $cargo = "tripulacion";
  }

  $query = "SELECT personal.pasaporte, personal.nombre, nacionalidad, edad, genero FROM Personal, TrabajaEn, 
  (SELECT buques.patente FROM Atraques, AtraquesRealizados, Buques WHERE buques.patente = atraquesrealizados.patente 
  AND atraques.aid = atraquesrealizados.aid AND LOWER(puerto) LIKE LOWER('%$puerto%')) AS BuquesTalcahuano WHERE 
  BuquesTalcahuano.patente = trabajaen.patente AND personal.pasaporte = trabajaen.pasaporte AND LOWER(cargo) LIKE LOWER('%$cargo%') 
  AND genero= LOWER('$sexo');";
  $result = $db -> prepare($query);
  $result -> execute();
  $personal = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table class="center">
    <tr>
    <th style= "background-color: rgb(38, 166, 216);">Pasaporte</th>
    <th style= "background-color: rgb(38, 166, 216);">Nombre</th>
    <th style= "background-color: rgb(38, 166, 216);">Nacionalidad</th>
    <th style= "background-color: rgb(38, 166, 216);">Edad</th>
    <th style= "background-color: rgb(38, 166, 216);">Género</th>
    </tr>
  <?php
  foreach ($personal as $p) {
    echo "<tr> <td>$p[0]</td> <td>$p[1]</td> <td>$p[2]</td> <td>$p[3]</td> <td>$p[4]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>