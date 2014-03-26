<?php
include "conexion.php";
$consulta = "DELETE FROM telefono where idTelefono=".$_GET['idTelefono'];
$resultado = mysql_query($consulta);
if ($resultado==0)
{
  mysql_close();
  echo "Error en la Ejecución de la Consulta";
  exit;
} 
 mysql_close(); 
 header("Location: verTelefono.php?idPersona=".$_GET['idPersona']);
?>

