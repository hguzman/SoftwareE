<?php
include "conexion.php";
$consulta = "DELETE FROM direccion where idDireccion=".$_GET['idDireccion'];
$resultado = mysql_query($consulta);
if ($resultado==0)
{
  mysql_close();
  echo "Error en la Ejecución de la Consulta";
  exit;
} 
 mysql_close(); 
 header("Location: verDireccion.php?idPersona=".$_GET['idPersona']);
?>

