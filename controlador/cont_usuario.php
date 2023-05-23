<?php
error_reporting(1);
require_once("../modelo/clase_usuario.php");


//Se esta instanciando la clase "Usuarios" y se está invocando al método "insertar"
	$objeto= new usuario ();
	$objeto -> insertar ();

//$nombre=$_POST["nombre"];
//$apellido=$_POST["apellido"];
//$documento=$_POST["cedula"];
//$contraseña=$_POST["clave"];
//$telefono=$_POST["telefono"];

//echo "Los datos traídos son:     ";
//echo $nombre;
//echo $apellido;
//echo $documento;
//echo $contraseña;
//echo $telefono;
echo "Datos insertados correctamente";
?>