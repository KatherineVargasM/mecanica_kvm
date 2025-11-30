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
                text: 'PDF'
            },
            {
                extend: 'excel',
                className: 'btn btn-primary', 
                text: 'Excel'
            },
            {
                extend: 'csv',
                className: 'btn btn-success', 
                text: 'CSV'
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
   var tabla = document.getElementById("Tabla_Tipo_Servicio").outerHTML;
   var contenidoOriginal = document.body.innerHTML;
   document.body.innerHTML = tabla;
   window.print();
   document.body.innerHTML = contenidoOriginal;
   window.location.reload();
}

init();