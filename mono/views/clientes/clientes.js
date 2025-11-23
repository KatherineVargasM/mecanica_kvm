function init() {
    $("#form_clientes").on("submit", (e) => {
        GuardarEditar(e);
    });
}

const ruta = "../../controllers/clientes.controllers.php?op=";

$(document).ready(() => {
    CargaLista();
});

var CargaLista = () => {
    var html = "";
    $.get(ruta + "todos", (lista) => {
        try {
            let clientes = (typeof lista === "string") ? JSON.parse(lista) : lista;
            
            $.each(clientes, (index, cliente) => {
                html += `<tr>
                    <td>${index + 1}</td>
                    <td>${cliente.nombres}</td>
                    <td>${cliente.apellidos}</td>
                    <td>${cliente.telefono || '-'}</td>
                    <td>${cliente.correo_electronico || '-'}</td>
                    <td>
                        <button class='btn btn-primary btn-sm' onclick='uno(${cliente.id})'>
                            <i class="bx bx-edit-alt"></i> Editar
                        </button>
                        <button class='btn btn-danger btn-sm' onclick='eliminar(${cliente.id})'>
                            <i class="bx bx-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>`;
            });
            $("#ListaClientes").html(html);
        } catch (error) {
            console.error("Error al cargar la lista: ", error);
        }
    });
};

var nuevo = () => {
    $("#tituloModal").html("Nuevo Cliente");
    $("#form_clientes")[0].reset();
    $("#idCliente").val("");
    $("#ModalClientes").modal("show");
};

var uno = (id) => {
    $("#tituloModal").html("Editar Cliente");
    $.post(ruta + "uno", { idCliente: id }, (cliente) => {
        try {
            cliente = (typeof cliente === "string") ? JSON.parse(cliente) : cliente;
            
            $("#idCliente").val(cliente.id);
            $("#nombres").val(cliente.nombres);
            $("#apellidos").val(cliente.apellidos);
            $("#telefono").val(cliente.telefono);
            $("#correo_electronico").val(cliente.correo_electronico);
            
            $("#ModalClientes").modal("show");
        } catch (error) {
            console.error("Error al cargar datos del cliente:", error);
            alert("Error al cargar los datos para editar.");
        }
    });
};

var GuardarEditar = (e) => {
    e.preventDefault();
    var DatosFormulario = new FormData($("#form_clientes")[0]);
    var accion = "";
    var id = $("#idCliente").val();

    if (id > 0) {
        accion = ruta + "actualizar";
        DatosFormulario.append("idCliente", id);
    } else {
        accion = ruta + "insertar";
    }

    $.ajax({
        url: accion,
        type: "post",
        data: DatosFormulario,
        processData: false,
        contentType: false, 
        cache: false,
        success: (respuesta) => {
            try {
                let r = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
                if (r.status === "ok") {
                    alert("¡Guardado con éxito!");
                    CargaLista();
                    LimpiarCajas();
                } else {
                    alert("Error al guardar: " + (r.mensaje || "Error desconocido"));
                }
            } catch (error) {
                console.error(error);
                alert("Error al procesar la respuesta del servidor.");
            }
        },
        error: (e) => {
            console.error(e);
            alert("Ocurrió un error de conexión.");
        }
    });
};

var eliminar = (id) => {
    if(confirm("¿Estás seguro de eliminar este cliente?")){
        $.post(ruta + "eliminar", { idCliente: id }, (respuesta) => {
            try {
                let r = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
                if (r.status === "ok") {
                    alert("Cliente eliminado");
                    CargaLista();
                } else {
                    alert("Error al eliminar: " + (r.mensaje || "Error desconocido"));
                }
            } catch (error) {
                console.error("Error al eliminar:", error);
                alert("Error al procesar la eliminación.");
            }
        });
    }
};

var LimpiarCajas = () => {
    $("#idCliente").val("");
    $("#form_clientes")[0].reset();
    $("#ModalClientes").modal("hide");
};

init();