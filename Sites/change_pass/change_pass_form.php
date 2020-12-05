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
        <input type="hidden" name="change_pass" />
        <div class="form-group <?php echo (!empty($pasaporte_err)) ? 'has-error' : ''; ?>  <?php echo (!empty($nacionalidad_err)) ? 'has-error' : ''; ?>">
            <div class="form-row justify-content-center">
                <div class="col"><input type="text" class="form-control" name="pasaporte" placeholder="Número de pasaporte"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm"><span class="help-block text-danger"><?php echo $pasaporte_err; ?></span></div>
            </div>
        </div>
        <div class="form-group <?php echo (!empty($old_pass_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="old_password" class="form-control" placeholder="Contraseña antigua">
            <span class="help-block text-danger"><?php echo $old_pass_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($new_pass_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="new_password" class="form-control" placeholder="Nueva contraseña">
            <span class="help-block text-danger"><?php echo $new_pass_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_new_pass_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirmar nueva contraseña">
            <span class="help-block text-danger"><?php echo $confirm_new_pass_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Entrar">
            <input type="reset" class="btn btn-light" value="Limpiar">
        </div>
        <?php echo "<p>¿No estás registrado? Registrate <a href=$SIGN_UP_ROUTE>aquí</a>.</p>"; ?>
    </form>
</div>