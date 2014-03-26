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
 
	if ( (isset($_GET['idPersona'])) && (is_numeric($_GET['idPersona'])) ) { 
		$idPersona = $_GET['idPersona'];
	} elseif ( (isset($_POST['idPersona'])) && (is_numeric($_POST['idPersona'])) ) { 
		$idPersona = $_POST['idPersona'];
	} else { 
		echo '<p class="error">Esta página ha sido visitada por error.</p>';		
		exit();
	}	
 
	 $consulta = "select * from personas where idPersona='".$idPersona."'";
	 $resultado=mysql_query($consulta);
	
	 $idPersona=mysql_result($resultado,0,'idPersona');
	 $nombres=mysql_result($resultado,0,'nombres');
	 $paterno=mysql_result($resultado,0,'paterno');
	 $materno=mysql_result($resultado,0,'materno');
	 $cedula=mysql_result($resultado,0,'cedula');
	 $alias=mysql_result($resultado,0,'alias');
	  
	
	  mysql_close();  
?>         

<?php 


require_once ('mysqli_connect.php'); 


$swRegisto="not";
if (isset($_POST['submitted'])) {

	require_once (MYSQL);	
	 
	$errors = array();
	$trimmed = array_map('trim', $_POST);	
	 
	
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['nombres'])) {
		$nombres = mysqli_real_escape_string ($dbc, $trimmed['nombres']);
	} else {
		$errors[] = 'Digite nombres.';
	}
		 
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['paterno'])) {
		$paterno = mysqli_real_escape_string ($dbc, $trimmed['paterno']);
	} else {
		$errors[] = 'Digite apellido paterno.';
	}	 
	
	
	
	
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['materno'])) {
		$materno = mysqli_real_escape_string ($dbc, $trimmed['materno']);
	} 
	 
	//echo $tDocumento." Rol";
	
	$cedula = 0;
	if (preg_match ('/^\d+$/', $trimmed['cedula'])) {
		$cedula = mysqli_real_escape_string ($dbc, $trimmed['cedula']);
		
	}
	
	$alias = "";	 
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['alias'])) {
		$alias = mysqli_real_escape_string ($dbc, $trimmed['alias']);
	}
	
	if (empty($errors)) { 
		
		
				
			$q = "UPDATE personas SET nombres='$nombres', paterno='$paterno', materno='$materno', cedula='$cedula', alias='$alias'  WHERE idPersona=$idPersona";
			
				$r = @mysqli_query ($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) { 
					$swRegisto="ok";
					
					echo '<p align="center">Se ha actualizado el registro.</p>';	
				//	echo '<p align="center"><img src="images/dialog-apply.png" width="56" height="56" /></p>';
					echo '<p align="center">';
					echo   '<a href="verPersonas.php">Volver</a></p>';		
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
<form method="post" action="editPersona.php">

	<script type="text/javascript" src="js/btn.js"></script>
 
	<table align="center">
    
     <TR>
	<TD align="left" colspan="2"><b>Informacion personal --------------------------------------</b></TD>	 
	</TR>
    
	 <TR>
		<TD align="left">* Nombres</TD>
		<TD align="left"> <input type="text" name="nombres" size="30" maxlength="50" value="<?php echo $nombres ?>" class="input" /></TD>
	</TR>
	
	<TR>
	<TD align="left">* Paterno</TD>
	<TD align="left"> <input type="text" name="paterno" size="30" maxlength="50" value="<?php echo $paterno ?>" class="input" /></TD>
	</TR>
    
    <TR>
	<TD align="left">Materno</TD>
	<TD align="left"> <input type="text" name="materno" size="30" maxlength="50" value="<?php echo $materno ?>" class="input" /></TD>
	</TR>	
		
	<TR>
	<TD align="left">Cedula</TD>
	<TD align="left"> <input type="text" name="cedula" size="30" maxlength="40" value="<?php echo $cedula ?>"  class="input" /></TD>
	</TR>   

    
    <TR>
	<TD align="left">Alias</TD>
	<TD align="left"> <input type="text" name="alias" size="30" maxlength="40" value="<?php echo $alias ?>"  class="input" /></TD>
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
	<input type="hidden" name="submitted" value="TRUE" />
   
    <input type="hidden" name="idPersona" value="<?php echo $idPersona; ?>" />
</form>

 
<br>
<br /> 
<?php
echo   '<a href="verPersonas.php">Volver</a></p>';	
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