<?php
session_start();
require("routes.php");
require($CONFIG_ROUTE);
include("templates/header.php");
include("login/login_2.php");

$naviera = "Naviera:";
$proximo_i = "Próximo itinerario:";
$ultimos_l = "Últimos lugares donde ha estado:";
?>

<!-- General -->
<div class="jumbotron jumbotron-fluid bg-dark text-white">
  <div class="container">
  <h1 class="display-4">Perfil</h1>
    <p class="lead"> Aquí encontraras tu información personal</p>
  </div>
</div>
</body>

<div class=container>
  <div class="row justify-content-center">
    <div class="col-sm">
      <div class="input-group my-3">
        <p class="lead">Nombre: <?php echo $_SESSION["nombre"] ?></p>
      </div>
      <div class="input-group my-3">
        <p class="lead">Edad: <?php echo $_SESSION["edad"] ?></p>
      </div>
      <div class="input-group my-3">
        <p class="lead">Sexo: <?php echo $_SESSION["sexo"] ?></p>
      </div>
      <div class="input-group my-3">
        <p class="lead">Pasaporte: <?php echo $_SESSION["pasaporte"], "<br />", "<br />" ?></p>
      </div>
      </div>
    </div>
  </div>
</div>
  

<!-- Jefe de instalación -->
<?php
  require("config/conexion.php");
  $name = $_SESSION["nombre"];
  $query = "SELECT id_instalacion FROM instalaciones WHERE rut_jefe = (SELECT rut FROM persona WHERE nombre = '$name');";
  $result = $db -> prepare($query);
  $result -> execute();
  $instalacion = $result -> fetchAll();
?>

<div class=container>
  <div class="row justify-content-center">
    <div class="col-sm">
      <div class="input-group my-3">
        <p class="lead">
          <?php if (!empty($instalacion[0][0])){
            $name = $_SESSION["nombre"];
            $query = "SELECT tipo, id_instalacion FROM instalaciones WHERE rut_jefe = (SELECT rut FROM persona WHERE nombre = '$name');";
            $result = $db -> prepare($query);
            $result -> execute();
            $tipo = $result -> fetchAll();
            $id_instalacion = $tipo[0][1];
            $query = "SELECT nombre_puerto FROM pertenece_a WHERE id_instalacion = '$id_instalacion';";
            $result = $db -> prepare($query);
            $result -> execute();
            $nombre_puerto = $result -> fetchAll();
            echo "ERES JEFE DE INSTALACIÓN", "<br />", "<br />";
            echo "Nombre puerto: ", $nombre_puerto[0][0], "<br />";
            echo "Tipo de instalación: ", $tipo[0][0], "<br />";
            echo "ID instalación: ", $tipo[0][1], "<br />";
          }?></p>
      </div>
    </div>
  </div>
</div>

<?php
  require("config/conexion.php");
  $name = $_SESSION["nombre"];
  $query = "SELECT cargo FROM personal WHERE nombre = '$name';";
  $result = $db38 -> prepare($query);
  $result -> execute();
  $cargo = $result -> fetchAll();
?>

<!-- Capitán de Buque -->
<div class=container>
  <div class="row justify-content-center">
    <div class="col-sm">
      <div class="input-group my-3">
        <p class="lead">
          <?php 
          if ($cargo[0][0] = "capitan" && !empty($cargo[0][0])){
            $name = $_SESSION["nombre"];
            $pasaporte = $_SESSION["pasaporte"];
            // Busqueda de patente
            $query = "SELECT patente FROM trabajaen WHERE pasaporte = '$pasaporte';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result2 = $result -> fetchAll();
            $patente = $result2[0][0];
            // Busqueda de nombre_b
            $query = "SELECT nombre FROM buques WHERE patente = '$patente';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result3 = $result -> fetchAll();
            $nombre_b = $result3[0][0];
            // Busqueda de tipo de buque
            // tipo carga
            $query = "SELECT max_ton FROM buquecarga WHERE patente = '$patente';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result_1 = $result -> fetchAll();
            $tipo_carga = $result_1[0][0];
            // tipo pesquero
            $query = "SELECT tipo_pesca FROM buquepesquero WHERE patente = '$patente';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result_2 = $result -> fetchAll();
            $tipo_pesquero = $result_2[0][0];
            // tipo petrolero
            $query = "SELECT max_lit FROM buquepetrolero WHERE patente = '$patente';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result_3 = $result -> fetchAll();
            $tipo_petrolero = $result_3[0][0];
            if (!empty($tipo_carga)){
              $tipo_b = "Carga";
            }elseif(!empty($tipo_pesquero)){
              $tipo_b = "Pesquero";
            }elseif(!empty($tipo_petrolero)){
              $tipo_b = "Petrolero";
            }
            // Busqueda de nombre naviera
            $query = "SELECT nid FROM buquesdenavieras WHERE patente = '$patente';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result4 = $result -> fetchAll();
            $nid = $result4[0][0];
            $query = "SELECT nombre FROM navieras WHERE nid = '$nid';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result5 = $result -> fetchAll();
            $nombre_n = $result5[0][0];
            // Busqueda de proximo itinerario
            $query = "SELECT iid FROM itinerariobuques WHERE patente = '$patente';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result4 = $result -> fetchAll();
            $iid = $result4[0][0];
            $query = "SELECT proximo_puerto, fecha_estimada_llegada FROM proximositinerarios WHERE iid = '$iid';";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result5 = $result -> fetchAll();
            $prox_p = $result5[0][0];
            $fecha = $result5[0][1];
            
            // Busqueda de 5 ultimos lugares donde ha estado
            $query = "SELECT puerto FROM atraquesrealizados AS a1 INNER JOIN atraques AS a2  ON a1.aid = a2.aid WHERE patente = '$patente' ORDER BY fecha_salida;";
            $result = $db38 -> prepare($query);
            $result -> execute();
            $result4 = $result -> fetchAll();
            $puerto_1 = $result4[0][0];
            $puerto_2 = $result4[1][0];
            $puerto_3 = $result4[2][0];
            $puerto_4 = $result4[3][0];
            $puerto_5 = $result4[4][0];
            


            echo "ERES CAPITÁN DE BUQUE", "<br />", "<br />";
            echo "Nombre buque: ", $nombre_b, "<br />";
            echo "Patente: ", $patente, "<br />";
            echo "Tipo de buque: ", $tipo_b, "<br />";
            echo "Nombre naviera: ", $nombre_n, "<br />";
            echo "Próximo itinerario (puerto): ", $prox_p, "   Fecha: ", $fecha, "<br />";
            echo "Últimos puertos en que ha estado: ", $puerto_1,"  ", $puerto_2,"  ", $puerto_3,"  ", $puerto_4,"  ", $puerto_5, "<br />";
          }?></p>
      </div>
    </div>
  </div>
</div>


<div class=container>
  <div class="row justify-content-center">
    <div class="col-sm">
      <form action="change_pass/change_pass1.php" method="post">
        <div class="input-group my-3">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Cambiar contraseña" name="password">

      </form>
        </div>
        </div>
    </div>
  </div>
</div>

</html>

</html>