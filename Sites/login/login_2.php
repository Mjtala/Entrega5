<?php

// // Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: $MI_PERFIL_VIEW_ROUTE");
//     exit;
// }

// Include config file
require($CONFIG_ROUTE);

// Define variables and initialize with empty values
$pass_err = $pasaporte_err = $param_p = $param_u = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["loggin"])){

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

    // Validate password
    if(empty(trim($_POST["password"]))){
        $pass_err = "Ingresa una contraseña.";
    } else{
        $param_p = trim($_POST["password"]);
        $param_u = trim($_POST["pasaporte"]);
        $query = "SELECT contraseña FROM usuarios_registrados WHERE pasaporte = '$param_u';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        $verify_ = password_verify(strval($param_p), strval($result[0][0]));

        if (!empty($result) && $verify_) {
            $password = trim($_POST["password"]);
        }else{
            $pass_err = "Contraseña incorrecta.";
        }
    }

    // Check input errors before inserting in database
    if(empty($pasaporte_err) && empty($pass_err)){
        // Store data in session variables
        $param_u = trim($_POST["pasaporte"]);
        $query = "SELECT id, nombre, edad, sexo, nacionalidad FROM usuarios_registrados  WHERE pasaporte LIKE '%$param_u';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        
        $id = $result[0][0];
        $name = $result[0][1];
        $edad = $result[0][2];
        $sexo = $result[0][3];
        $nacionalidad = $result[0][4];

        session_start();
        # SE ESTÁN GUARDANDO LAS VARIABLES
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["nombre"] = $name;
        $_SESSION["edad"] = $edad;
        $_SESSION["sexo"] = $sexo;
        $_SESSION["nacionalidad"] = $nacionalidad;
        $_SESSION["pasaporte"] = $param_u;
        header("location: $MI_PERFIL_VIEW_ROUTE");
      }
}
?>