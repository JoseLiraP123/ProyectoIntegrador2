function init(){
    
}

$(document).ready(function(){
    
    var tick_id = getUrlparameter('ID');
    
    listardetalle(tick_id);
    
    
    $.post("../../controller/ticket.php?op=mostrar", {tick_id : tick_id}, function(data){
        data = JSON.parse(data);
        $('#lblestado').html(data.tick_estado);
        $('#lblnomusuario').html(data.usu_nom +' '+ data.usu_ape);
        $('#lblfechcrea').html(data.fech_crea);
        $('#lblnomidticket').html("Detalle ticket - "+data.tick_id);
        $('#cat_nom').val(data.cat_nom);
        $('#tick_titulo').val(data.tick_titulo);
        
        $('#tickd_descripusu').summernote('code', data.tick_descrip );
    });
    
    $('#tickd_descrip').summernote({
        height: 250
    });
    
    $('#tickd_descripusu').summernote({
        height: 250
    });
    
    $('#tickd_descripusu').summernote('disable');

});

var getUrlparameter= function getUrlParameter(sParam){
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    for(i = 0; i < sURLVariables.length; i++){
        
        sParameterName = sURLVariables[i].split('=');
        
        if(sParameterName[0]===sParam){
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    
};

$(document).on("click","#btnenviar", function(){
    
    
    var tick_id = getUrlparameter('ID');

    var usu_id = $('#user_idx').val();
    var tickd_descrip = $('#tickd_descrip').val();

    if ($('#tickd_descrip').summernote('isEmpty')){
        swal("Atención!", "No ha escrito descripción", "warning");
    }else{
        $.post("../../controller/ticket.php?op=insertdetalle", { tick_id:tick_id,usu_id:usu_id,tickd_descrip:tickd_descrip}, function (data) {
            listardetalle(tick_id);
            $('#tickd_descrip').summernote('reset');
            swal("Correcto!", "Registrado Correctamente", "success");
        }); 
    }
});

$(document).on("click","#btncerrarticket", function(){
    
});

function listardetalle(tick_id){
    $.post("../../controller/ticket.php?op=listardetalle", { tick_id : tick_id }, function (data) {
        $('#lbldetalle').html(data);
    }); 

    $.post("../../controller/ticket.php?op=mostrar", { tick_id : tick_id }, function (data) {
        data = JSON.parse(data);
        $('#lblestado').html(data.tick_estado);
        $('#lblnomusuario').html(data.usu_nom +' '+data.usu_ape);
        $('#lblfechcrea').html(data.fech_crea);
        
        $('#lblnomidticket').html("Detalle Ticket - "+data.tick_id);

        $('#cat_nom').val(data.cat_nom);
        $('#tick_titulo').val(data.tick_titulo);
        $('#tickd_descripusu').summernote ('code',data.tick_descrip);

        if (data.tick_estado_texto == "Cerrado"){
            $('#pnldetalle').hide();
        }
    }); 
}


init();