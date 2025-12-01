function init() {
    $("#form_tipo_servicio").on("submit", (e) => {
        GuardarEditar(e);
    });
}

const ruta = "../../controllers/tipo_servicio.controllers.php?op=";

$(document).ready(() => {
    var tabla = $('#Tabla_Tipo_Servicio').DataTable({
        "processing": true,
        "serverSide": false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                className: 'btn btn-success', 
                text: 'PDF',
                title: 'Reporte de Servicios de Mecánica',
                filename: 'Reporte_de_Servicios_Mecanica',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                customize: function(doc) {
                    doc.styles.title = {
                        color: 'black',
                        fontSize: '20',
                        alignment: 'center'
                    };
                    doc.styles.tableHeader.alignment = 'center'; 
                    doc.defaultStyle.alignment = 'center';
                    doc.content[1].table.widths = ['10%', '50%', '20%', '20%']; 
                }
            },
            {
                extend: 'excel',
                className: 'btn btn-primary', 
                text: 'Excel',
                title: 'Reporte de Servicios de Mecánica',
                filename: 'Reporte_de_Servicios_Mecanica',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'csv',
                className: 'btn btn-success', 
                text: 'CSV',
                title: 'Reporte de Servicios de Mecánica',
                filename: 'Reporte_de_Servicios_Mecanica',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ],
        "ajax": {
            url: ruta + "todos",
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });

    var botonesDT = tabla.buttons().container().find('.btn');
    $('#botones_accion').prepend(botonesDT);
    $('#Tabla_Tipo_Servicio_filter').appendTo('#buscador_personalizado');
});

var GuardarEditar = (e) => {
    e.preventDefault();
    var DatosFormularioServicio = new FormData($("#form_tipo_servicio")[0]);
    var accion = "";
    var id = document.getElementById("idTipoServicio").value;

    if (id > 0) {
        accion = ruta + "actualizar";
        DatosFormularioServicio.append("idTipoServicio", id);
    } else {
        accion = ruta + "insertar";
    }

    if(document.getElementById("estado").checked) {
        DatosFormularioServicio.append('estado', 1);
    } else {
        DatosFormularioServicio.append('estado', 0);
    }

    $.ajax({
        url: accion,
        type: "post",
        data: DatosFormularioServicio,
        processData: false,
        contentType: false,
        cache: false,
        success: (respuesta) => {
            try {
                let respClean = respuesta.toString().trim().replace(/^"|"$/g, '');
                
                if (respClean == "ok" || respuesta == "ok") {
                    alert("Se guardó con éxito");
                    $('#Tabla_Tipo_Servicio').DataTable().ajax.reload(); 
                    LimpiarCajas();
                } else {
                    alert("Error al guardar: " + respuesta);
                }
            } catch (err) {
                 alert("Se guardó con éxito");
                 $('#Tabla_Tipo_Servicio').DataTable().ajax.reload();
                 LimpiarCajas();
            }
        },
    });
};

var uno = async (idTipoServicio) => {
    $.post(ruta + "uno", { id_tipo_servicio: idTipoServicio }, (tipo_servicio) => {
        try {
            let data = (typeof tipo_servicio === "string") ? JSON.parse(tipo_servicio) : tipo_servicio;
            
            document.getElementById("idTipoServicio").value = data.id;
            document.getElementById("detalle").value = data.detalle;
            document.getElementById("valor").value = data.valor;
            
            document.getElementById("tituloModal").innerHTML = "Editar Servicio de Mecánica";

            if (data.estado == 1) {
                document.getElementById("estado").checked = true;
            } else {
                document.getElementById("estado").checked = false;
            }
            updateEstadoLabel();
            $("#ModalTipo_Servicio").modal("show"); 
        } catch (e) {
            console.error(e);
        }
    });
};

var eliminar = (idTipoServicio) => {
    if(confirm("¿Eliminar registro?")) {
        $.post(ruta + "eliminar", { idTipoServicio: idTipoServicio }, (respuesta) => {
            if (respuesta.includes("ok")) {
                alert("Se eliminó con éxito");
                $('#Tabla_Tipo_Servicio').DataTable().ajax.reload();
            } else {
                alert("Error al eliminar");
            }
        });
    }
};

var eliminarsuave = (idTipoServicio) => {
    if(confirm("¿Desactivar registro?")) {
        $.post(ruta + "eliminarsuave", { idTipoServicio: idTipoServicio  }, (respuesta) => {
            if (respuesta.includes("ok")) {
                alert("Se eliminó con éxito");
                $('#Tabla_Tipo_Servicio').DataTable().ajax.reload();
            } else {
                alert("Error al eliminar");
            }
        });
    }
};

var LimpiarCajas = () => {
    document.getElementById("idTipoServicio").value = "";
    document.getElementById("tituloModal").innerHTML = "Nuevo Servicio de Mecánica";
    $("#form_tipo_servicio")[0].reset();
    $("#ModalTipo_Servicio").modal("hide");
    updateEstadoLabel();
};

var updateEstadoLabel = () => {
    const estadoCheckbox = document.getElementById("estado");
    const estadoLabel = document.getElementById("lblEstado");
    if (estadoCheckbox.checked) {
        estadoLabel.textContent = "Activo";
    } else {
        estadoLabel.textContent = "Inactivo";
    }
}

var imprimirTabla = () => {
   var tablaOriginal = document.getElementById("Tabla_Tipo_Servicio");
   var tablaClone = tablaOriginal.cloneNode(true);

   var theadRow = tablaClone.querySelector("thead tr");
   if (theadRow && theadRow.lastElementChild) {
       theadRow.removeChild(theadRow.lastElementChild);
   }

   var tbodyRows = tablaClone.querySelectorAll("tbody tr");
   tbodyRows.forEach(row => {
       if (row.lastElementChild) {
           row.removeChild(row.lastElementChild);
       }
   });

   var titulo = '<h2 style="text-align: center; margin-bottom: 20px;">Reporte de Servicios de Mecánica</h2>';

   var contenidoOriginal = document.body.innerHTML;
   document.body.innerHTML = titulo + tablaClone.outerHTML;
   
   window.print();
   
   document.body.innerHTML = contenidoOriginal;
   window.location.reload(); 
}

init();