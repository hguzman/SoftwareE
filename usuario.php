<?php
// sin espacio arriba <?php
include "conexion.php";
$query = "SELECT * FROM personas ORDER BY idPersona ASC";

$results = mysql_query($query);

echo "<?xml version=\"1.0\"?>\n";
echo "<pages>\n";

while($line = mysql_fetch_assoc($results)){
	echo "<link>\n";
		echo"<nombres>".$line['nombres']."</nombres>\n";
		echo"<paterno>".$line['paterno']."</paterno>\n";
		$materno = " ";
		if ($line['materno'] != "")
			$materno = $line['materno'];
		echo"<materno>".$materno ."</materno>\n";
		echo"<cedula>".$line['cedula']."</cedula>\n";	
		$alias = " ";
		if ($line['alias'] != "")
			$materno = $line['materno'];	
		echo"<alias>".$alias."</alias>\n";
		echo"<idPersona>".$line['idPersona']."</idPersona>\n";
	echo "</link>\n";
}

echo "</pages>\n";

mysql_close();

?>