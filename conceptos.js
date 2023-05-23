$(document).ready(function(){  
   
   tab_conceptos= $("#tab_conceptos").DataTable({
      //Para definir los botones por defecto de Eliminar y Borrar en cada fila
      "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": 
        "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar_Concep'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btn-sm btnBorrar_Concep'><i class='fas fa-trash'></i></button></div></div>"  
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
$("#btnNuevo_concepto").click(function(){
    $("#formConceptos").trigger("reset");
    $(".modal-header").css("background-color", "#28a745");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Concepto");            
    $("#modalCRUDCONCEP").modal("show");    
    //id_concepto=null;
    opcion = 1; //alta
}); 
 
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click",".btnEditar_Concep", function(){             ///
    fila = $(this).closest("tr");                            /// Acá se recogen los valores de la fila
    id_conceptos = parseInt(fila.find('td:eq(0)').text());   /// seleccionada para editar desde la tabla. 
    nombre_concepto = fila.find('td:eq(1)').text();          /// Se almacenan los valores de acuerdo a la posición
    subconcepto = fila.find('td:eq(2)').text();              /// en las diferentes variables definidas acá
    id_tipo_concepto = parseInt(fila.find('td:eq(3)').text());   /// 
        
    
    $("#nombre_concepto").val(nombre_concepto);                   /// Del lado izquierdo tenemos el nombre del campo
    $("#subconcepto").val(subconcepto);                           /// en el formulario y del lado derecho son los
    $("#tipoconcepto").val(id_tipo_concepto);                         /// nombres de las variables definidas arriba.
    // Acá (#tipoconcepto) le mando al modal el id para el combo  /// Los campos en el formulario para editar se 
    // del tipo concepto cargue el nombre del tipo de             /// cargarán con el dato almacenado en la variable
    // concepto
    opcion = 2; //editar                                    
    
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Concepto");            
    $("#modalCRUDCONCEP").modal("show");  //Acá se llama al modal de los conceptos para que se muestre cuando se pulsa el botón de Editar sobre cualquier registro
});

//botón BORRAR
$(document).on("click", ".btnBorrar_Concep", function(){    
    fila = $(this);
    id_conceptos = parseInt($(this).closest("tr").find('td:eq(0)').text());
    nombre_concepto = $(this).closest("tr").find('td:eq(1)').text();
    subconcepto = $(this).closest("tr").find('td:eq(2)').text();
    opcion = 3 //borrar
    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id_conceptos+"_"+nombre_concepto+"_"+subconcepto+"?");
    if(respuesta){
        $.ajax({
            url: "./modelo/crud_conceptos.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_conceptos:id_conceptos},
            success: function(){
                tab_conceptos.row(fila.parents('tr')).remove().draw();
            }
        });
    }   
});

$("#formConceptos").submit(function(e){
    e.preventDefault();                               /////////Nombre de los campos del formulario///////////
    
    nombre_concepto = $.trim($("#nombre_concepto").val()); 
    subconcepto = $.trim($("#subconcepto").val());
    tipoconcepto = $.trim($("#tipoconcepto").val());
    id_tipo_concepto = $.trim($("#id_tipo_concepto").val());
    $.ajax({
        url: "./modelo/crud_conceptos.php",
        type: "POST",
        dataType: "json", //Formato en el que se enviarán los datos del formulario
        data: {                 
                        nombre_concepto:nombre_concepto, 
                        subconcepto:subconcepto, 
                        tipoconcepto:tipoconcepto, 
                        id_tipo_concepto:id_tipo_concepto, 
                        opcion:opcion},
        success: function(data){  
            
            console.log(data);
            id_conceptos=data[0].id_conceptos;
            nombre_concepto = data[0].nombre_concepto;            
            subconcepto = data[0].descripcion;
            tipoconcepto = data[0].tipoconcepto;
            id_tipo_concepto = data[0].funcion_tipo_concepto;  //Estos campos data[0].clave corresponden a los datos del arreglo de los campos desde el CRUD_CONCEPTOS          
            fecha_creacion = data[0].fecha_creacion;

            
            //Dibujamos una nueva fila en la tabla de conceptos con el último registrado ingresado
            //para que no se recargue la página

            //Al INSERTAR
            if(opcion == 1){tab_conceptos.row.add([ id_conceptos,
                                                 nombre_concepto,
                                                     subconcepto,
                                                id_tipo_concepto,                                                     
                                                    tipoconcepto,
                                                    fecha_creacion]).draw();}
            //Al Editar 
            else{tab_conceptos.row(fila).data([id_conceptos,
                                            nombre_concepto,
                                                 subconcepto,
                                            id_tipo_concepto,
                                                tipoconcepto,
                                             fecha_creacion,]).draw();}            
            //$("#modalCRUD").modal("hide");
        }        
    });   
     
    $("#formConceptos").trigger("reset");    
    $('.modal-mensaje').css("color", "white");
    $("#modalCRUDCONCEP").modal("hide");

    //if(opcion == 1){$('.modal-mensaje').css("background-color", "#28a745").html('Concepto agregado con éxito').show(200).delay(2500).hide(200);}
      //      else{$('.modal-mensaje').css("background-color", "#28a745").html('Registro actualizado con éxito').show(200).delay(2500).hide(200);}

        

    
});

});