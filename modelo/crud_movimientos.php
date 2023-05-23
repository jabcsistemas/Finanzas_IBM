<?php
error_reporting (0);
//include_once ('clase_conexion.php');
include_once ('Conexion_PG.php');
  $objeto = new Conexion(); 
  $conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el MOVIMIENTOS.JS   

$id_movimientos = (isset($_POST['id_movimientos'])) ? $_POST['id_movimientos'] : '';
$fecha_movimiento = (isset($_POST['fecha_movimiento'])) ? $_POST['fecha_movimiento'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$tipo_movimiento = (isset($_POST['tipo_movimiento'])) ? $_POST['tipo_movimiento'] : '';
$tipo_operacion = (isset($_POST['tipo_operacion'])) ? $_POST['tipo_operacion'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$subconcepto = (isset($_POST['subconcepto'])) ? $_POST['subconcepto'] : '';
$detalle = (isset($_POST['detalle'])) ? $_POST['detalle'] : '';
$comentario = (isset($_POST['comentario'])) ? $_POST['comentario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
//$fecha=date('Y-m-d');
$saldo =(isset($_POST['saldo'])) ? $_POST['saldo'] : '';;




switch($opcion){
    case 1: //alta

////////////////////CALCULAMOS EL SALDO ANTES DE INSERTAR LA OPERACIÓN////
        $consulta_saldo = "SELECT saldo FROM movimientos 
               ORDER BY id_movimientos DESC LIMIT 1 ";      
        $resultado = $conexion->prepare($consulta_saldo);
        $resultado->execute();        
            while ($data = $resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $saldo_actual=$data ["saldo"];
                }   
        
       //SUMA si es "1" el tipo_movimiento de la operación
        if ($tipo_movimiento==1) {
            $saldo_nuevo = $saldo_actual + $importe; 
        }
        //RESTA si es "2" el tipo_movimiento de la operación
        else {
        $saldo_nuevo = $saldo_actual - $importe;
         }     


////////////INSERTAMOS LOS DATOS DE LA OPERACIÓN//////////////
        $consulta = "INSERT INTO movimientos (
                                                comentario, 
                                                concepto, 
                                                detalle, 
                                                importe, 
                                                subconcepto, 
                                                tipo_movimiento, 
                                                saldo, 
                                                tipo_operacion,
                                                fecha_movimiento) 
                       VALUES (
                                '$comentario',
                                '$concepto', 
                                '$detalle',
                                '$importe',
                                '$subconcepto',
                                '$tipo_movimiento',
                                '$saldo_nuevo',
                                '$tipo_operacion',
                                '$fecha_movimiento'
                               ) ";     
       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        //Hacemos la consulta de los MOVIMIENTOS para agregar
        // a la tabla de la vista solamente el nuevo MOVIMIENTO ingresado
        $consulta = "SELECT id_movimientos,
                          fecha_movimiento,
                          (SELECT id_conceptos FROM tab_conceptos s WHERE c.concepto = s.id_conceptos ) as id_conceptos, 
                        (SELECT nombre_concepto FROM tab_conceptos s WHERE c.concepto = s.id_conceptos ) as concepto,
                          (SELECT detalle FROM tab_conceptos_detalle s WHERE c.subconcepto = s.id_con_det ) as subconcepto,
                          (SELECT id_con_det FROM tab_conceptos_detalle s WHERE c.subconcepto = s.id_con_det ) as id_subconcepto,
                                   detalle, 
                           tipo_movimiento,
                                comentario,
                            tipo_operacion,
                                   importe,
                                      saldo
                      FROM movimientos c ORDER BY id_movimientos  DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

         break; /// FIN DEL CASE 1-ALTA



    case 2: //modificación

    ////////////////////CALCULAMOS EL SALDO NUEVAMENTE ANTES DE ACTUALIZAR LA OPERACIÓN////
        $consulta_saldo = "SELECT saldo FROM movimientos 
               ORDER BY id_movimientos DESC LIMIT 1 ";      
        $resultado = $conexion->prepare($consulta_saldo);
        $resultado->execute();        
            while ($data = $resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $saldo_actual=$data ["saldo"];
                }   
        
       //SUMA si es "1" el tipo_movimiento de la operación
        if ($tipo_movimiento==1) {
            $saldo_nuevo = $saldo_actual + $importe; 
        }
        //RESTA si es "2" el tipo_movimiento de la operación
        else {
        $saldo_nuevo = $saldo_actual - $importe;
         }     


         ///ACTUALIZAMOS EL MOVIMIENTO SOLICITADO ////
        $consulta = "UPDATE movimientos SET comentario='$comentario', 
                                          concepto='$concepto', 
                                          detalle='$detalle',
                                          importe = '$importe',
                                          subconcepto = '$subconcepto',
                                          tipo_movimiento = '$tipo_movimiento',
                                          tipo_operacion = '$tipo_operacion',
                                          fecha_movimiento = '$fecha_movimiento',
                                          saldo = '$saldo_nuevo'                                   
                                                    WHERE id_movimientos='$id_movimientos'";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
       //Hacemos la consulta del movimiento recién actualizado

        $consulta = "SELECT id_movimientos,
                          fecha_movimiento,
                          (SELECT id_conceptos FROM tab_conceptos s WHERE c.concepto = s.id_conceptos ) as id_conceptos, 
                        (SELECT nombre_concepto FROM tab_conceptos s WHERE c.concepto = s.id_conceptos ) as concepto,
                          (SELECT detalle FROM tab_conceptos_detalle s WHERE c.subconcepto = s.id_con_det ) as subconcepto,
                          (SELECT id_con_det FROM tab_conceptos_detalle s WHERE c.subconcepto = s.id_con_det ) as id_subconcepto,
                                   detalle, 
                           tipo_movimiento,
                                comentario,
                            tipo_operacion,
                                   importe,
                                      saldo
                      FROM movimientos c WHERE  id_movimientos='$id_movimientos'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);





        break; /// FIN DEL CASE 2       


        
    case 3://baja
        $consulta = "DELETE FROM conceptos WHERE id_conceptos='$id_conceptos' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json al MOVIMIENTOS.JS
$conexion = NULL;
