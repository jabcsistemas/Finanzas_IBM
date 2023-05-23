$(document).ready(function()

{   
  

   tab_movimientos= $("#tab_movimientos").DataTable({
      //Para definir los botones por defecto de Eliminar y Borrar en cada fila
      "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": 
        "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar_Movimientos'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btn-sm btnBorrar_Concep'><i class='fas fa-trash'></i></button></div></div>"  
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


 
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click",".btnEditar_Movimientos", function(){             ///
   // alert("HOLA ALE")

    fila = $(this).closest("tr");                            /// Acá se recogen los valores de la fila
    id_movimientos = parseInt(fila.find('td:eq(0)').text());   /// seleccionada para editar desde la tabla. 
    fecha_movimiento = fila.find('td:eq(1)').text();          /// Se almacenan los valores de acuerdo a la posición
    id_conceptos = fila.find('td:eq(2)').text();
    concepto = fila.find('td:eq(3)').text();   
    id_subconcepto = fila.find('td:eq(4)').text();
    subconcepto = fila.find('td:eq(5)').text();              /// en las diferentes variables definidas acá
    detalle= fila.find('td:eq(6)').text();   /// 
    tipo_movimiento= parseInt(fila.find('td:eq(7)').text()); 
    comentario= fila.find('td:eq(8)').text();
    tipo_operacion= fila.find('td:eq(9)').text();
    importe= fila.find('td:eq(10)').text();
    
/////Muestra por la consola del navegador los valores seleccionados de la fila para ser insertados en el formulario
    console.log(id_movimientos,
                fecha_movimiento,
                id_conceptos,
                    concepto,
                id_subconcepto,
                    subconcepto,
                    detalle,
                    tipo_movimiento,
                    comentario,
                    tipo_operacion,
                    importe);    
///////////////////////////////////////////////////////
    $("#id_movimientos").val(id_movimientos);     /// CAMPO_FORMULARIO/VALOR DE LA VARIABLE
    $("#fecha_movimiento").val(fecha_movimiento);
    $("#concepto").val(id_conceptos);    
    $("#subconcepto").val(id_subconcepto);
    $("#detalle").val(detalle);
    $("#tipo_movimiento").val(tipo_movimiento);
    $("#comentario").val(comentario);
    $("#tipo_operacion").val(tipo_operacion);
    $("#importe").val(importe);
    opcion = 2; //editar  

//////Guardo el id del subconcepto seleccionado y consulto en la base el nombre correspondiente
    var id = id_subconcepto;
     //alert(id)
     //alert(opcion)
    $.ajax({
        type: "POST",
        url: "./modelo/carga_subconceptos.php",        
        data:{'id':id,
              'opcion':opcion}
    })
    .done(function(combosubconcepto){
        //alert('LLEGÓ')
        $('#subconcepto').html(combosubconcepto)
    })
    .fail(function(){
        alert("Error al cargar el combo Subconcepto")
    })                                  
   
});


////////////////////////////////////////////////Botón BORRAR/////////////////////////////////////////
$(document).on("click", ".btnBorrar_", function(){    
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

 

$("#formMovimientos").submit(function(e){
    e.preventDefault();                               /////////Nombre de los campos del formulario///////////
    
    
    fecha_movimiento = $.trim($("#fecha_movimiento").val()); 
    importe = $.trim($("#importe").val());
    tipo_movimiento = $.trim($("#tipo_movimiento").val());
    tipo_operacion = $.trim($("#tipo_operacion").val());
    id_conceptos = $.trim($("#id_conceptos").val());
    concepto = $.trim($("#concepto").val());
    id_subconcepto = $.trim($("#id_subconcepto").val());
    subconcepto = $.trim($("#subconcepto").val());
    detalle = $.trim($("#detalle").val());
    comentario = $.trim($("#comentario").val());    
    saldo= "";
    id_movimientos ="";
    opcion = 1; //alta

    $.ajax({
        url: "./modelo/crud_movimientos.php",
        type: "POST",
        dataType: "json", //Formato en el que se enviarán los datos del formulario
        data: {         id_movimientos:id_movimientos,
                        opcion:opcion,                        
                        fecha_movimiento:fecha_movimiento,
                        importe:importe,
                        tipo_movimiento:tipo_movimiento,
                        tipo_operacion:tipo_operacion,
                        id_conceptos:id_conceptos,
                        concepto:concepto,
                        id_subconcepto:id_subconcepto,
                        subconcepto:subconcepto,
                        detalle:detalle,
                        comentario:comentario,
                        saldo:saldo,
                        },
        success: function(data){  
            
            console.log(data);
            
            id_movimientos = data[0].id_movimientos;
            id_conceptos = data[0].id_conceptos;
            concepto = data[0].concepto;
            id_subconcepto = data[0].id_subconcepto;           
            subconcepto = data[0].subconcepto;                       
            fecha_movimiento = data[0].fecha_movimiento;  //Estos campos data[0].clave corresponden a los datos del arreglo de los campos desde el CRUD_MOVIMIENTOS         
            tipo_movimiento = data[0].tipo_movimiento;
            tipo_operacion = data[0].tipo_operacion;
            detalle = data[0].detalle;
            comentario = data[0].comentario;
            saldo= data[0].saldo;
            importe =data[0].importe;

            //Dibujamos una nueva fila en la tabla de conceptos con el último registrado ingresado
            //para que no se recargue la página

            //Al INSERTAR
            if(opcion == 1){tab_movimientos.row.add([ id_movimientos,
                                                    fecha_movimiento,
                                                        id_conceptos,
                                                            concepto,
                                                      id_subconcepto,
                                                         subconcepto,
                                                             detalle,
                                                     tipo_movimiento,                                                     
                                                          comentario,
                                                      tipo_operacion,
                                                             importe,
                                                               saldo]).draw();}
            //Al Editar 
           else{tab_movimientos.row.add([             id_movimientos,
                                                    fecha_movimiento,
                                                        id_conceptos,
                                                            concepto,
                                                      id_subconcepto,
                                                         subconcepto,
                                                             detalle,
                                                     tipo_movimiento,                                                     
                                                          comentario,
                                                      tipo_operacion,
                                                             importe,
                                                               saldo]).draw();}            
            
        }        
    });   
     
    $("#formMovimientos").trigger("reset");   

    if(opcion == 1){
        $('#mensaje').html('<button type="button" class="btn btn-block bg-gradient-info btn-sm">Registro agregado con éxito</button>').show(200).delay(2500).hide(200);
        $('#saldo1');}
    
    else{$('.modal-mensaje').css("background-color", "#28a745").html('Registro actualizado con éxito').show(200).delay(2500).hide(200);}

        

    
});

});