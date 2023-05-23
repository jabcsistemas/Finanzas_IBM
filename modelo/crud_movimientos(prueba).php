<?php
error_reporting (0);
//include_once ('clase_conexion.php');
include_once ('Conexion_PG.php');
  $objeto = new Conexion(); 
  $conexion = $objeto->Conectar();




////////////////////CALCULAMOS EL SALDO ANTES DE INSERTAR LA OPERACIÓN////
        $consulta = "SELECT saldo FROM movimientos 
               ORDER BY id_movimientos DESC LIMIT 1 ";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
            while ($data = $resultado->fetch(PDO::FETCH_ASSOC)) {
            //echo $data ["saldo"];
            $saldo_actual=$data ["saldo"];
                }

        echo $saldo_actual;
         
//print json_encode($data, JSON_UNESCAPED_UNICODE);

 //echo $saldo_total;

$conexion = NULL;

