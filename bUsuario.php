<?php
$xmlDoc=new DOMDocument();

	$xmlDoc->load("http://localhost/SoftwareE/usuario.php");



$x=$xmlDoc->getElementsByTagName('link');

$q=$_GET["q"];

$hint="";
if (strlen($q)>0)
{
$hint="";
$tabla="<table class='customers' align='center'> 
<tr>
	<th align='left'>Editar</th>
	<th align='left'>Eliminar</th>
	<th align='left'>Nombre</th>
	<th align='left'>Paterno</th>	
	<th align='left'>Materno</th>	 
	<th align='left'>Cedula</th>	 	 
	<th align='left'>Alias</th>	
</tr>
";
$bg = '#f3f3f3'; 
for($i=0; $i<($x->length); $i++)
  {
  $bg = ($bg=='<tr class="alt" >' ? '<tr>' : '<tr class="alt" >');
		
  $y=$x->item($i)->getElementsByTagName('nombres');
  $a=$x->item($i)->getElementsByTagName('paterno');
  $c=$x->item($i)->getElementsByTagName('materno');  
  $e=$x->item($i)->getElementsByTagName('cedula');
  $u=$x->item($i)->getElementsByTagName('idPersona');
  $al=$x->item($i)->getElementsByTagName('alias');
  if ($a->item(0)->nodeType==1)
    {
  
    if (stristr($a->item(0)->childNodes->item(0)->nodeValue,$q))
      {
      if ($hint=="")
        {
			
				$id1 = $u->item(0)->childNodes->item(0)->nodeValue;
				$id2 = $y->item(0)->childNodes->item(0)->nodeValue;
				
        $hint="<BR>".$tabla ."".$bg."<TD align='left'> <a href='#" . $id1 .
        "'><img src='images/preferences-composer.png' width='32' height='32' /></a></TD><TD align='left'>".
		"<a href='delPersona.php?idPersona=" . $id1 .
        "'><img src='images/error.png' width='32' height='32' /></a></TD><TD align='left'>".
			$id2."</TD><TD align='left'>"
		 . $a->item(0)->childNodes->item(0)->nodeValue ."</TD><TD align='left'>"
		 . $c->item(0)->childNodes->item(0)->nodeValue ."</TD><TD align='left'>"
		 . "<a href='opciones.php?idPersona=".$id1."'>".$e->item(0)->childNodes->item(0)->nodeValue ."</a></TD><TD align='left'>"
		 . $al->item(0)->childNodes->item(0)->nodeValue ."</a></TD></TR>";
        }
      else
        {			
				$id1 = $u->item(0)->childNodes->item(0)->nodeValue;
				$id2 = $y->item(0)->childNodes->item(0)->nodeValue;
			
				
        $hint=$hint ."".$bg."<TD align='left'> <a href='editUsuario.php?idPersona=" .
        $id1 .
        "'><img src='images/preferences-composer.png' width='32' height='32' /></a></TD><TD align='left'>" .
		"<a href='delUsuario.php?idPersona=" .
		 $id1 .
        "'><img src='images/error.png' width='32' height='32' /></a></TD><TD align='left'>
		".$id2 ."</TD><TD align='left'>"
        . $a->item(0)->childNodes->item(0)->nodeValue ."</TD><TD align='left'>"
		. $c->item(0)->childNodes->item(0)->nodeValue ."</TD><TD align='left'>"
		. "<a href='opciones.php?idPersona=".$id1."'>".$e->item(0)->childNodes->item(0)->nodeValue ."</a></TD><TD align='left'>"
		. $al->item(0)->childNodes->item(0)->nodeValue ."</TD></TR>";
        }
      }
    }
  }
}

// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint=="")
  {
  $response="No hay resultados";
  }
else
  {
  $response=$hint."</table>";
  }

//output the response
echo $response;
?> 