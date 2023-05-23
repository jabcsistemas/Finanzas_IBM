<?php  
 error_reporting (0);
include_once ('Conexion_PG.php');
  $objeto = new Conexion(); 
  $conexion = $objeto->Conectar();  
  

    $id = $_POST['id'];//ID del Concepto seleccionado en el formulario de movimientos
    
//Aquí vamos a buscar el Tipo de movimiento que es el concepto seleccionado para que SUME(1) o RESTE (2) la
//operación a insertar
 
/*
"SELECT id_tipo_operacion                   
                                FROM tab_conceptos
                                        WHERE id_conceptos = $id
                                            AND  on_off = '1' ";*/


$consulta =  "SELECT funcion_tipo_concepto,nombre_tipo_concepto 
                                FROM TIPO_CONCEPTOS
                                    WHERE funcion_tipo_concepto = (SELECT id_tipo_operacion  
          							                                    FROM tab_conceptos
              							                                    WHERE id_conceptos = $id AND  
                                                                                  on_off = '1')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();  
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC); 

        if($data)
                    { 
                       foreach($data as $rowpadre)                               
                                   {   
                                      echo $rowpadre[funcion_tipo_concepto]; 
                                      echo $rowpadre[nombre_tipo_concepto];
                                    
                                    //echo " value='".$rowpadre[id_tipo_operacion]."' tipo_movimiento='".$rowpadre[nombre_concepto]."'";
                                    }                              
                    }         
       

?>

      

