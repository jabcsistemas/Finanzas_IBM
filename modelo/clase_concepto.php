<?php
error_reporting (0);
include_once ('clase_conexion.php');
class concepto

{

	function consultarconcepto()
		{	   
       
       		$obj=new conectar();
	   		$con=$obj->con();
	   		$query="SELECT  id_tipo_conceptos, nombre_tipo_concepto from tipo_conceptos where on_off='1' order by 1 asc";
	   		return $obj->ejecutarCONSULTA($query,$con);
		}

	function consultartipoconcepto()
		{	   
       
       		$obj=new conectar();
	   		$con=$obj->con();	   		
	   		$query="SELECT  id_conceptos, nombre_concepto from tab_conceptos where on_off='1' order by 1 asc";
	   		return $obj->ejecutarCONSULTA($query,$con);
		}
	



}



?>