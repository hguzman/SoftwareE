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

$swRegisto="not";
if (isset($_POST['submitted'])) {  

	require_once (MYSQL);	
	 
	$errors = array();
	$trimmed = array_map('trim', $_POST);	
	 
	$nombre = $apellido = $email = $nDocumento = $telefono = $celular = $tDocumento = $rUsuario = FALSE;	
 	$telefono = $celular = 0;
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['nombre'])) {
		$nombre = mysqli_real_escape_string ($dbc, $trimmed['nombre']);
	} else {
		$errors[] = 'Digite nombres.';
	}
		 
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['paterno'])) {
		$paterno = mysqli_real_escape_string ($dbc, $trimmed['paterno']);
	} else {
		$errors[] = 'Digite apellido paterno.';
	}	 
	
	
	
	$materno = "";	 
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['materno'])) {
		$materno = mysqli_real_escape_string ($dbc, $trimmed['materno']);
	} 
	 
	//echo $tDocumento." Rol";
	$cedula = 0 ;
	
	if (preg_match ('/^\d+$/', $trimmed['cedula'])) {
		$cedula = mysqli_real_escape_string ($dbc, $trimmed['cedula']);
		
	} 
	
	// *************************************************************************
	if (preg_match ('/^\d+$/', $trimmed['telefono'])) {
		$telefono = mysqli_real_escape_string ($dbc, $trimmed['telefono']);
		
	} else {
		$errors[] = 'Digite numero de telefono.';
	}	
	
	if (!empty($_POST['descripcion_t'])) {
		$descripcion_t = $_POST['descripcion_t'];
	} else {
		$errors[] = 'Digite descripcion del telefono.';
	}				
	
	
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$email = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		$errors[] = 'Digite correo electrónico.';
	}
	
	if (!empty($_POST['descripcion_c'])) {
		$descripcion_c = $_POST['descripcion_c'];
	} else {
		$errors[] = 'Digite descripcion para el correo.';
	}				
	
	$alias = "";	 
	/*if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['alias'])) {
		$apellido = mysqli_real_escape_string ($dbc, $trimmed['alias']);
	} else {
		$errors[] = 'Digite alias.';	
	}*/
		
 	if (empty($errors)) {
				
	//	$q1 = "SELECT idPersona FROM personas WHERE cedula='$cedula'";
	//	$r1 = mysqli_query ($dbc, $q1) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
	//	if (mysqli_num_rows($r1) == 0) { 			
			    // Administrador
				$q = "INSERT INTO personas ( nombres, paterno ,materno, cedula, alias) VALUES ('$nombre', '$paterno' , '$materno', '$cedula', '$alias' )";			
			
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) {
					
					include "conexion.php";
					
					$rs = mysql_query("SELECT MAX(idPersona) AS id FROM personas");
					if ($row = mysql_fetch_row($rs)) {
						$idPersona = trim($row[0]);
					}
					
					$q = "INSERT INTO email ( idPersona, email ,descripcion) VALUES ($idPersona, '$email' , '$descripcion_c')";					
					$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
					
					$q1 = "INSERT INTO telefono ( idPersona, numero ,descripcion) VALUES ($idPersona, '$telefono' , '$descripcion_t')";					
					$r1 = mysqli_query ($dbc, $q1) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
					
					
					
					mysql_close();  					
										 	
					echo '<p align="center">Se ha agreado un nuevo registro.</p>';
				//	echo '<p align="center"><img src="images/dialog-apply.png" width="56" height="56" /></p>';
				//	echo '<p align="center">';
					
				//	echo '<a href="#'.$idPersonas .'">¿Vincular Numero Celular?</a><br />';  
				//	echo '<a href="#'.$idPersonas .'">¿Vincular Direccion Celular?</a><br />';  
					echo '<a href="verPersonas.php">Volver</a>';  
					  
				//	echo   ' - <a href="addUsuario.php">¿Agregar Persona?</a>
				//		 </p>';							
				# ----------------------------------------------------------------------------------------
				$swRegisto="ok";
				 
				
			} else {  
				echo '<p class="error">El usuario no ha sido registrado, debido a un error del sistema. Pedimos disculpas por las molestias.</p>';
			}
			
	/*	}else
			echo '<p><font color="#9e1b34"><b>Por favor, inténtelo de nuevo.</b></p></font><ol>';  
		if(mysqli_num_rows($r1) != 0 ){  
			echo '<li>Esta cedula ya esta registrada.</li>';
		}		 
		if(mysqli_num_rows($r1) != 0 )
			echo '</ol><br />';		*/
		
	} else { 		
		echo '<p><font color="#9e1b34"><b>Por favor, inténtelo de nuevo.</b></p></font><ol>';
		foreach ($errors as $msg) { 
			echo "<li>$msg</li>";
		}
		echo '</ol><br />';
	
	}
} 
?>
<?php	
	
