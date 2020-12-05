<?php include('../templates/header_38.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  #Se obtiene el valor del input del usuario
  $puerto = $_POST["puerto"];
  $año_atraque = $_POST["año_atraque"];
  #$altura = intval($altura);

  #Se construye la consulta como un string
  $query = "SELECT DISTINCT(buques.patente), nombre, pais FROM Atraques, AtraquesRealizados, Buques WHERE 
  Atraques.aid = Atraquesrealizados.aid AND buques.patente = atraquesrealizados.patente AND LOWER(Atraques.puerto) 
  LIKE LOWER('%$puerto%') AND Atraques.fecha_atraque >= '$año_atraque/01/01 00:00:00' AND Atraques.fecha_atraque <= 
  '$año_atraque/12/31 23:59:59';";

  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
	$result = $db38 -> prepare($query);
	$result -> execute();
	$buques = $result -> fetchAll();
  ?>

  <table class="center">
    <tr>
      <th style= "background-color: #222C45;">Patente</th>
      <th style= "background-color: #222C45;">Nombre</th>
      <th style= "background-color: #222C45;">País</th>
    </tr>
  
      <?php
        foreach ($buques as $buque) {
          echo "<tr><td>$buque[0]</td><td>$buque[1]</td><td>$buque[2]</td></tr>";
      }
      ?>
      
  </table>

<?php include('../templates/footer.html'); ?>
