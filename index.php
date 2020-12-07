<?php
require("routes.php");
include("templates/header.php");
$response = file_get_contents('http://example.com/path/to/api/call?param1=5');
?>


<div class="jumbotron jumbotron-fluid bg-dark text-white">
  <div class="container">
  <h1 class="display-4">Puertos, Navieras y Buques</h1>
    <p class="lead">Aquí podrás encontrar información sobre los puertos, las navieras y sus buques, y mucho más.</p>
  </div>
</div>
</body>

<div class=container>
  <div class="row justify-content-center">
    <div class="col-sm">
  <form action="buscador.php" method="post">
    <div class="input-group my-3">
        <input type="text" class="form-control" placeholder="Busca Navieras, Puertos o Buques"
        aria-label="Buscador" aria-describedby="button-addon2" name="search">

        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>

<?php
  require("config/conexion.php");
  $query = "SELECT nombre
            FROM navieras;";

  $result = $db38 -> prepare($query);
  $result -> execute();
  $nav = $result -> fetchAll();
?>
<br>

<div class="container">
  <div class="row justify-content-center">
    <div class="d-inline-flex" style="overflow: auto; max-height: 500px;">
      <table class="table table-hover table-md w-auto">
        <thead class="thead-dark" style="position: sticky; top: 0;">
          <tr>
            <th>Selecciona la Naviera que quieras</th>
          </tr>
        </thead>
        <?php foreach ($nav as $n) {
                echo "<tr> <td><a href= 'consultas/busqueda_naviera.php?name=$n[0]'>$n[0]</a> </td>
                      </tr>";
              } ?>


</table>

</div>
</div>
</div>
<?php
  require("config/conexion.php");
  $query = "SELECT id_puerto, nombre_puerto
            FROM puertos;";

  $result = $db -> prepare($query);
  $result -> execute();
  $puerto = $result -> fetchAll();
?>
<br>

<div class="container">
  <div class="row justify-content-center">
    <div class="d-inline-flex" style="overflow: auto; max-height: 500px;">
      <table class="table table-hover table-md w-auto">
        <thead class="thead-dark" style="position: sticky; top: 0;">
          <tr>
            <th>Selecciona el Puerto que quieras</th>
          </tr>
        </thead>
        <?php foreach ($puerto as $p) {
                echo "<tr> <td><a href= 'consultas/busqueda_puertos.php?name=$p[0]'>$p[1]</a></td>
                      </tr>";
              } ?>


</table>
</div>
</div>
</div>
</html>