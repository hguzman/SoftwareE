<?php
include "conexion.php";
$consulta = "DELETE FROM email where idEmail=".$_GET['idEmail'];
$resultado = mysql_query($consulta);
if ($resultado==0)
{
  mysql_close();
  echo "Error en la Ejecución de la Consulta";
  exit;
} 
 mysql_close(); 
 header("Location: verEmail.php?idPersona=".$_GET['idPersona']);
?>

