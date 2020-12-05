<?php include('../templates/header_38.html');   ?>
<body>

  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $tipo_buque = $_POST["tipo_buque"];

  if ($tipo_buque == 'pesquero') {
    $query = "SELECT buques.patente, buques.nombre, buques.pais, COUNT(personal.pasaporte) FROM buquepesquero, personal, TrabajaEn, 
    buques WHERE Personal.pasaporte = TrabajaEn.pasaporte AND buquepesquero.patente = trabajaen.patente AND buques.patente = 
    buquepesquero.patente GROUP BY buques.patente HAVING COUNT (personal.pasaporte) = (SELECT MAX(maxtripulacion) FROM (SELECT  
    buquepesquero.patente, COUNT(personal.pasaporte) maxtripulacion  FROM Personal, TrabajaEn, BuquePesquero WHERE Personal.pasaporte = 
    TrabajaEn.pasaporte AND buquepesquero.patente = trabajaen.patente GROUP BY Buquepesquero.patente) AS cantidad );";
    $result = $db38 -> prepare($query);
    $result -> execute();
    $buque = $result -> fetchAll(); 
  } elseif ($tipo_buque == 'carga') {
    $query = "SELECT buques.patente, buques.nombre, buques.pais, COUNT(personal.pasaporte) FROM buquecarga, personal, TrabajaEn, 
    buques WHERE Personal.pasaporte = TrabajaEn.pasaporte AND buquecarga.patente = trabajaen.patente AND buques.patente = 
    buquecarga.patente GROUP BY buques.patente HAVING COUNT (personal.pasaporte) = (SELECT MAX(maxtripulacion) FROM (SELECT  
    buquecarga.patente, COUNT(personal.pasaporte) maxtripulacion  FROM Personal, TrabajaEn, buquecarga WHERE Personal.pasaporte = 
    TrabajaEn.pasaporte AND buquecarga.patente = trabajaen.patente GROUP BY buquecarga.patente) AS cantidad );";;
    $result = $db38 -> prepare($query);
    $result -> execute();
    $buque = $result -> fetchAll();   
  } elseif ($tipo_buque == 'petrolero') {
    $query = "SELECT buques.patente, buques.nombre, buques.pais, COUNT(personal.pasaporte) FROM buquepetrolero, personal, TrabajaEn, 
    buques WHERE Personal.pasaporte = TrabajaEn.pasaporte AND buquepetrolero.patente = trabajaen.patente AND buques.patente = 
    buquepetrolero.patente GROUP BY buques.patente HAVING COUNT (personal.pasaporte) = (SELECT MAX(maxtripulacion) FROM (SELECT  
    buquepetrolero.patente, COUNT(personal.pasaporte) maxtripulacion  FROM Personal, TrabajaEn, buquepetrolero WHERE Personal.pasaporte = 
    TrabajaEn.pasaporte AND buquepetrolero.patente = trabajaen.patente GROUP BY buquepetrolero.patente) AS cantidad );";;
    $result = $db38 -> prepare($query);
    $result -> execute();
    $buque = $result -> fetchAll(); 
  }

  ?>

  <table class="center">
    <tr>
    <th style= "background-color: #222C45;">Patente</th>
    <th style= "background-color: #222C45;">Nombre</th>
    <th style= "background-color: #222C45;">País</th>
    <th style= "background-color: #222C45;">Personas trabajando</th>
    </tr>
  <?php
  foreach ($buque as $b) {
    echo "<tr> <td>$b[0]</td> <td>$b[1]</td> <td>$b[2]</td> <td>$b[3]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>