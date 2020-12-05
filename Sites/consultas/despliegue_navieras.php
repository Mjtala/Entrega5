<?php require("../routes.php");?>
<?php require("../templates/header.php");?>

<?php
  require("../config/conexion.php");

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
                <th>Nombre Naviera</th>
              </tr>
            </thead>
            <?php foreach ($nav as $n) {
                    echo "<tr> <td><a href= 'show_ong_busqueda.php?name=$n[0]'>$n[0]</a> </td>
                          </tr>";
                  } ?>


    </table>

  </div>
</div>
</div><br>

</body>

</html>