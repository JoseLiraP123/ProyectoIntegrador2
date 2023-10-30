var tabla;
var usu_id =  $('#user_idx').val();
var rol_id =  $('#rol_idx').val();

function init(){
    $("#ticket_form").on("submit",function(e){
        guardar(e);	
    });
}

$(document).ready(function(){

    /* TODO: Llenar Combo Categoria */
    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#cat_id').html(data);
    });

    /* TODO: llenar Combo Prioridad */
    $.post("../../controller/prioridad.php?op=combo",function(data, status){
        $('#prio_id').html(data);
    });

    /* TODO:LLenar Combo usuario asignar */
    $.post("../../controller/usuario.php?op=combo", function (data) {
        $('#usu_asig').html(data);
    });

    /* TODO: rol si es 1 entonces es usuario */
    if (rol_id==1){
        $('#viewuser').hide();

        tabla=$('#ticket_data').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                    ],
            "ajax":{
                url: '../../controller/ticket.php?op=listar_x_usu',
                type : "post",
                dataType : "json",
                data:{ usu_id : usu_id },
                error: function(e){
                    console.log(e.responseText);
                }
            },
            "ordering": false,
            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,
            "autoWidth": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }     
        }).DataTable();
    }else{
        /* TODO: Filtro avanzado en caso de ser soporte */
        var tick_titulo = $('#tick_titulo').val();
        var cat_id = $('#cat_id').val();
        var prio_id = $('#prio_id').val();

        listardatatable(tick_titulo,cat_id,prio_id);
    }
});

/* TODO: Link para poder ver el detalle de ticket en otra ventana */
$(document).on("click",".btn-inline",function(){
    const ciphertext = $(this).data("ciphertext");
    window.open('http://localhost/ProyectoIntegrador2/view/DetalleTicket/?ID='+ ciphertext +'');
});

/* TODO: Mostrar datos antes de asignar */
function asignar(tick_id){
    console.log(tick_id);
    $.post("../../controller/ticket.php?op=mostrar_noencry", {tick_id : tick_id}, function (data) {
        data = JSON.parse(data);
        $('#tick_id').val(data.tick_id);

        $('#mdltitulo').html('Asignar Agente');
        $("#modalasignar").modal('show');
    });
}

/* TODO: Guardar asignacion de usuario de soporte */
function guardar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var tick_id = $('#tick_id').val();

            /* TODO:Recargar Datatable JS */
            $('#ticket_data').DataTable().ajax.reload();

            /* TODO: enviar Email de alerta de asignacion */
            $.post("../../controller/email.php?op=ticket_asignado", {tick_id : tick_id}, function (data) {

            });

            /* TODO: enviar Whaspp de alerta de asignacion */
            $.post("../../controller/whatsapp.php?op=w_ticket_asignado", {tick_id : tick_id}, function (data) {

            });

            /* TODO: Alerta de confirmacion */
            swal("Correcto!", "Asignado Correctamente", "success");

            /* TODO: Ocultar Modal */
            $("#modalasignar").modal('hide');
        }
    });
}

/* TODO:Reabrir ticket */
function CambiarEstado(tick_id){
    swal({
        title: "HelpDesk",
        text: "Esta seguro de Reabrir el Ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            /* TODO: Enviar actualizacion de estado */
            $.post("../../controller/ticket.php?op=reabrir", {tick_id : tick_id,usu_id : usu_id}, function (data) {

            });

            /* TODO:Recargar datatable js */
            $('#ticket_data').DataTable().ajax.reload();	

            /* TODO: Mensaje de Confirmacion */
            swal({
                title: "HelpDesk!",
                text: "Ticket Abierto.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

/* TODO:Filtro avanzado */
$(document).on("click","#btnfiltrar", function(){
    limpiar();

    var tick_titulo = $('#tick_titulo').val();
    var cat_id = $('#cat_id').val();
    var prio_id = $('#prio_id').val();

    listardatatable(tick_titulo,cat_id,prio_id);

});

/* TODO: Restaurar Datatable js y limpiar */
$(document).on("click","#btntodo", function(){
    limpiar();

    $('#tick_titulo').val('');
    $('#cat_id').val('').trigger('change');
    $('#prio_id').val('').trigger('change');

    listardatatable('','','');
});

/* TODO: Listar datatable con filtro avanzado */
function listardatatable(tick_titulo,cat_id,prio_id){
    tabla=$('#ticket_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/ticket.php?op=listar_filtro',
            type : "post",
            dataType : "json",
            data:{ tick_titulo:tick_titulo,cat_id:cat_id,prio_id:prio_id},
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable().ajax.reload();
}

/* TODO: Limpiamos restructurando el html del datatable js */
function limpiar(){
    $('#table').html(
        "<table id='ticket_data' class='table table-bordered table-striped table-vcenter js-dataTable-full'>"+
            "<thead>"+
                "<tr>"+
                    "<th style='width: 5%;'>Nro.Ticket</th>"+
                    "<th style='width: 15%;'>Categoria</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 30%;'>Titulo</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Prioridad</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Estado</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Creación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Asignación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Cierre</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Soporte</th>"+
                    "<th class='text-center' style='width: 5%;'></th>"+
                "</tr>"+
            "</thead>"+
            "<tbody>"+

            "</tbody>"+
        "</table>"
    );
}

init();