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
			if (isset($_GET['idPersona']) && is_numeric($_GET['idPersona'])) { 
				$idPersona = $_GET['idPersona'];		
			}
			
			include "conexion.php";
			$consulta = "select * from personas where idPersona='".$idPersona."'";
			$resultado=mysql_query($consulta);
			
			
			$nombres=mysql_result($resultado,0,'nombres');
			$paterno=mysql_result($resultado,0,'paterno');
			$materno=mysql_result($resultado,0,'materno');
			$nombres = $nombres." ".$paterno." ".$materno;	
			mysql_close();
			echo  "<b>".$nombres."</b><br /><br />";
		 ?>
     	<a href="verTelefono.php?idPersona=<?php echo $idPersona; ?>">Telefonos</a><br />
        <a href="verDireccion.php?idPersona=<?php echo $idPersona; ?>" >Direcciones</a><br />
        <a href="verEmail.php?idPersona=<?php echo $idPersona; ?>">Emails</a>
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