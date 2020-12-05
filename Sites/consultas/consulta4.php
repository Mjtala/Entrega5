<?php include('../templates/header.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  #Se obtiene el valor del input del usuario
  $nom_p = $_POST["nombre_puerto"]; #ESTE ES EL ID
  $nom_b = $_POST["nombre_barco"];
  #Se construye la consulta como un string
   $query = "SELECT permisos_astillero.id_instalacion, permisos_astillero.fecha_atraque FROM permisos_astillero WHERE permisos_astillero.patente_barco = (SELECT patente FROM barcos WHERE UPPER(nombre_barco) LIKE UPPER('%$nom_b%')) AND permisos_astillero.id_instalacion IN (SELECT pertenece_a.id_instalacion FROM pertenece_a WHERE pertenece_a.id_puerto =$nom_p) UNION SELECT permisos_muelle.id_instalacion, permisos_muelle.fecha_atraque FROM permisos_muelle WHERE permisos_muelle.patente_barco = (SELECT patente FROM barcos WHERE UPPER(nombre_barco) LIKE UPPER('$nom_b%')) AND permisos_muelle.id_instalacion IN (SELECT pertenece_a.id_instalacion FROM pertenece_a WHERE pertenece_a.id_puerto =$nom_p);";
   


  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
	$result = $db -> prepare($query);
	$result -> execute();
	$info = $result -> fetchAll();
  ?>

  <table>
    <tr>
    <th>ID instalación</th>
      <th>Fechas solicitadas</th>
    </tr>
    
  
      <?php
        foreach ($info as $p) {
          echo "<tr><td>$p[0]</td> <td> $p[1]</td></tr>";
      }
      ?>
      
  </table>

<?php include('../templates/footer.html'); ?>
