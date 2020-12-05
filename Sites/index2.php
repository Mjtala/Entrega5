<?php include('templates/header.html');   ?>

<body>
  <!-- <h1 align="center">¡¡Consulta lo que necesites!! </h1> -->
  <p style="text-align:center;">Aquí podrás encontrar información relevante para tus tareas.</p> 

  <br>

<!--  post es para recopilar datos de formularios después de mandar un formulario y submit es para mandar los datos-->
  <h3 align="center"> 1. Ve la ciudad asignada al puerto que quieras.</h3>
  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT id_puerto, nombre_puerto FROM puertos ORDER BY id_puerto;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  <form align="center" action="consultas/c_puertos.php" method="post">
    Seleccinar un tipo:
    <select name="c_puertos">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0] $d[1]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por puerto">
  </form>

  <br>
  <br>
  <br>
  <br>


  <h3 align="center"> 2. Ve todos los jefes de las instalaciones del puerto que quiera.</h3>

  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT id_puerto, nombre_puerto FROM puertos ORDER BY id_puerto;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>
  <form align="center" action="consultas/jefes_instalaciones.php" method="post">
  Nombre Puerto:
    <select name="id_inst">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0] $d[1]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por puerto">
  </form>

  <br>
  <br>
  <br>
  <br>


  <h3 align="center"> 3. Vea los puertos con mínimo una cantidad x de un tipo de muelle o astillero.</h3>

  <form align="center" action="consultas/puertos_minimo_instalaciones.php" method="post">
  Mínimo:
    <input type="text" name="minimo">
    <br/><br/>
    Tipo instalación:
    <input type="text" name="tipo">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>

  <h3 align="center">4. Ve las veces que un determinado barco ha estado en un determinado puerto.</h3>

  <?php
  require("config/conexion.php");
  $result1 = $db -> prepare("SELECT DISTINCT id_puerto, nombre_puerto FROM puertos ORDER BY id_puerto;");
  $result1 -> execute();
  $result2 = $db -> prepare("SELECT DISTINCT nombre_barco FROM barcos ORDER BY nombre_barco;");
  $result2 -> execute();
  $dataCollected1 = $result1 -> fetchAll();
  $dataCollected2 = $result2 -> fetchAll();
  ?>

  <form align="center" action="consultas/consulta4.php" method="post">
    Seleccinar un puerto:
    <select name="nombre_puerto">
    <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected1 as $d) {
        echo "<option value=$d[0]>$d[0] $d[1]</option>";
      }
      ?>
    </select>
    Seleccinar un barco:
    <select name="nombre_barco">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected2 as $d2) {
        echo "<option value=$d2[0]>$d2[0]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>
  <br>

 <h3 align="center">5. Consulta la edad promedio de los trabajadores del puerto que quieras.</h3>

  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT id_puerto, nombre_puerto FROM puertos ORDER BY id_puerto;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  <form align="center" action="consultas/avg_edad_puertos.php" method="post">
    Seleccinar un puerto:
    <select name="id_puerto">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0] $d[1]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por nombre">
  </form>

  <h3 align="center"> 6. Muestre el puerto que ha recibido m ́as barcos en Agosto del 2020.</h3> 

  <form align="center" action="consultas/max_puerto_por_fecha.php" method="post">
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>
  

  <br>
  <br>
  <br>
  <br>
</body>
</html>
