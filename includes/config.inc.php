<?php
/* Esta secuencia de comandos:
  * - definer constantes y ajustes
  * - dicta cómo se manejan los errores
  * - define las funciones de utilidad
*/
 
// Documento que ha creado este sitio, cuándo, por qué, etc


// ********************************** //
// ************ AJUSTES ************ //

 
define('LIVE', TRUE);

// Direccion de correo del admin:
define('EMAIL', 'tecsoft08@gmail.com');

 
 
define ('BASE_URL', 'http://localhost/SoftwareE/');

 
define ('MYSQL', 'mysqli_connect.php');

 
date_default_timezone_set ('US/Eastern');

// ************ AJUSTES  ************ //
// ********************************** //


// ****************************************** //
// ************ MANEJO DE ERRORES *********** //

 
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

 
	$message = "<p>Se produjo un error en el script '$e_file' en la linea $e_line: $e_message\n<br />";
	
	 
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
	
	 
	$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n</p>";
	
	if (!LIVE) {  
	
		echo '<div class="error">' . $message . '</div><br />';
		
	} else {  
	
		 
		mail(EMAIL, 'Error !', $message, 'From: tecsoft08@gmail.com');
		
	 
		if ($e_number != E_NOTICE) {
			echo '<div class="error">Ha ocurrido un error en el sistema. Pedimos disculpas por las molestias..</div><br />';
			echo $message;
		}
	}  

}  

 
set_error_handler ('my_error_handler');

// ************  MANEJO DE ERRORES ********** //
// ****************************************** //

?>
