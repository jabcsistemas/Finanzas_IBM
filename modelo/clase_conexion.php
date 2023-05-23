<?php

//Se define la clase "Conectar" para poder acceder a la base de datos 
//cada vez que se quiera hacer una operación en ella pasándole los 
//parámetros de conexión en el método "con"

	class conectar

//Métodos
		{
			
			function con()

			{

				$host='localhost';
				$bd='IBM_FORESTA';
				$user='postgres';
				$pw='betza27';
				

				$parametros = "host=$host dbname=$bd user=$user password=$pw";
				$conexion = pg_connect($parametros) or die ('No se puede conectar con la base de datos:  '. pg_last_error());
				return $conexion;
				pg_close($conexion);			

			}

			function ejecutarCONSULTA($query,$con)

			{
	       		 $resultado=pg_query($con, $query);
	        	$valor=0;
	        		if($resultado){
	           			 $lista =array();
	           				 while($row=pg_fetch_array($resultado)){
	                			array_push($lista,$row);
	           }
	            $valor = $lista;
	        }else{
	            $valor = "no se ejecuta";
	        }
	        return $valor;
	}	

		}


?>