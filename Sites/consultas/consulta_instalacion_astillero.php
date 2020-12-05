<?php require("../routes.php");?>
<?php 
require("../templates/header.php");
?>

<body>

<?php
    require("../config/conexion.php");
    $puerto_id = $_GET["name"];
    $fecha_1 = $_GET["firstdate"];
    $fecha_2 = $_GET["secdate"];
    $patente = $_GET["patente"];

    $fecha_inicio = $_GET["firstdate"];
    $fecha_final = $_GET["secdate"];

    $array[] =  date("Y-m-d",strtotime($var));
    $day_count = 0;
    while(0==0)
    {
        $array[$day_count] = date("Y-m-d",strtotime($fecha_1));
        $day_count++;
        $fecha_1 = date("Y-m-d",strtotime($fecha_1 . "+1 days"));
        if ($fecha_1==$fecha_2)
        {
        break;
        }
    }

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
    $contador_fechas_disponibles = 0;
    foreach ($instalacion_id as $instalacion) {
        $query2 = "SELECT instalaciones.cap_buques FROM instalaciones WHERE $instalacion[0] = instalaciones.id_instalacion;";
        $result2 = $db -> prepare($query2);
        $result2 -> execute();
        $cap_buques = $result2 -> fetchAll();

        $cap_buques_number = $cap_buques[0][0];

        foreach ($array as $fecha) {
            $cap_buques_number = $cap_buques[0][0];
      
            $sql = "SELECT * FROM calcular_capacidad($instalacion[0], '$fecha', $cap_buques_number);";
            $stmt = $db->prepare($sql);
            $stmt -> execute();
            $resultados = $stmt -> fetchAll();
            foreach ($resultados as $r)
            {
                if($r['dias_disponibles'] && !$asignar_permiso)
                {
                    $contador_fechas_disponibles += 1;
                }
            }
            if ($asignar_permiso)
            {
                break;
            }
        }
        if ($contador_fechas_disponibles == $day_count)
            {
                echo "<br>";
                echo "<br>";
                echo "Hay una instalación disponible desde la fecha $fecha_inicio a la fecha $fecha_final.";
                echo "<br>";
                echo "Hemos generado un permiso para el buque de patente: $patente.";
                $asignar_permiso = true;
                $inserting = "INSERT INTO permisos_muelle(fecha_atraque, patente_barco, id_instalacion, fecha_salida)        
                VALUES ('$fecha_1', '$patente', '$instalacion[0]', '$fecha_2');";
                $result3 = $db-> prepare($inserting);
                $result3 -> execute();
                break;
            }
        else{
            $contador_fechas_disponibles = 0;
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