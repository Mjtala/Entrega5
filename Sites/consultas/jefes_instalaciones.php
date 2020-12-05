<?php include('../templates/header.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  #Se obtiene el valor del input del usuario
  $id = $_POST["id_inst"];
  #Se construye la consulta como un string
   $query = "SELECT persona.nombre FROM( SELECT rut_jefe FROM (SELECT * FROM pertenece_a WHERE pertenece_a.id_puerto = $id ) AS nombre_obtenido, Instalaciones WHERE Instalaciones.id_instalacion = nombre_obtenido.id_instalacion) AS rut_jefe_obt, persona WHERE rut_jefe_obt.rut_jefe = persona.rut;";
   


  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
	$result = $db -> prepare($query);
	$result -> execute();
	$nombres = $result -> fetchAll();
  ?>

  <table>
    <tr>
      <th>Nombres Jefes</th>
    </tr>
  
      <?php
        foreach ($nombres as $p) {
          echo "<tr><td>$p[0]</td></tr>";
      }
      ?>
      
  </table>

<?php include('../templates/footer.html'); ?>
