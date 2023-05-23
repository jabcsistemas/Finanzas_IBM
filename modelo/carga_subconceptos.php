<?php  
 error_reporting (0);
include_once ('Conexion_PG.php');
  $objeto = new Conexion(); 
  $conexion = $objeto->Conectar();  
  

    $id = $_POST['id'];//ID del Concepto seleccionado en el formulario de movimientos
    $opcion =$_POST['opcion'];//Solo debe traer un 1 si para insertar un dato nuevo o un 2 si es para actualizar uno ya existente//
   


//Aquí vamos a buscar el Subconcepto que depende del concepto seleccionado para cargar el combo de forma dinámica

   switch ($opcion) {

    case 1://Insertar un registro nuevo en MOVIMIENTOS

           $consulta = "SELECT id_con_det,
                            id_conceptos,
                                detalle                             
                                FROM tab_conceptos_detalle
                                        WHERE id_conceptos = $id
                                            AND  on_off = '1' ORDER BY id_con_det DESC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);      
  
          if($data)
                    { 
                      echo "<option value='0'>--Seleccione--</option>";
                              foreach($data as $rowpadre)                               
                                   {   
                                    echo "<option value='$rowpadre[id_con_det]' subconcepto='".$rowpadre[detalle]."'>".$rowpadre[detalle]."</option>";
                                    }                              
                    }
    break;//case 1

    case 2: // Actualiza un registro seleccionado

           $consulta = "SELECT id_con_det,
                            id_conceptos,
                                detalle                             
                                FROM tab_conceptos_detalle
                                        WHERE id_con_det = $id
                                            AND  on_off = '1' ORDER BY id_con_det DESC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);      
  
          if($data)
                    { 
                      //echo "<option value='0'>--Seleccione--</option>";
                              foreach($data as $rowpadre)                               
                                   {   
                                    echo "<option value='$rowpadre[id_con_det]' subconcepto='".$rowpadre[detalle]."'>".$rowpadre[detalle]."</option>";
                                    }                              
                    }
     break;//case 2
    

    }
    

?>
       



      

