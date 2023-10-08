function init(){
    
}

$(document).ready(function() {
    
});

$(document).on("click", "#btnsoporte", function(){
    
    if($('#rol_id').val()==1){
        $('#lbltitulo').html("Acceso para Soporte");
        $('#btnsoporte').html("Acceso Usuarios");
        $('#rol_id').val(2);
        $("#imgtipo").attr("src","public/2.jpg");
    }else{
        $('#lbltitulo').html("Acceso para Usuarios");
        $('#btnsoporte').html("Acceso Soporte");
        $('#rol_id').val(1);
        $("#imgtipo").attr("src","public/1.jpg");
    }
    
    
});


init();