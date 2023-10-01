function init(){
    $("#ticket_form").on("submit", function(e){
       guardaryeditar(e); 
    });
}
            
            
$(document).ready(function() {
        $('#tick_descrip').summernote({
            height: 200
        });

        $.post("../../controller/categoria.php?op=combo", function(data, status){
            $('#cat_id').html(data);
        });
});
            
function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()==''){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        $.ajax({
            url: "../../controller/ticket.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos){  
                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }  
        }); 
    }
}

init();