<?php 
require_once ('includes/config.inc.php'); 

ob_start();

session_start();	

	if (!$_SESSION['nDocumento'] == 72555555) {	 	 
		$url = BASE_URL . 'index.php';  
		ob_end_clean();  
		header("Location: $url");
		exit();  
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Software ELectoral ::</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />

</head>

<body class="oneColFixCtrHdr">

    <div id="container">
      <div id="header">
        <h1>&nbsp;</h1>
      <!-- end #header --></div>
      <div id="mainContent">
        <h1>&nbsp;</h1>
        <p>
		
        <?php 

include "conexion.php";
/*consulta = "SELECT * FROM cursos WHERE idDetCurso=".$_GET['idDetCurso'];

$resultado=mysql_query($consulta);

$numFicha=mysql_result($resultado,0,'numFicha');
$nomFicha=mysql_result($resultado,0,'nomFicha');
$jornada=mysql_result($resultado,0,'jornada');
mysql_close();*/
if ( (isset($_GET['idDetCurso'])) && (is_numeric($_GET['idDetCurso'])) ) {
$consulta = "SELECT *  FROM detcurso, cursos 
  WHERE detcurso.idCurso = cursos.idCurso AND detcurso.idDetCurso =".$_GET['idDetCurso'];
  
	$resultado=mysql_query($consulta);
	if($registro=mysql_fetch_array($resultado)){
		$numFicha = $registro['numFicha'];
		$nomFicha = $registro['nomFicha'];
		$jornada = $registro['jornada'];
		$fechaInicio = $registro['fechaInicio'];
		$fechaFin = $registro['fechaFin'];
	 }	

// Este script recupera todos los registros.

}
require_once ('mysqli_connect.php');

// Numero de registros por pagina:
$display = 15;


if (isset($_GET['p']) && is_numeric($_GET['p'])) { 
	$pages = $_GET['p'];
} else { 
 	
	$q = "SELECT COUNT(idPersona) FROM personas";	

	
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	
	if ($records > $display) { 
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
} 


if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';


switch ($sort) {
	case 'ti':
		$order_by = 'titulo ASC';
		break;
	case 'de':
		$order_by = 'descripcion ASC';
		break;
	/*case 'rd':
		$order_by = 'registration_date ASC';
		break;*/
	default:
		$order_by = 'descripcion ASC';
		$sort = 'de';
		break;
}
	
//echo $records;
$q = "SELECT * FROM personas ORDER BY nombres ASC LIMIT $start, $display";	
	
$r = @mysqli_query ($dbc, $q); 

echo '<p align="center"><table cellspacing="8" cellpadding="8" class="tabla">';
 

	echo '<tr>
	<td><img src="images/adduser.png" width="38" heigth="38"/></td><td><a href="personas.php">Agregar personas</a></td>
</tr>';

	echo '<tr><td><img src="images/buser.png" width="38" heigth="38"/></td><td><a href="buscarPersona.php">Buscar usuario</a></td></tr>';
	

echo '</table>
</p>'; 
 

//echo '<p align=left>________________________________________________________</p>';
//echo '<br /><div class="agregar">Listado de usuarios</div><br />';
echo '<table align="center" class="customers">
<tr>
	<th align="left"><b>Editar</b></th>
	<th align="left"><b>Eliminar</b></th>
	<th align="left"><b>Nombre</b></th>
	<th align="left"><b>Paterno</b></th>
	<th align="left"><b>Materno</b></th>
	<th align="left"><b>Cedula</b></th>
	<th align="left"><b>Alias</b></th>
	
	
</tr>
';


$bg = '#f3f3f3'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='<tr class="alt" >' ? '<tr>' : '<tr class="alt" >');
		echo $bg;
	
	
		echo '<td align="left"><a href="editPersona.php?idPersona=' . $row['idPersona'] . '"><img src="images/preferences-composer.png" width="32" height="32" /></a></td>';
	
		echo '<td align="left"><a href="delPersona.php?idPersona=' . $row['idPersona'] . '" onclick="return confirmSubmit()"><img src="images/error.png" width="32" height="32" /></a></td>';
	
		echo '<td align="left">' . $row['nombres'] . '</td>';	
		echo '<td align="left"><a href="opciones.php?idPersona=' . $row['idPersona'] . '">' . $row['paterno'] . '</a></td>';
		echo '<td align="left">' . $row['materno'] . '</td>';
	
		echo '<td align="left">' . $row['cedula'] . '</td>';
		echo '<td align="left">' . $row['alias'] . '</td>
		
	</tr>
	';
	
} 

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);


		if ($pages > 1) {
			
			echo '<br /><p align="center">';
			$current_page = ($start/$display) + 1;
			
			
			if ($current_page != 1) {
				echo '<a href="verPersonas.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Anterior</a> ';
			}
			
			
			for ($i = 1; $i <= $pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="verPersonas.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			} 
			if ($current_page != $pages) {
				echo '<a href="verPersonas.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Siguiente</a>';
			}
			
			echo '</p>'; 
			
		} 

?>
<br />
<br />
        
        </p>
        
        <h2> </h2>
        <p> </p>
    	<!-- end #mainContent --></div>
      <div id="footer">
        <p>&nbsp;</p>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
<?php  
ob_end_flush();
?>