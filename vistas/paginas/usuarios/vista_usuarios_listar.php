
<?php
//error_reporting(1);
include('../../../modelo/Conexion_PG.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT id_usuario, 
                        nombre, 
                      apellido,
                         clave, 
                fecha_creacion,
                (SELECT tipo FROM tipo_usuario c WHERE s.id_tipo = c.id_tipo) as nombre_tipo,
                      id_tipo,
                     documento,
                     telefono 
                      FROM usuarios s ORDER BY id_usuario DESC";
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
                    <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nuevo +</button>    
                </div>    
              </div>              
        </div><!-- /.card-header -->
          
        <!-- /.card -->

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Consultar usuarios</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
                   
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tab_usuarios" class="table table-striped table-hover table-sm table-heading table-datatable">
                <thead>
                <tr>
                  <th>N° usuario</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Contraseña</th>
                  <th>Fecha creación</th>                  
                  <th>Id_tipo</th>
                  <th>Tipo usuario</th>
                  <th>Documento</th>
                  <th>Teléfono</th>                   
                  <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                <!-- Start: list_row -->
                <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['id_usuario'] ?></td>
                                <td><?php echo $dat['nombre'] ?></td>
                                <td><?php echo $dat['apellido'] ?></td>
                                <td><?php echo $dat['clave'] ?></td>
                                <td><?php echo $dat['fecha_creacion'] ?></td>
                                <td><?php echo $dat['id_tipo'] ?></td>                               
                                <td><?php echo $dat['nombre_tipo'] ?></td>
                                <td><?php echo $dat['documento'] ?></td>
                                <td><?php echo $dat['telefono'] ?></td>  
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?> 
            
          <!-- End: list_row -->
                
                </tbody>
                <tfoot>
                <tr>
                  <th>N° usuario</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Contraseña</th>
                  <th>Fecha creación</th>                  
                  <th>Id_tipo</th>
                  <th>Tipo usuario</th>
                  <th>Documento</th>
                  <th>Teléfono</th>              
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



<script type="text/javascript"  src="main.js"></script>

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