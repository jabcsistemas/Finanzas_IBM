$(document).ready(function(){  
   
   tab_usuarios= $("#tab_usuarios").DataTable({
      //Para definir los botones por defecto de Eliminar y Borrar en cada fila
      "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": 
        "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash'></i></button></div></div>"  
       }],

      "responsive": true,
      "autoWidth": false,
      //Para cambiar el lenguaje a español
    "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
             },
             "sProcessing":"Procesando...",
        }

    });



//botón NUEVO/GUARDAR   
$("#btnNuevo").click(function(){
    $("#formUsuarios").trigger("reset");
    $(".modal-header").css("background-color", "#28a745");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Usuario");            
    $("#modalCRUD").modal("show");    
    id_usuario=null;
    opcion = 1; //alta
}); 
 
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click",".btnEditar", function(){
    fila = $(this).closest("tr");
    id_usuario = parseInt(fila.find('td:eq(0)').text());
    nombre = fila.find('td:eq(1)').text();
    apellido = fila.find('td:eq(2)').text();
    contraseña = parseInt(fila.find('td:eq(3)').text());    
    //tipo_usuario = parseInt(fila.find('td:eq(5)').text());
    id_tipo = parseInt(fila.find('td:eq(5)').text());
    tipo_usuario = fila.find('td:eq(6)').text();
    documento = parseInt(fila.find('td:eq(7)').text());
    telefono = parseInt(fila.find('td:eq(8)').text());

    /*MUESTRO POR CONSOLA LOS DATOS RECOGIDOS DE LA FILA PARA EDITAR */
    console.log(id_usuario,
                nombre,
                apellido,
                id_tipo,
                tipo_usuario,
                documento,
                telefono);
    ////////////////////////////////////////////////////////////////////

    $("#nombre").val(nombre);
    $("#apellido").val(apellido);
    $("#contraseña").val(contraseña);
    $("#telefono").val(telefono);
    $("#documento").val(documento);
    $("#tipo_usuario").val(id_tipo);// Acá le mando al modal el id para el combo del tipo usuario cargue el nombre del tipo de usuario
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Usuario");            
    $("#modalCRUD").modal("show");  //Este modal está definido en el INICIO.PHP. El modal despliega un formulario

});

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){    
    fila = $(this);
    id_usuario = parseInt($(this).closest("tr").find('td:eq(0)').text());
    nombre = $(this).closest("tr").find('td:eq(1)').text();
    apellido = $(this).closest("tr").find('td:eq(2)').text();
    opcion = 3 //borrar
    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id_usuario+"_"+nombre+"_"+apellido+"?");
    if(respuesta){
        $.ajax({
            url: "./modelo/crud.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_usuario:id_usuario},
            success: function(){
                tab_usuarios.row(fila.parents('tr')).remove().draw();
            }
        });
    }   
});

$("#formUsuarios").submit(function(e){
    e.preventDefault();
    
    fecha_creacion = $.trim($("#fecha_creacion").val());    
    nombre = $.trim($("#nombre").val());
    apellido = $.trim($("#apellido").val());
    documento = $.trim($("#documento").val());
    telefono = $.trim($("#telefono").val());
    contraseña = $.trim($("#contraseña").val());
    tipo_usuario = $.trim($("#tipo_usuario").val());
    //nombre_tipo = $.trim($("#nombre_tipo").val());      
    $.ajax({
        url: "./modelo/crud.php",
        type: "POST",
        dataType: "json", //Formato en el que se enviarán los datos del formulario
        data: {   nombre:nombre, 
                  apellido:apellido, 
                  documento:documento, 
                  telefono:telefono, 
                  contraseña:contraseña, 
                  fecha_creacion:fecha_creacion, 
                  tipo_usuario:tipo_usuario, 
                  id_usuario:id_usuario, 
                  opcion:opcion},
        success: function(data){  
            
            console.log(data);
            id_usuario = data[0].id_usuario;            
            nombre = data[0].nombre;
            apellido = data[0].apellido;
            documento = data[0].documento;
            telefono = data[0].telefono;
            contraseña = data[0].clave;     //Estos campos data[0].clave corresponden a los datos del arreglo de los campos desde el CRUD
            fecha_creacion = data[0].fecha_creacion;
            nombre_tipo = data[0].nombre_tipo;
            id_tipo=data[0].id_tipo;

            
            //Dibujamos una nueva fila en la tabla de usuarios con el último registrado ingresado
            //para que no se recargue la página. La opción corresponde al NUEVO registro y el ELSE para MODIFICACIÓN

            if(opcion == 1){tab_usuarios.row.add([id_usuario,nombre,apellido,contraseña,fecha_creacion,id_tipo,nombre_tipo,documento,telefono]).draw();}
            else{tab_usuarios.row(fila).data([id_usuario,nombre,apellido,contraseña,fecha_creacion,id_tipo,nombre_tipo,documento,telefono]).draw();}            
            //$("#modalCRUD").modal("hide");
        }        
    });   
     
    $("#formUsuarios").trigger("reset");    
    $('.modal-mensaje').css("color", "white");

    if(opcion == 1){$('.modal-mensaje').css("background-color", "#28a745").html('Usuario agregado con éxito').show(200).delay(2500).hide(200);}
            else{$('.modal-mensaje').css("background-color", "#28a745").html('Registro actualizado con éxito').show(200).delay(2500).hide(200);}

        

    
});

});