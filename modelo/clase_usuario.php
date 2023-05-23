<?php
error_reporting (0);
include_once ('clase_conexion.php');
class usuario

{

function consultartipousuario(){	   
       
       $obj=new conectar();
	   $con=$obj->con();
	   $query="SELECT id_tipo, tipo from tipo_usuario where on_off='1' order by 1 asc";
	   return $obj->ejecutarCONSULTA($query,$con);
	}

function insertar(){	

	   $obj=new conectar();
	   $con=$obj->con();
	   $fecha=date('Y-m-d');//Esta es la fecha de creación del usuario, colocando la fecha del sistema cuando se creó el registro
	   $query = "INSERT INTO usuarios(nombre,apellido,cedula,on_off,fecha_creacion,clave,id_tipo,telefono)
           					VALUES ('".$_POST["nombre"]."',
           							'".$_POST["apellido"]."',
           							'".$_POST["cedula"]."',
           							1,
           							'$fecha',
           							'".$_POST["clave"]."',
           							2,
           							'".$_POST["telefono"]."')";
          
    return $obj->ejecutarCONSULTA($query,$con); 		
	}														 
}


?>