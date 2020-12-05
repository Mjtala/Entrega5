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
        <input type="hidden" name="signup" />
        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>  <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>  <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
          <div class="form-row justify-content-center">
            <div class="col"><input type="text" class="form-control" name="firstname" placeholder="Nombre"></div>
            <div class="col"><input type="text" class="form-control" name="lastname" placeholder="Apellido"></div>
          </div>
          <div class="row justify-content-center">
            <div class="col-sm"><span class="help-block text-danger"><?php echo $firstname_err; ?></span></div>
            <div class="col-sm"><span class="help-block text-danger"><?php echo $lastname_err; ?></span></div>
          </div>
          <span class="help-block text-danger"><?php echo $user_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($edad_err)) ? 'has-error' : ''; ?>  <?php echo (!empty($sexo_err)) ? 'has-error' : ''; ?>">
            <div class="form-row justify-content-center">
                <div class="col"><input type="text" class="form-control" name="edad" placeholder="Edad"></div>
                <div class="col"><input type="text" class="form-control" name="sexo" placeholder="Sexo"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm"><span class="help-block text-danger"><?php echo $edad_err; ?></span></div>
                <div class="col-sm"><span class="help-block text-danger"><?php echo $sexo_err; ?></span></div>
            </div>
        </div>
        <div class="form-group <?php echo (!empty($pasaporte_err)) ? 'has-error' : ''; ?>  <?php echo (!empty($nacionalidad_err)) ? 'has-error' : ''; ?>">
            <div class="form-row justify-content-center">
                <div class="col"><input type="text" class="form-control" name="pasaporte" placeholder="Número de pasaporte"></div>
                <div class="col"><input type="text" class="form-control" name="nacionalidad" placeholder="Nacionalidad"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm"><span class="help-block text-danger"><?php echo $pasaporte_err; ?></span></div>
                <div class="col-sm"><span class="help-block text-danger"><?php echo $nacionalidad_err; ?></span></div>
            </div>
        </div>
        <div class="form-group <?php echo (!empty($pass_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="password" class="form-control" placeholder="Contraseña">
            <span class="help-block text-danger"><?php echo $pass_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_pass_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar contraseña">
            <span class="help-block text-danger"><?php echo $confirm_pass_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Registrar">
            <input type="reset" class="btn btn-light" value="Limpiar">
        </div>
        <?php echo "<p>¿Ya estás registrado? Inicia sesión <a href=$LOG_IN_ROUTE>aquí</a>.</p>"; ?>
    </form>
</div>