
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">Inicio</a></li>
			<li><a href="#">Usuarios</a></li>
			<li><a href="#">Crear nuevo</a></li>
		</ol>		
	</div>
</div>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 col-sm-4 col-md-5">
		<h3>Usuarios</h3>
	</div>		
</div>

<div class="row">
	<div class="col-xs-12 col-sm-8">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span>Cargar usuarios</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div id="aqui" class="box-content">
				<form id="defaultForm" action="./clases/controlador_usuario.php" class="form-horizontal" method="post" name="defaultForm">
					<fieldset>
						<legend>Ingrese datos</legend>
						
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Nombre:</label>
							<div class="col-sm-5">
								<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">						
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Apellido:</label>
							<div class="col-sm-5">
								<input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido">						
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Cédula:</label>
							<div class="col-sm-5">
								<input type="text" id="cedula" name="cedula" class="form-control" placeholder="Cédula">						
							</div>
						</div>
						
						<div  class="form-group">
							<label class="col-sm-3 control-label">Tipo de usuario</label>
							<div  class="col-sm-5">
								<select class='populate placeholder' id='tipousuario'  name='tipousuario'>
								   <?php      
				     				  include_once("../clases/clase_usuario.php");
										$objusuario=new usuario();       
				  	   					$listapadre=$objusuario->consultartipousuario();
											if($listapadre)
												{	
					       							
				           							echo "<option value=''>--Seleccione--</option>";
					        							foreach($listapadre as $rowpadre)					        							
					        								{ 	
						         								echo "<option value='$rowpadre[0]' id='".$rowpadre[0]."'>".$rowpadre[1]."</option>";
					        								}
					        						
					     												}
					     						  							?>	
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label">Clave:</label>
							<div class="col-sm-5">
								<input type="text" id="clave" name="clave" class="form-control" placeholder="Clave">						
							</div>
						</div>
											
					</fieldset>						
						<div  align="center">
							<input type="submit" class="btn btn-primary btn-label-center" id="registrar" value="Registrar"/>
						    <div id="mostrar" align="center"></div>

					    </div>								
				</form>
							
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

				
// Run Select2 plugin on elements
function DemoSelect2(){
	
	
	$('#tipousuario').select2();// Le da formato al campo de selección con un buscador
	
}
// Run timepicker
function DemoTimePicker(){
	$('#input_time').timepicker({setDate: new Date()});
}
$(document).ready(function() 

{
	// Create Wysiwig editor for textare
	TinyMCEStart('#wysiwig_simple', null);
	TinyMCEStart('#wysiwig_full', 'extreme');
	// Add slider for change test input length
	FormLayoutExampleInputLength($( ".slider-style" ));
	// Initialize datepicker
	//$('#input_date').datepicker({setDate: new Date()});
	//$('#input_date2').datepicker({setDate: new Date()});
	// Load Timepicker plugin
	LoadTimePickerScript(DemoTimePicker);
	// Add tooltip to form-controls
	$('.form-control').tooltip();
	LoadSelect2Script(DemoSelect2);
	// Load example of form validation
	LoadBootstrapValidatorScript(DemoFormValidator);
	// Add drag-n-drop feature to boxes
	WinMove();


$(function() 
{ 

$('#registrar').click(function()
	{ //este es el botón en el formulario que activa el evento
		 var url="./clases/controlador_usuario.php";
		      $.ajax({
		      	        type:'POST', //método en el que se recibe la respuesta
		     	        url:url,
		     	        data:$('#defaultForm').serialize(),
		     	     	success: function(registro)	
     		     	     	{
     		     	     		if ($('#nombre').val() != '' & 
     		     	     			$('#apellido').val() != '' &
     		     	     			$('#cedula').val() != '' &     		     	     			
     		     	     			$('#tipousuario').val() != '' &
     		     	     			$('#clave').val() != '')
     		     	     		{	
		                        $('#defaultForm')[0].reset();
		                        $('#mostrar').addClass('bien').html('Usuario agregado con éxito').show(200).delay(2500).hide(200);//este es el mensaje emergente al "Registrar"
				                
				                };
     		     	     	}	
		            });return false; //cierra el ajax

    });
});



});	   
 
</script>




