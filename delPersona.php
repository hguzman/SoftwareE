<?php
include "conexion.php";
$consulta = "DELETE FROM personas where idPersona=".$_GET['idPersona'];
$resultado = mysql_query($consulta);
if ($resultado==0)
{
  mysql_close();
  echo "Error en la Ejecución de la Consulta";
  exit;
} 
 mysql_close(); 
 header("Location: verPersonas.php");
?>

