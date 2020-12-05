<div class="wrapper">
  <script>
  $('#carouselExampleFade').on('slid.bs.carousel', function () {
  var currentSlide = $('#carouselExampleFade div.active').index();
  sessionStorage.setItem('lastSlide', currentSlide);
  });
  if(sessionStorage.lastSlide){
    $("#carouselExampleFade").carousel(sessionStorage.lastSlide*1);
  }
  </script>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="loggin" />
        <div class="form-group <?php echo (!empty($pasaporte_err)) ? 'has-error' : ''; ?>  <?php echo (!empty($nacionalidad_err)) ? 'has-error' : ''; ?>">
            <div class="form-row justify-content-center">
                <div class="col"><input type="text" class="form-control" name="pasaporte" placeholder="Número de pasaporte"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm"><span class="help-block text-danger"><?php echo $pasaporte_err; ?></span></div>
            </div>
        </div>
        <div class="form-group <?php echo (!empty($pass_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="password" class="form-control" placeholder="Contraseña">
            <span class="help-block text-danger"><?php echo $pass_err; ?></span>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Entrar">
            <input type="reset" class="btn btn-light" value="Limpiar">
        </div>
        <?php echo "<p>¿No estás registrado? Registrate <a href=$SIGN_UP_ROUTE>aquí</a>.</p>"; ?>
    </form>
</div>