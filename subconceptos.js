$(document).ready(function(){

    $("#concepto").on("change", function(){
    //alert("HOLA ALE")
    var id = $("#concepto").val()
    var opcion= 1
    // alert(id)
    $.ajax({
        type: "POST",
        url: "./modelo/carga_subconceptos.php",        
        data:{'id':id,
             'opcion':opcion}
    })
    .done(function(combosubconcepto){
        $('#subconcepto').html(combosubconcepto)
    })
    .fail(function(){
        alert("Error al cargar el combo Subconcepto")
    })

     })   
})