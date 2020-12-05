<?php
require("../routes.php");
require($CONFIG_ROUTE);

#Obtenemos los capitanes (nombre, edad, genero, pasaporte, nacionalidad) que no están registrados
$query = "SELECT nombre, edad, genero, pasaporte, nacionalidad FROM personal WHERE cargo = 'capitan';";
$result = $db38 -> prepare($query);
$result -> execute();
$capitanes_no_registrados = $result -> fetchAll();

$pass = password_hash(123456789, PASSWORD_DEFAULT);
foreach ($capitanes_no_registrados as $capitan) {
$register = "INSERT INTO usuarios_registrados(nombre, edad, sexo, pasaporte, nacionalidad, contraseña) VALUES ('$capitan[0]', $capitan[1], '$capitan[2]', '$capitan[3]', '$capitan[4]', '$pass');";
$result3 = $db-> prepare($register);
$result3 -> execute();
}
?>