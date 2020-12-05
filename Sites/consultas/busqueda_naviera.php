<?php 
require("../routes.php");
require("../templates/header.php");
?>

<?php
  require("../config/conexion.php");
  $nav_name = $_GET["name"];
  $query1 = "SELECT buquepesquero.patente, buques.nombre
            FROM navieras, buquesdenavieras, buquepesquero, buques
            WHERE navieras.nid=buquesdenavieras.nid
            AND buquepesquero.patente=buquesdenavieras.patente
            AND buquepesquero.patente = buques.patente
            AND navieras.nombre LIKE '%$nav_name%';";
  $result1 = $db38 -> prepare($query1);
  $result1 -> execute();
  $buque_pesquero = $result1 -> fetchAll();

  $query2 = "SELECT buquecarga.patente, buques.nombre
            FROM navieras, buquesdenavieras, buquecarga, buques
            WHERE navieras.nid=buquesdenavieras.nid
            AND buquecarga.patente=buquesdenavieras.patente
            AND buquecarga.patente = buques.patente
            AND navieras.nombre LIKE '%$nav_name%';";
  $result2 = $db38 -> prepare($query2);
  $result2 -> execute();
  $buque_carga = $result2 -> fetchAll();

  $query3 = "SELECT buquepetrolero.patente, buques.nombre
            FROM navieras, buquesdenavieras, buquepetrolero, buques
            WHERE navieras.nid=buquesdenavieras.nid
            AND buquepetrolero.patente=buquesdenavieras.patente
            AND buquepetrolero.patente = buques.patente
            AND navieras.nombre LIKE '%$nav_name%';";
  $result3 = $db38 -> prepare($query3);
  $result3 -> execute();
  $buque_petrolero = $result3 -> fetchAll();


?>

<br>

<div class=container>
  <div class="row justify-content-center">
    <div class="d-inline-flex" style="overflow: auto; max-height: 500px;">
      <table class="table col-md-6 table-hover table-md w-auto">
        <thead class="thead-dark" style="position: sticky; top: 0;">
        <tr>
          <th colspan="2">Buque Pesquero</th>
        </tr>
        <tr style="background-color:#B3B5BB">
          <td>Patente</td>
          <td>Buque nombre</td>
        </tr> 
        </thead>
        <?php 
        foreach ($buque_pesquero as $b_pes) {
            echo "<tr>  <td>$b_pes[0]</td>
                        <td>$b_pes[1]</td> </tr>";}
        ?>
      </table>
      <table class="table col-md-6 table-hover table-md w-auto">
      <thead class="thead-dark" style="position: sticky; top: 0;">
      <tr>
          <th colspan="2">Buque De Carga</th>
        </tr>
        <tr style="background-color:#B3B5BB">
          <td>Patente</td>
          <td>Buque nombre</td>
        </tr> 
      </thead>
      <?php
      foreach ($buque_carga as $b_c) {
        echo "<tr>  <td>$b_c[0]</td>
                    <td>$b_c[1]</td> </tr>";}
      ?>
    </table>
    <table class="table col-md-6 table-hover table-md w-auto">
        <thead class="thead-dark" style="position: sticky; top: 0;">
        <tr>
          <th colspan="2">Buque Petrolero</th>
        </tr>
        <tr style="background-color:#B3B5BB">
          <td>Patente</td>
          <td>Buque nombre</td>
        </tr> 
        </thead>
        <?php
         foreach ($buque_petrolero as $b_pet) {
          echo "<tr>  <td>$b_pet[0]</td> 
                      <td>$b_pet[1]</td> </tr>";}
        ?>
      </table>
      
    </div>
  </div>
</div>

<br>
<br>

<form action="../index.php" method="get" class="d-flex justify-content-center">
    <input type="submit" class="btn btn-primary" value="Volver inicio">
</form>

</body>

</html>