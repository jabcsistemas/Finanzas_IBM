
<?php 

class Conexion{

	public static function Conectar() {        
        define('servidor', 'localhost');
        define('nombre_bd', 'IBM_FORESTA');
        define('usuario', 'postgres');
        define('password', 'betza27');

//$opciones = array(PDO::PGSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
        try{
            $conexion = new PDO("pgsql:host=".servidor."; dbname=".nombre_bd, usuario, password);			
            return $conexion;
        }catch (Exception $e){
            die("El error de Conexión es: ". $e->getMessage());
        }
    }
}
