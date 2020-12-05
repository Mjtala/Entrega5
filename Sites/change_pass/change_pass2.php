<?php

// // Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: $MI_PERFIL_VIEW_ROUTE");
//     exit;
// }

// Include config file
require($CONFIG_ROUTE);

// Define variables and initialize with empty values
$new_pass_err = $confirm_new_pass_err = $old_pass_err = $pasaporte_err = $param_p = $param_u = $new_pass = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_pass"])){

    // Valida pasaporte unico
    if(empty(trim($_POST["pasaporte"]))) {
        $pasaporte_err = "Ingresa tu pasaporte.";
    }
    if(!empty(trim($_POST["pasaporte"]))){
        $param_u = trim($_POST["pasaporte"]);
        $query = "SELECT pasaporte FROM usuarios_registrados WHERE pasaporte = '$param_u';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        if (empty($result)) {
            $pasaporte_err = "No existe un usuario registrado con ese número de pasaporte.";
        }else{
            $pasaporte = trim($_POST["pasaporte"]);
        }
    }

    // Valida old password
    if(empty(trim($_POST["old_password"]))){
        $old_pass_err = "Ingresa tu contraseña antigua.";
    } else{
        $param_p = trim($_POST["old_password"]);
        $param_u = trim($_POST["pasaporte"]);
        $query = "SELECT contraseña FROM usuarios_registrados WHERE pasaporte = '$param_u';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        $verify_ = password_verify(strval($param_p), strval($result[0][0]));

        if (!empty($result) && $verify_) {
            $old_password = trim($_POST["password"]);
        }else{
            $old_pass_err = "Contraseña incorrecta.";
        }
    }

    // Validate password
    if(empty(trim($_POST["new_password"]))){
        $new_pass_err = "Ingresa una nueva contraseña.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_pass_err = "La nueva contraseña debe contener al menos 6 caracteres.";
    } else{
        $new_pass = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_new_password"]))){
        $confirm_new_pass_err = "Confirma tu nueva contraseña.";
    } else{
        $confirm_pass = trim($_POST["confirm_new_password"]);
        if(empty($new_pass_err) && ($new_pass != $confirm_pass)){
            $confirm_new_pass_err = "Las contraseñas no coinciden. $new_pass - $confirm_pass";
        }
    }


    // Check input errors before inserting in database
    if(empty($pasaporte_err) && empty($old_pass_err) && empty($new_pass_err) && empty($confirm_new_pass_err)){
        // Store data in session variables
        $param_u = trim($_POST["pasaporte"]);
        $pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $query = "UPDATE usuarios_registrados SET contraseña = '$pass' WHERE pasaporte = '$param_u';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        header("location: $MI_PERFIL_VIEW_ROUTE");
    }
}
?>