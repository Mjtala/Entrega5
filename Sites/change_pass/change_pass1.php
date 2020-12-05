<?php
require("../routes.php");
session_start();
include($CHANGE_PASS_2_ROUTE);
require("../templates/header.php");
?>

<br>
<div class=container>
<div class="row justify-content-md-center">
<div class="card text-center text-white bg-dark w-75">
  <div class="card-body">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="false">
      <div class="carousel-inner">
        <div class="container">
          <div class="row justify-content-md-center w-50">
            <div class="carousel-item active">
              <h2 class="card-title">Cambia tu contraseña aquí</h2>
                <?php include('change_pass_form.php');?>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
</div>
</div>
</body>
</html>