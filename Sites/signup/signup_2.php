<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: $INDEX_ROUTE");
    #borrar cuando se implemente login
    session_destroy();
    exit;
}
// Include config file
require($CONFIG_ROUTE);
// Define variables and initialize with empty values
$user_name = $pass = $confirm_pass = "";
$firstname_err = $lastname_err = $user_err = $pass_err = $confirm_pass_err = $edad_err = $sexo_err = $pasaporte_err = 
$nacionalidad_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])){

    if(empty(trim($_POST["firstname"]))) {
        $firstname_err = "Ingresa tu nombre";
    }
    if(empty(trim($_POST["lastname"]))) {
        $lastname_err = "Ingresa tu apellido";
    }
    if(!empty(trim($_POST["lastname"])) && !empty(trim($_POST["firstname"]))){
        $user_name = trim($_POST["firstname"])." ".trim($_POST["lastname"]);
    }
    // Valida pasaporte unico
    if(empty(trim($_POST["pasaporte"]))) {
        $pasaporte_err = "Ingresa tu pasaporte.";
    }
    if(!empty(trim($_POST["pasaporte"]))){
        $param = trim($_POST["pasaporte"]);
        $query = "SELECT pasaporte FROM usuarios_registrados WHERE pasaporte = '$param';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        if (!empty($result)) {
            $pasaporte_err = "Ya existe un usuario con este número de pasaporte.";
        }else{
            $pasaporte = $param ;
        }
    }
    //Otros datos 
    if(empty(trim($_POST["edad"]))) {
        $edad_err = "Ingresa tu edad";
    }
    if(!empty(trim($_POST["edad"]))){
        if((int)trim($_POST["edad"]) > 140 or (int)trim($_POST["edad"]) < 1 ){
            $edad_err = "Ingresa una edad válida.";
            }
        else{
            $edad = (int)trim($_POST["edad"]);
        }
    }
    
    if(empty(trim($_POST["sexo"]))) {
        $sexo_err = "Ingresa tu sexo";
    }
    if(!empty(trim($_POST["sexo"]))){
        if((trim($_POST["sexo"]) != "mujer") and (trim($_POST["sexo"]) != "hombre")){
            $sexo_err = "Ingresa hombre o mujer";
            }
        else{
            $sexo = trim($_POST["sexo"]);
        } 
    }  
    if(empty(trim($_POST["nacionalidad"]))) {
        $nacionalidad_err = "Ingresa tu nacionalidad";
    }else{
        $nacionalidad = trim($_POST["nacionalidad"]);
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $pass_err = "Ingresa una contraseña.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $pass_err = "La contraseña debe contener al menos 6 caracteres.";
    } else{
        $pass = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_pass_err = "Confirma tu contraseña.";
    } else{
        $confirm_pass = trim($_POST["confirm_password"]);
        if(empty($pass_err) && ($pass != $confirm_pass)){
            $confirm_pass_err = "Las contraseñas no coinciden.";
        }
    }

    // Check input errors before inserting in database
    if(empty($user_err) && empty($firstname_err) && empty($lastname_err) && empty($pass_err) && empty($confirm_pass_err)
    && empty($edad_err) && empty($sexo_err)  && empty($nacionalidad_err) && empty($pasaporte_err)){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $edad = (int)$edad;
        $register = "INSERT INTO usuarios_registrados(nombre, edad, sexo, pasaporte, nacionalidad, contraseña) VALUES ('$user_name', $edad, '$sexo', '$pasaporte', '$nacionalidad', '$pass');";
        $result = $db-> prepare($register);
        $result -> execute();
        $query = "SELECT id FROM usuarios_registrados WHERE nombre LIKE '$user_name';";
        $result = $db -> prepare($query);
        $result -> execute();
        $result = $result -> fetchAll();
        $id = $result[0][0];
        session_start();

        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["name"] = $user_name;
        header("location: $INDEX_ROUTE");
      }
}
?>