if($swRegisto=="not"){
?>
<center>
<form name="t" action="personas.php" method="post" enctype="multipart/form-data">
<br />
<script type="text/javascript" src="js/btn.js"></script>
	
	<table align="center">
    
     <TR>
	<TD align="left" colspan="2"><b>Informacion personal --------------------------------------</b></TD>	 
	</TR>
    
	 <TR>
		<TD align="left">* Nombres</TD>
		<TD align="left"> <input type="text" name="nombre" size="30" maxlength="50" value="<?php if (isset($trimmed['nombre'])) echo 	$trimmed['nombre']; ?>" class="input" /></TD>
	</TR>
	
	<TR>
	<TD align="left">* Paterno</TD>
	<TD align="left"> <input type="text" name="paterno" size="30" maxlength="50" value="<?php if (isset($trimmed['paterno'])) echo $trimmed['paterno']; ?>" class="input" /></TD>
	</TR>
    
    <TR>
	<TD align="left">Materno</TD>
	<TD align="left"> <input type="text" name="materno" size="30" maxlength="50" value="<?php if (isset($trimmed['materno'])) echo $trimmed['materno']; ?>" class="input" /></TD>
	</TR>	
		
	<TR>
	<TD align="left">Cedula</TD>
	<TD align="left"> <input type="text" name="cedula" size="30" maxlength="40" value="<?php if (isset($trimmed['cedula'])) echo $trimmed['cedula']; ?>"  class="input" /></TD>
	</TR>   

    
    <TR>
	<TD align="left">Alias</TD>
	<TD align="left"> <input type="text" name="alias" size="30" maxlength="40" value="<?php if (isset($trimmed['alias'])) echo $trimmed['alias']; ?>"  class="input" /></TD>
	</TR> 
    
    <TR>
	<TD align="left" colspan="2"><b>Informacion de contacto ----------------------------------</b></TD>	 
	</TR>
    
    <TR>
	<TD align="left">* Telefono</TD>
	<TD align="left"> <input type="text" name="telefono" size="30" maxlength="40" value="<?php if (isset($trimmed['telefono'])) echo $trimmed['telefono']; ?>"  class="input" /></TD>
	</TR>   

    
    <TR>
	<TD align="left">* Descripcion</TD>
	<TD align="left"> <input type="text" name="descripcion_t" size="30" maxlength="40" value="<?php if (isset($trimmed['descripcion_t'])) echo $trimmed['descripcion_t']; ?>"  class="input" /></TD>
	</TR> 
    
     
    
    <TR>
	<TD align="left">* Correo-e</TD>
	<TD align="left"> <input type="text" name="email" size="30" maxlength="40" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>"  class="input" /></TD>
	</TR>   

    
    <TR>
	<TD align="left">* Descripcion</TD>
	<TD align="left"> <input type="text" name="descripcion_c" size="30" maxlength="40" value="<?php if (isset($trimmed['descripcion_c'])) echo $trimmed['descripcion_c']; ?>"  class="input" /></TD>
	</TR> 
    
    <TR>
    <TD colspan="2">
		<div align="left"><br />* Estos campos son requeridos</div>
		       
	</TD>
	</TR>
    <TR>
	<TD colspan="2">
		<div align="center"><input type="Submit" id="submit_btn" value="Aceptar" class="btn green" /></div>
		<input type="hidden" name="submitted" value="TRUE" />         
	</TD>
	</TR>
	</table>
	<br />
</form>
</center>

<br />
<?php
}else{
  echo "<br /><br /><br /><br />";
}


?>
        
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