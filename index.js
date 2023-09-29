function init(){
    
}

$(document).ready(function() {
    
});

$(document).on("click", "#btnsoporte", function(){
    
    if($('#rol_id').val()==1){
        $('#lbltitulo').html("Acceso para Soporte");
        $('#btnsoporte').html("Acceso Usuarios");
        $('#rol_id').val(2);
        console.log($('#rol_id').val());
    }else{
        $('#lbltitulo').html("Acceso para Usuarios");
        $('#btnsoporte').html("Acceso Soporte");
        $('#rol_id').val(1);
        console.log($('#rol_id').val());
    }
    
    
});


init();