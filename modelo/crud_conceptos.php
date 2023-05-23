<?php
error_reporting (0);
//include_once ('clase_conexion.php');
include_once ('Conexion_PG.php');
  $objeto = new Conexion(); 
  $conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el CONCEPTO.JS   

$id_conceptos_comb = (isset($_POST['id_conceptos_comb'])) ? $_POST['id_conceptos_comb'] : '';
$id_conceptos = (isset($_POST['id_conceptos'])) ? $_POST['id_conceptos'] : '';
$nombre_concepto = (isset($_POST['nombre_concepto'])) ? $_POST['nombre_concepto'] : '';
$subconcepto = (isset($_POST['subconcepto'])) ? $_POST['subconcepto'] : '';///DESCRIPCION
$id_tipo_concepto = (isset($_POST['id_tipo_concepto'])) ? $_POST['id_tipo_concepto'] : '';//FUNCION_TIPO_CONCEPTO (1 o 2)
$tipoconcepto = (isset($_POST['tipoconcepto'])) ? $_POST['tipoconcepto'] : '';//INGRESO O EGRESO
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$fecha=date('Y-m-d');

//echo $nombre_concepto;



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO conceptos (
        nombre_concepto, 
        descripcion,
        funcion_tipo_concepto,
        fecha_creacion,
        on_off) 
            VALUES (
            '$nombre_concepto',
            '$subconcepto', 
            '$tipoconcepto',
            '$fecha',
            1) ";     
       // return $obj->ejecutarCONSULTA($consulta,$con);
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        //Hacemos la consulta de los usuarios para agregar
        // a la tabla de la vista solamente el nuevo usuario ingresado
        $consulta = "SELECT id_conceptos,
                                nombre_concepto,
                              descripcion,
                               (SELECT nombre_tipo_concepto FROM tipo_conceptos c WHERE s.funcion_tipo_concepto = c.funcion_tipo_concepto) as tipoconcepto,
                               funcion_tipo_concepto,
                               fecha_creacion
                             
                                FROM conceptos s
                                        WHERE on_off = '1' ORDER BY id_conceptos DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
         break;



    case 2: //modificación
        $consulta = "UPDATE conceptos SET nombre_concepto='$nombre_concepto', 
                                          descripcion='$subconcepto', 
                                          funcion_tipo_concepto='$tipoconcepto',
                                          fecha_modificacion = '$fecha',
                                          usuario_concepto ='Alejandro Barrios'
                                                    WHERE id_conceptos='$id_conceptos'";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id_conceptos,
                                nombre_concepto,
                              descripcion,
                               (SELECT nombre_tipo_concepto FROM tipo_conceptos c WHERE s.funcion_tipo_concepto = c.funcion_tipo_concepto) as tipoconcepto,
                               funcion_tipo_concepto,
                               fecha_creacion
                             
                                FROM conceptos s
                                            WHERE on_off = '1' AND id_conceptos='$id_conceptos'";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        


        
    case 3://baja
        $consulta = "DELETE FROM conceptos WHERE id_conceptos='$id_conceptos' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;


    case 4: //combo Subconcepto desde Movimientos
           
        $consulta = "SELECT id_con_det,
                            id_conceptos,
                                detalle                             
                                FROM tab_conceptos_detalle
                                        WHERE id_conceptos = '$id_conceptos_comb'
                                            AND  on_off = '1' ORDER BY id_conc_det DESC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
         break;
            
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json al MAIN.JS
$conexion = NULL;
