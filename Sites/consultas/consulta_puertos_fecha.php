<?php require("../routes.php");?>
<?php 
require("../templates/header.php");
?>

<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");
  $puerto_id = $_POST["name"];
  $fecha_1 = $_POST["fdate"];
  $fecha_2 = $_POST["ldate"];
  // $año_1 = substr($fecha_1, 0, 4);
  // $day_1 = substr($fecha_1, 8, 2);
  // $mes_1 = substr($fecha_1, 5, 2);
  // $año_2 = substr($fecha_2, 0, 4);
  // $day_2 = substr($fecha_2, 8, 2);
  // $mes_2 = substr($fecha_2, 5, 2);
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
  # CAMBIAR EL 1
 	$query = "SELECT id_instalacion FROM pertenece_a WHERE $puerto_id = pertenece_a.id_puerto ;";
	$result = $db -> prepare($query);
	$result -> execute();
  $instalacion_id = $result -> fetchAll();

  foreach ($instalacion_id as $instalacion) {
    $query2 = "SELECT instalaciones.cap_buques FROM instalaciones WHERE $instalacion[0] = instalaciones.id_instalacion;";
    $result2 = $db -> prepare($query2);
    $result2 -> execute();
    $cap_buques = $result2 -> fetchAll();

    foreach ($array as $fecha) {

      $cap_buques_number = $cap_buques[0][0];
      
      $sql = "SELECT * FROM calcular_capacidad($instalacion[0], '$fecha', $cap_buques_number);";
     
      $stmt = $db->prepare($sql);
      $stmt -> execute();
      $resultados = $stmt -> fetchAll();
      #echo "fin";

      // if(!$stmt -> execute()){
      //   echo $instalacion[0];
      //   echo gettype($fecha);
      //   echo $cap_buques[0][0];
      //   echo "No funciona";
      // }

      foreach ($resultados as $r){
            echo "<table class='container'>";
            echo "<tr><th>ID</th><th>Días con disponibilidad</th><th>Portcentaje promedio de ocupación</th></tr>";
            echo "<tr><td>{$r['id']}</td><td>{$r['dias_disponibles']}</td><td>{$r['porcentaje_ocupacion']}%</td></tr>";
            echo "</table>";
            echo "<p></p>";}
    }}
      #if($stmt = $db->prepare($sql)){
        #$stmt->bindParam(":puerto_id", $param_puerto_id, PDO::PARAM_INT);
        #$stmt->bindParam(":instalacion", $param_instalacion, PDO::PARAM_INT);
        #$stmt->bindParam(":fecha", $param_fecha, PDO::PARAM_STR);
        #$stmt->bindParam(":cap_buques", $param_cap_buques, PDO::PARAM_INT);

        #$param_instalacion = $instalacion[0];
        #$param_fecha = $fecha;
        #$param_cap_buques = $cap_buques[0][0];

        #$param_puerto_id = $puerto_id;

        #echo gettype($param_instalacion). "fin";
        #echo gettype($param_fecha). "fin";
        #echo gettype($param_cap_buques). "fin";

        #echo "<p></p>";

        #echo gettype($instalacion[0]);
        #echo gettype($fecha);
        #echo gettype($cap_buques[0][0]);

        #if($stmt->execute()){
          #if($stmt->rowCount() < 1){
            #echo "<h2 class='display-4'>Capacidad de instalaciones:</h2>";
            #echo "<h2 class='display-4'>No hay capacidad disponible</h2>";
          #} else{
          #$resultados = $stmt -> fetchAll();
          #foreach ($resultados as $r){
            #echo "<table class='container'>";
            #echo "<tr><th>ID</th><th>Días con disponibilidad</th><th>Portcentaje promedio de ocupación</th></tr>";
            #echo "<tr><td>{$r['id']}</td><td>{$r['dias_disponibles']}</td><td>{$r['porcentaje_ocupacion']}</td></tr>";
            #echo "</table>";
            #echo "<p></p>";
            #} 
          #}
        #} else{
            #print_r($puerto_id);
            #print_r($instalacion[0]);
            #print_r($fecha);
            #print_r($cap_buques[0][0]);
            #print_r($stmt->errorInfo());
            #echo "Something went wrong. Please try again later."; 
      #}
      #unset($stmt);
      #}
      #unset($db_par);

    
    #echo "inicio" .$instalacion[0]. "fin";
    #echo "inicio" .$cap_instalacion[0][0]. "fin";
  #}
  #}
  



  ?>

<?php include('../templates/footer.html'); ?>
