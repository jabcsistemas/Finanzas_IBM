
<?php
//error_reporting(1);

//////CONSULTA PARA CARGAR LA TABLA DE MOVIMIENTOS AL IR A LA PÁGINA DE MOVIMIENTOS
include('../../../modelo/Conexion_PG.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();

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
                      FROM movimientos c";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main content -->
    
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-success">         
              <div class="row"> <!--CONTENEDOR PRINCIPAL-->
                    <div class="col-sm-9"> <!--CONTENEDOR IZQUIERDA-->            
                        <div class="card card-success">
                            <div class="card-header">
                              <h3 class="card-title">Movimientos</h3>
                            </div>                          
                                <div class="card-body">
                                    <form id="formMovimientos" role="form">
                                        <div class="row"> <!-- FILA -->
                                            <div class="col-sm-3">
                                                 <!-- text input -->
                                              <div class="form-group">
                                                <label>Fecha de la operación</label>
                                                <input type="date" class="form-control" placeholder="Fecha" id="fecha_movimiento">
                                              </div>
                                            </div>
                                            <div class="col-sm-3">                                              
                                              <div class="form-group">
                                                <label>Concepto</label>                                

                                                <select   class="form-control"  id="concepto" style="width: 100%;">
                                                   <?php      
                                                    include_once("../../../modelo/clase_concepto.php");
                                                     $objconcepto=new concepto();       
                                                         $listapadre=$objconcepto->consultartipoconcepto();
                                                        if($listapadre)
                                                         { 
                                                          echo "<option value=''>--Seleccione--</option>";
                                                            foreach($listapadre as $rowpadre)                               
                                                          {   
                                                          echo "<option value='$rowpadre[0]' id_tipo='".$rowpadre[0]."'>".$rowpadre[1]."</option>";
                                                          }
                              
                                                         }
                                                    ?>  
                                              </select>

                                              </div>
                                            </div>
                                            <div class="col-sm-3">                                      
                                             <div class="form-group">
                                                <label>Subconcepto</label>
                                                <select class="form-control" placeholder="Subconcepto" id="subconcepto"></select>
                                              </div>
                                            </div>
                                            <div class="col-sm-3">                                       
                                             <div class="form-group">
                                                <label>Detalle</label>
                                                <input type="text" class="form-control" placeholder="Observaciones" id="detalle">
                                              </div>
                                            </div>
                                        </div>
                                        <div class="row"> <!-- FILA -->
                                            <div class="col-sm-3">
                                                 <!-- text input -->
                                              <div class="form-group">
                                                <label>Importe</label>
                                                <input type="text" class="form-control" placeholder="Importe" id="importe">
                                              </div>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                              
                                              <div class="form-group">
                                                <label >Tipo movimiento</label>
                                               <!-- <select class="form-control" id="tipo_movimiento" ></select> -->
                                               <input type="text" class="form-control" id="tipo_movimiento" disabled>
                                              </div>                                              
                                            </div>
                                            <div class="col-sm-3">                                       
                                              <div class="form-group">
                                                <label>Tipo operación</label>
                                                <input type="text" class="form-control" placeholder="Tipo operación"  id="tipo_operacion" >
                                              </div>                                              
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                <label>Comentario</label>
                                                <input type="text" class="form-control" placeholder="Comentario" id="comentario">
                                              </div>
                                            </div>
                                        </div>
                                    <!-- /.card-body -->

                                        <div class="card-footer">
                                            <div class="row">
                                            <div class="col-sm-4">  <!-- Espacio vacio para poder centrar los botones--> 
                                            </div>
                                            <div class="col-sm-2">
                                            <button type="submit" class="btn btn-info btn-sm" id="btn_guardar_mov">Guardar</button>
                                            </div>
                                            <div class="col-sm-2">
                                            <button type="reset" class="btn btn-secondary btn-sm">Limpiar</button>
                                            </div>                                           
                                            </div>
                                              
                                        </div>
                                    </form>
                                </div> 
                        </div>            
                    </div>
                    <div class="col-sm-3"><!--CONTENEDOR DERECHA-->            
                        <div class="card card-success">
                            <div class="card-header" >
                              <h3 class="card-title">CAJA</h3>
                            </div>
                          <div class="card-body">
                            <div class="row">
                                  <div class="col-sm-12" id="saldo1"align="center">
                                       <h3>LUCAS BARRIOS:</h3>
                                  </div>
                                  <div class="col-sm-12" id="saldo2"align="center">
                                       <h3> 
                                        </h3>
                                  </div>                               
                            </div>                            

                              <div class="row">
                                           <div id ="mensaje" class="col-sm-12" align="center">
                                               <h1></h1>                                   
                                           </div>
                              </div>
                                
                            </div>
                        </div>
                    </div>
              </div>              
        </div><!-- /.card-header -->
          
        <!-- /.card -->

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Consultar movimientos</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
<!-- /DIBUJA LA TABLA DE LOS MOVIMIENTOS AL INICIAR LA PÁGINA DE MOVIMIENTOS-->       
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tab_movimientos" class="table table-striped table-hover table-sm table-heading table-datatable">
                <thead>
                <tr>
                  <th>N° mov.</th>
                  <th>Fecha</th>
                  <th hidden>Id_Conc</th>
                  <th>Concepto</th>
                  <th hidden>Id_SubConc</th>
                  <th>Subconcepto</th>
                  <th>Detalle</th>
                  <th>Tip. mov.</th>                  
                  <th>Comentario</th>
                  <th>Tip. operación</th>
                  <th>Importe</th>
                  <th>Saldo</th>                                     
                  <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                <!-- Start: list_row -->
                <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['id_movimientos'] ?></td>
                                <td><?php echo $dat['fecha_movimiento'] ?></td>
                                <td hidden><?php echo $dat['id_conceptos'] ?></td>
                                <td><?php echo $dat['concepto'] ?></td>                              
                                <td hidden><?php echo $dat['id_subconcepto'] ?></td>
                                <td><?php echo $dat['subconcepto'] ?></td>
                                <td><?php echo $dat['detalle'] ?></td>
                                <td><?php echo $dat['tipo_movimiento'] ?></td>
                                <td><?php echo $dat['comentario'] ?></td>                            
                                <td><?php echo $dat['tipo_operacion'] ?></td>
                                <td><?php echo $dat['importe'] ?></td>
                                <td><?php echo $dat['saldo'] ?></td>  
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?> 
            
          <!-- End: list_row -->
                
                </tbody>
                <tfoot>
                <tr>
                  <th>N° mov.</th>
                  <th>Fecha</th>
                  <th hidden>Id_Conc</th>
                  <th>Concepto</th>
                  <th hidden>Id_SubConc</th>
                  <th>Subconcepto</th>
                  <th>Detalle</th>
                  <th>Tip. mov.</th>                  
                  <th>Comentario</th>
                  <th>Tip. operación</th>
                  <th>Importe</th>
                  <th>Saldo</th>                                     
                  <th>Acción</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          <!-- /.card-body -->          
        </div>       
        <!-- /.card -->        
      </div><!-- /.container-fluid -->
    
    <!-- Content Wrapper. Contains page content -->
  
    <!-- Content Header (Page header) -->
       
    <!-- /.content -->
  </div>



<script type="text/javascript"  src="movimientos.js"></script>
<script type="text/javascript"  src="subconceptos.js"></script>
<script type="text/javascript"  src="tipomovimiento.js"></script>
  <script>
  //$(function () {
    //Initialize Select2 Elements
    //$('.select2').select2()

    //Initialize Select2 Elements
    //$('.select2bs4').select2({
      //theme: 'bootstrap4'
    //})

 /// })
</script>