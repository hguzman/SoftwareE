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
 
	if ( (isset($_GET['idEmail'])) && (is_numeric($_GET['idEmail'])) ) { 
		$idEmail = $_GET['idEmail'];
	} elseif ( (isset($_POST['idEmail'])) && (is_numeric($_POST['idEmail'])) ) { 
		$idEmail = $_POST['idEmail'];
	} else { 
		echo '<p class="error">Esta página ha sido visitada por error.</p>';		
		exit();
	}	
 
	 $consulta = "select * from email where idEmail='".$idEmail."'";
	 $resultado=mysql_query($consulta);
	
	 $idPersona=mysql_result($resultado,0,'idPersona');
	 $email=mysql_result($resultado,0,'email');
	 $descripcion=mysql_result($resultado,0,'descripcion');
	  
	
	  mysql_close();  
?>         

<?php 


require_once ('mysqli_connect.php'); 


$swRegisto="not";
if (isset($_POST['submitted'])) {

	$errors = array();
	
	$trimmed = array_map('trim', $_POST);	
	
	
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$email = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		$errors[] = 'Digite correo electrónico.';
	}
/*	if (empty($_POST['numero'])) {
		$errors[] = 'Digite un numero de ficha.';		
	} else {		
		$numero =  mysqli_real_escape_string($dbc, trim($_POST['numero'])); 
	}	*/
		
	if (empty($_POST['descripcion'])) {
		$errors[] = 'Digite descripcion.';	
	} else {		
		$descripcion =  mysqli_real_escape_string($dbc, trim($_POST['descripcion'])); 
	}
    /*
	if (empty($_POST['fechaInicio'])) {
		$errors[] = 'Digite fecha inicio.';		
	} else {		
		$fechaInicio =  mysqli_real_escape_string($dbc, trim($_POST['fechaInicio'])); 
	}
	if (empty($_POST['fechaFin'])) {
		$errors[] = 'Digite fecha fin.';		
	} else {		
		$fechaFin =  mysqli_real_escape_string($dbc, trim($_POST['fechaFin'])); 
	}
	if (empty($_POST['jornada'])) {
		$errors[] = 'Digite jornada.';		
	} else {		
		$jornada =  mysqli_real_escape_string($dbc, trim($_POST['jornada'])); 
	}
		*/	
//	echo $fechaFin;
	
	if (empty($errors)) { 
	
		
		
				
				$q = "UPDATE email SET email='$email', descripcion='$descripcion'  WHERE idEmail=$idEmail";
				$r = @mysqli_query ($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) { 
					$swRegisto="ok";
					
					echo '<p align="center">Se ha actualizado el registro.</p>';	
				//	echo '<p align="center"><img src="images/dialog-apply.png" width="56" height="56" /></p>';
					echo '<p align="center">';
					echo   '<a href="verEmail.php?idPersona='.$idPersona.'">Volver</a></p>';		
				} else { 
					echo '<p class="error">El registro no puede ser editado(no se ha realizado modificacion en el formulario).</p>'; 
				//	echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; 
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
<form method="post" action="editEmail.php">

	<script type="text/javascript" src="js/btn.js"></script>
 
	<table>
    		<tr>
			<td>Correo-e</td>
			<td><input type="text" name="email" size="30" maxlength="80" value="<?php echo $email; ?>" class="input"/></td>
		  </tr>	
            
		  <tr>
			<td>Descripcion</td>
			<td><input type="text" name="descripcion" size="30" maxlength="50" value="<?php echo $descripcion; ?>" class="input"/></td>
		  </tr>
          
          
          
		  <tr>
			<td colspan="2"><br /><input type="Submit" id="submit_btn" value="Aceptar" class="btn green" />
			</td>			
		  </tr>
	</table>	
	<input type="hidden" name="submitted" value="TRUE" />
    <input type="hidden" name="idEmail" value="<?php echo $idEmail; ?>" />
    <input type="hidden" name="idPersona" value="<?php echo $idPersona; ?>" />
</form>

 
<br>
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