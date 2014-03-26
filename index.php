<?php 
require_once ('includes/config.inc.php'); 
ob_start();
session_start();	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
if (isset($_POST['submitted'])) {
	//require_once (MYSQL);	 
	require_once ('mysqli_connect.php'); 
	$errors = array();
	if (!empty($_POST['cedula'])) {
		$e = mysqli_real_escape_string ($dbc, $_POST['cedula']);
	} else {
		$e = FALSE;
		$errors[] = 'Digite su numero de documento!';
	}
	
	 
	if (!empty($_POST['pass'])) {
		$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
	} else {
		$p = FALSE;
		$errors[] = 'Digite su contraseña!';
	}
	
	if ($e && $p) {  
	
	
	$q = "SELECT * FROM usuarios WHERE nDocumento='$e' AND contrasena=SHA1('$p')";			
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (@mysqli_num_rows($r) == 1) {  
			 
		//	ob_start();
		 
			$_SESSION = mysqli_fetch_array ($r, MYSQLI_ASSOC); 
			mysqli_free_result($r);
			mysqli_close($dbc);
							
			$url = BASE_URL . 'verPersonas.php';  
			ob_end_clean();  
			header("Location: $url");			
			exit();  
				
		} else {  
			echo '<p class="error">El numero de documento y la contraseña introducidos no coinciden o todavía no ha activado su cuenta..</p>';
		}
		
	} else {  
		echo '<p><font color="#9e1b34"><b>Por favor, inténtelo de nuevo.</b></p></font><ol>';
		foreach ($errors as $msg) { 
			echo "<li>$msg</li>";
		}
		echo '</ol><br/>';
	}
	
	mysqli_close($dbc);

}  
?>


<form action="index.php" method="post">
<script type="text/javascript" src="js/btn.js"></script>
<!--	<div class="titulos">
<h4>miembros del <span>sitio</span></h4>
</div>-->
	<table align="center">
	 <TR>
	 <TD rowspan="3" valign="top"> <IMG src="images/stock_lock.png" width="64" height="64"></TD>
	    <TD align="left">Cedula</TD>
		<TD align="left"> <input type="text" name="cedula" size="20" maxlength="40" class="input"/></TD>
		
	 </TR>
	 <TR>	 
	 	<TD align="left">Contraseña </TD>
		<TD align="left"><input type="password" name="pass" size="20" maxlength="20" class="input" /></TD>
	</TR>
	<TR>
		<TD colspan="2">
       
			<input type="Submit" id="submit_btn" value="Aceptar" class="btn green" />
	    	<input type="hidden" name="submitted" value="TRUE" />
		</TD>
	</TR>
	</table>
	<br />
</form>     
            
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
