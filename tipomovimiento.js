$(document).ready(function(){

    $("#concepto").on("change", function(){
    //alert("HOLA ALE")
    var id = $("#concepto").val()
    // alert(id)
    $.ajax({
        type: "POST",
        url: "./modelo/carga_tipomovimiento.php",        
        data:{'id':id}
    })
    .done(function(combotipomovimiento){
        //alert(combotipomovimiento)
        $("#tipo_movimiento").val(combotipomovimiento);
    })
    .fail(function(){
        alert("Error al cargar el combo Tipo de movimiento")
    })

     })   
})