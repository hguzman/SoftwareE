<?php // mysqli_connect.php

// Este archivo contiene la información de acceso de base de datos.
// Este archivo también se establece una conexión con MySQL
// y selecciona la base de datos.

// Establecer la base de datos de acceso a la información como constantes:
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'usrio01');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'bd_se');

// Hacer conexion:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
}

?>
