
<?php
//error_reporting(1);
include('../../../modelo/Conexion_PG.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT id_conceptos, 
                nombre_concepto, 
                    descripcion,
        (SELECT nombre_tipo_concepto FROM tipo_conceptos c WHERE s.funcion_tipo_concepto = c.funcion_tipo_concepto) as notacion_tipo_concepto,
                funcion_tipo_concepto, 
                 fecha_creacion,
             fecha_modificacion,
             usuario_concepto 
                 FROM conceptos s ORDER BY id_conceptos DESC";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main content -->
    
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-success">         
              <div class="row">
                <div class="col-lg-12">            
                    <button id="btnNuevo_concepto" type="button" class="btn btn-success" data-toggle="modal">Nuevo +</button>    
                </div>    
              </div>              
        </div><!-- /.card-header -->
          
        <!-- /.card -->

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Consultar concepto</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
                   
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tab_conceptos" class="table table-striped table-hover table-sm table-heading table-datatable">
                <thead>
                <tr>
                  <th>N°</th>
                  <th>Concepto</th>
                  <th>Detalle</th>
                  <th>Id_tipo</th>
                  <th>Tipo</th>
                  <th>Fecha creación</th>                                             
                  <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                <!-- Start: list_row -->
                <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['id_conceptos'] ?></td>
                                <td><?php echo $dat['nombre_concepto'] ?></td>
                                <td><?php echo $dat['descripcion'] ?></td>
                                <td><?php echo $dat['funcion_tipo_concepto'] ?></td>
                                <td><?php echo $dat['notacion_tipo_concepto'] ?></td>
                                <td><?php echo $dat['fecha_creacion'] ?></td>                                   
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?> 
            
          <!-- End: list_row -->
                
                </tbody>
                <tfoot>
                <tr>
                  <th>N°</th>
                  <th>Concepto</th>
                  <th>Detalle</th>
                  <th>Id_tipo</th>
                  <th>Tipo</th>
                  <th>Fecha creación</th>                                                 
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



<script type="text/javascript"  src="conceptos.js"></script>

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