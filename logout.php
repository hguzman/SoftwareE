<?php  

require_once ('includes/config.inc.php'); 
 
ob_start();
 
session_start();


if (!isset($_SESSION['nDocumento'])) {

	$url = BASE_URL . 'index.php'; 
	ob_end_clean();  
	header("Location: $url");
	exit(); 
	
} else { 
	$_SESSION = array(); 
	session_destroy();  
	setcookie (session_name(), '', time()-300); 
	$url = BASE_URL . 'index.php';
	ob_end_clean(); 
	header("Location: $url");
	exit(); 

}
?>
