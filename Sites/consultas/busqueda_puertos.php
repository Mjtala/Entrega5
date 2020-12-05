<?php require("../routes.php");?>
<?php 
require("../templates/header.php");
?>

<html>
<head>
<link rel="../css/pages.css" href="pages.css">
</head>
<body>

<div class=container>
  <div class="row justify-content-center">
<div class= "two-forms-display">

  <div class= "forms">

    <br>
      <h1>Fechas con capacidad de instalaciones</h1>
      <?php
      require("../config/conexion.php");
      $puerto_id = $_GET["name"];
      ?>
      <form action="consulta_puertos_fecha.php" method="post">
        <label for="fdate">Id puerto:</label><br>
        <input type="text" value= "<?php echo $puerto_id ?>" id="name" name="name" readonly><br>
        <label for="fdate">First date:</label><br>
        <input type="date" id="fdate" name="fdate"><br>
        <label for="ldate">Last date:</label><br>
        <input type="date" id="ldate" name="ldate"><br><br>
        <input type="submit" value="Submit">
      </form> 
    </div>

    
    <div class= "forms">
    <h1>Capacidad instalaciones para buques</h1>
    <?php if(!isset($_REQUEST['submit'])):?>
    <form method="post" action="">
      <label for="type">Tipo Instalación:</label><br>
      <input type="text" name="inputtext" placeholder="Astillero o Muelle"><br>
      <input type="submit" name="submit" value="Submit">
      </form> 
    <?php endif ?>

    <?php if(isset($_REQUEST['submit'])):?>
      <?php if($_REQUEST['inputtext']=='Astillero'):?>
        <form action="consulta_instalacion_astillero.php">
        <label for="date">Instalación:</label><br>
        <input type="text" value= "<?php echo $puerto_id ?>" id="name" name="name" readonly><br>
        <label for="date">Ingresa primera fecha:</label><br>
        <input type="date" name="firstdate"><br><br>
        <label for="ldate">Ingresa segunda fecha:</label><br>
        <input type="date" name="secdate"><br><br>
        <label for="date">Ingresa patente del buque:</label><br>
        <input type="text" name="patente" placeholder="Patente"><br>
        <input type="submit" value="Submit">
        </form> 
      <?php elseif($_REQUEST['inputtext']=="Muelle"):?>
      <form action="consulta_instalacion_muelle.php">
      <label for="date">Instalación:</label><br>
      <input type="text" value= "<?php echo $puerto_id ?>" id="name" name="name" readonly><br>
        <label for="date">Ingresa la fecha:</label><br>
          <input type="date" id="date" name="date"><br><br>
          <label for="date">Ingresa patente del buque:</label><br>
          <input type="text" name="patente" placeholder="Patente"><br>
          <input type="submit" value="Submit">
        </form> 
      <?php  else: ?>
      <form method="post" action="">
      <label for="type">Tipo Instalación:</label><br>
      <input type="text" name="inputtext" placeholder="Astillero o Muelle"><br>
      <input type="submit" name="submit" value="Submit">
      </form> 
        <?php echo "Incorrecto. Ingresa Astillero o Muelles." ;?>
      <?php endif ?>
    <?php endif ?>
      
    </div>
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