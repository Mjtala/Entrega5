<?php
require("../routes.php");
require($CONFIG_ROUTE);

#Obtenemos todos los jefes de instalaciones (nombre, edad, sexo, rut) que no están registrados
$query = "SELECT persona.nombre, persona.edad, persona.sexo, instalaciones.rut_jefe FROM instalaciones, persona WHERE instalaciones.rut_jefe = persona.rut;";
$result = $db -> prepare($query);
$result -> execute();
$jefes_no_registrados = $result -> fetchAll();

$pass = password_hash(123456789, PASSWORD_DEFAULT);
foreach ($jefes_no_registrados as $jefe) {
$register = "INSERT INTO usuarios_registrados(nombre, edad, sexo, pasaporte, nacionalidad, contraseña) VALUES ('$jefe[0]', $jefe[1], '$jefe[2]', '$jefe[3]', NULL, '$pass');";
$result3 = $db-> prepare($register);
$result3 -> execute();
}
?>



