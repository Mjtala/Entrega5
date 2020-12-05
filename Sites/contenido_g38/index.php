
<?php 
require("routes.php"); ?>
<body>
  
  <br> 

  <p style="text-align:center;">Aquí podrás encontrar información sobre las navieras y sus correspondientes buques.</p>

  <br>

  <h3 align="center"> ¿Quieres ver los nombres de las navieras que existen?</h3>

  <form align="center" action="consultas/consulta_nombre_navieras.php" method="post">
    <input type="submit" class="btn btn-primary" value="Ver">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> Busca los buques que pertenecen a cierta naviera:</h3>
  <div class=container>
    <div class="row justify-content-center">
      <div class="col-sm">
      <form action="consultas/consulta_buques_navieras.php" method="post">
        <div class="input-group my-3">
        <input type="text" class="form-control" placeholder="Nombre naviera"
        aria-label="Buscador" aria-describedby="button-addon2" name="nombre_naviera">
          <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
  
  <br>
  <br>
  <br>

  <h3 align="center"> Busca los buques que han atracado en cierto puerto y año:</h3>
  <div class=container>
    <div class="row justify-content-center">
      <div class="col-sm">
      <form action="consultas/consulta_atraques_buques.php" method="post">
      <div class="input-group my-3">
        <input type="text" class="form-control" placeholder="Nombre puerto"
        aria-label="Buscador" aria-describedby="button-addon2" name="puerto">
        <input type="text" class="form-control" placeholder="Año atraque"
        aria-label="Buscador" aria-describedby="button-addon2" name="año_atraque">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
  <br>
  <br>

  <h3 align="center"> Busca todos los buques que han estado al mismo tiempo que otro buque en cierto puerto:</h3>
  <div class=container>
    <div class="row justify-content-center">
      <div class="col-sm">
      <form action="consultas/consulta_buques_coincidentes.php" method="post">
      <div class="input-group my-3">
        <input type="text" class="form-control" placeholder="Nombre buque"
        aria-label="Buscador" aria-describedby="button-addon2" name="buque">
        <input type="text" class="form-control" placeholder="Nombre puerto"
        aria-label="Buscador" aria-describedby="button-addon2" name="puerto">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
 
  <br>
  <br>

  <h3 align="center">  Busca el personal por cargo y sexo que han pasado por cierto puerto:</h3>
  <div class=container>
    <div class="row justify-content-center">
      <div class="col-sm">
      <form action="consultas/consulta_personal_atracado_en_puerto.php" method="post">
      <div class="input-group my-3">
        <input type="text" class="form-control" placeholder="Capitán o tripulación"
        aria-label="Buscador" aria-describedby="button-addon2" name="cargo">
        <input type="text" class="form-control" placeholder="Hombre o mujer"
        aria-label="Buscador" aria-describedby="button-addon2" name="sexo">
        <input type="text" class="form-control" placeholder="Nombre puerto"
        aria-label="Buscador" aria-describedby="button-addon2" name="puerto">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
 
  <br>
  <br>

  <h3 align="center">  Busca el buque que tiene más personas trabajando, por tipo de buque:</h3>
  <div class=container>
    <div class="row justify-content-center">
      <div class="col-sm">
      <form action="consultas/consulta_buque_max_tripulacion.php" method="post">
      <div class="input-group my-3">
        <input type="text" class="form-control" placeholder="Pesquero, carga o petrolero"
        aria-label="Buscador" aria-describedby="button-addon2" name="tipo_buque">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
  <br>
  <br>

  
</body>
</html>
