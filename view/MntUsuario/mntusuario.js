var tabla;

function init() {}

$(document).ready(function(){
    tabla=$('#usuario_data').dataTable({
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
            'pdfHtml5',
        ],
        "ajax": {
            url: '../../controller/usuario.php?op=listar',
            type: "post",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcesing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria":{
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();
});

function editar(usu_id){
    $('#mdltitulo').html('Editar registro');
    $('#modalMantenimiento').modal('show');
}

function eliminar(usu_id){
    swal(
        {
          title: "HelpDesk?",
          text: "Esta seguro de eliminar el registro?",
          type: "error",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Si",
          cancelButtonText: "No",
          closeOnConfirm: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            $.post(
              "../../controller/usuario.php?op=eliminar",
              { usu_id: usu_id },
              function (data) {}
            );
    
            $('#usuario_data').DataTable().ajax.reload();
                
            swal({
              title: "HelpDesk",
              text: "Registro eliminado.",
              type: "success",
              confirmButtonClass: "btn-success",
            });
          }
        }
      );
}

$(document).on("click", "#btnnuevo", function () {
    $('#mdltitulo').html('Nuevo registro');
    $('#modalMantenimiento').modal('show');
});

init();
