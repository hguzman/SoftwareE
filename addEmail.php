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


$hUsuario = "";
if ( (isset($_GET['idPersona'])) && (is_numeric($_GET['idPersona'])) ) {  
	$idPersona = $_GET['idPersona'];
	$hUsuario = '<input type="hidden" name="idPersona" value="'.$idPersona .'" />';
} elseif ( (isset($_POST['idPersona'])) && (is_numeric($_POST['idPersona'])) ) {  
	$idPersona = $_POST['idPersona'];
	$hUsuario = '<input type="hidden" name="idPersona" value="'.$idPersona .'" />';
} 	 


$swRegisto="not";
if (isset($_POST['submitted'])) {  

	require_once (MYSQL);	
	 
	$errors = array();
	$trimmed = array_map('trim', $_POST);	
	 
	$descripcion = FALSE;	
 	$numero = 0;
	
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$email = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		$errors[] = 'Digite email.';
	}		
	
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['descripcion'])) {
		$descripcion = mysqli_real_escape_string ($dbc, $trimmed['descripcion']);
	} else {
		$errors[] = 'Digite descripcion.';
	}	 	
	
	
		
 	if (empty($errors)) {
				
			
			    // Administrador
				$q = "INSERT INTO email ( idPersona, email, descripcion) VALUES ( $idPersona, '$email', '$descripcion' )";			
			
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) {
					
									
										 	
					echo '<p align="center">Se ha agreado un nuevo registro.</p>';
				//	echo '<p align="center"><img src="images/dialog-apply.png" width="56" height="56" /></p>';
					echo '<p align="center">';
					
				//	echo '<a href="addCelular.php?idPersona='.$idPersonas .'">¿Vincular Numero Celular?</a><br />';  
				//	echo '<a href="addDireccion.php?idPersona='.$idPersonas .'">¿Vincular Direccion Celular?</a>';  
					  
					echo   '<a href="verEmail.php?idPersona='.$idPersona.'">Volrer</a>
						 </p>';							
				# ----------------------------------------------------------------------------------------
				$swRegisto="ok";
				 
				
			} else {  
				echo '<p class="error">El usuario no ha sido registrado, debido a un error del sistema. Pedimos disculpas por las molestias.</p>';
			}		
		
		
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
<form name="t" action="addEmail.php" method="post" enctype="multipart/form-data">
<br />
<script type="text/javascript" src="js/btn.js"></script>
	
	<table align="center">
	 <TR>
		<TD align="left">Email</TD>
		<TD align="left"> <input type="text" name="email" size="30" maxlength="50" value="<?php if (isset($trimmed['email'])) echo 	$trimmed['email']; ?>" class="input" /></TD>
	</TR>
	
	<TR>
	<TD align="left">Descripcion</TD>
	<TD align="left"> <input type="text" name="descripcion" size="30" maxlength="50" value="<?php if (isset($trimmed['descripcion'])) echo $trimmed['descripcion']; ?>" class="input" /></TD>
	</TR>
    
    <TR>
	<TD colspan="2">
		<div align="center"><input type="Submit" id="submit_btn" value="Aceptar" class="btn green" /></div>
		<input type="hidden" name="submitted" value="TRUE" />     
        <?php echo  $hUsuario; ?>    
	</TD>
	</TR>
	</table>
	<br />
</form>
</center>

<br />
<?php
echo   '<a href="verEmail.php?idPersona='.$idPersona.'">Volver</a></p>';
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