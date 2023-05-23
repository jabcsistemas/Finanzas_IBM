<?php
error_reporting (0);
//include_once ('clase_conexion.php');
include_once ('Conexion_PG.php');
  $objeto = new Conexion(); 
  $conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el MAIN.JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : '';
$documento = (isset($_POST['documento'])) ? $_POST['documento'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$contraseña = (isset($_POST['contraseña'])) ? $_POST['contraseña'] : '';
$fecha_creacion = (isset($_POST['fecha_creacion'])) ? $_POST['fecha_creacion'] : '';
$tipo_usuario = (isset($_POST['tipo_usuario'])) ? $_POST['tipo_usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : '';
$fecha=date('Y-m-d');


switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO usuarios (nombre, apellido,documento,clave,telefono,id_tipo, fecha_creacion,on_off) VALUES('$nombre','$apellido', '$documento','$contraseña','$telefono','$tipo_usuario','$fecha',1) ";     
       // return $obj->ejecutarCONSULTA($consulta,$con);
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        //Hacemos la consulta de los usuarios para agregar
        // a la tabla de la vista solamente el nuevo usuario ingresado
        $consulta = "SELECT id_usuario,
                                nombre,
                              apellido,
                                 clave,
                        fecha_creacion,
                               (SELECT tipo FROM tipo_usuario c WHERE s.id_tipo = c.id_tipo) as nombre_tipo,
                            id_tipo,
                            documento,
                            telefono 
                                FROM usuarios s
                                        WHERE on_off = '1' ORDER BY id_usuario DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
         break;



    case 2: //modificación
        $consulta = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', clave='$contraseña', fecha_modificacion='$fecha',id_tipo='$tipo_usuario',documento='$documento',telefono='$telefono' WHERE id_usuario='$id_usuario' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id_usuario,
                                nombre,
                              apellido,
                                 clave,
                        fecha_creacion,
                        (SELECT tipo FROM tipo_usuario c WHERE s.id_tipo = c.id_tipo) as nombre_tipo,
                             id_tipo,
                             documento,
                             telefono 
                                FROM usuarios s
                                            WHERE on_off = '1' AND id_usuario='$id_usuario'";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        


        
    case 3://baja
        $consulta = "DELETE FROM usuarios WHERE id_usuario='$id_usuario' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json al MAIN.JS
$conexion = NULL;
