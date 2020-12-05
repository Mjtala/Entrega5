<?php require("../routes.php");?>
<?php 
require("../templates/header.php");
?>

<body>

<?php
    require("../config/conexion.php");
    $puerto_id = $_GET["name"];
    $fecha = $_GET["date"];
    $patente = $_GET["patente"];

    $query = "SELECT id_instalacion FROM pertenece_a WHERE $puerto_id = pertenece_a.id_puerto ;";
    $result = $db -> prepare($query);
    $result -> execute();
    $instalacion_id = $result -> fetchAll();
?>

    <div class=container>
    <div class="row justify-content-center">
    <div class= "two-forms-display">
    <?php
    $asignar_permiso = false;
    foreach ($instalacion_id as $instalacion) {
        $query2 = "SELECT instalaciones.cap_buques FROM instalaciones WHERE $instalacion[0] = instalaciones.id_instalacion;";
        $result2 = $db -> prepare($query2);
        $result2 -> execute();
        $cap_buques = $result2 -> fetchAll();

        $cap_buques_number = $cap_buques[0][0];
        $sql = "SELECT * FROM calcular_capacidad($instalacion[0], '$fecha', $cap_buques_number);";
        $stmt = $db->prepare($sql);
        $stmt -> execute();
        $resultados = $stmt -> fetchAll();

        

        foreach ($resultados as $r)
        {
            if($r['dias_disponibles'] && !$asignar_permiso)
            {
                echo "<br>";
                echo "<br>";
                echo "Hay una instalación disponible para la fecha: $fecha";
                echo "<br>";
                echo "Hemos generado un permiso para el buque de patente: $patente";
                $inserting = "INSERT INTO permisos_muelle(fecha_atraque, patente_barco, id_instalacion) VALUES ('$fecha', '$patente', '$instalacion[0]');";
                $result3 = $db-> prepare($inserting);
                $result3 -> execute();
                $asignar_permiso = true;
            }
        }
        if ($asignar_permiso)
        {
            break;
        }
    }
    if (!$asignar_permiso)
    {
        echo "<br>";
        echo "<br>";
        echo "No hay ninguna instalación disponible para la fecha: $fecha";
        echo "<br>";
    }
    ?>

<?php include('../templates/footer.html'); ?>
</div>
    </div>
    </div>