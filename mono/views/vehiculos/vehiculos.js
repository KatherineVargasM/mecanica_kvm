function init() {
    $("#form_vehiculos").on("submit", (e) => {
        GuardarEditar(e);
    });
}

const ruta = "../../controllers/vehiculos.controllers.php?op=";
const rutaClientes = "../../controllers/clientes.controllers.php?op=";

$(document).ready(() => {
    CargaLista();
    CargarClientes();
});

var CargaLista = () => {
    var html = "";
    $.get(ruta + "todos", (lista) => {
        try {
            let vehiculos = (typeof lista === "string") ? JSON.parse(lista) : lista;
            
            $.each(vehiculos, (index, vehiculo) => {
                html += `<tr>
                    <td>${index + 1}</td>
                    <td>${vehiculo.marca}</td>
                    <td>${vehiculo.modelo}</td>
                    <td>${vehiculo.anio}</td>
                    <td>${vehiculo.tipo_motor == 'dos_tiempos' ? '2 Tiempos' : '4 Tiempos'}</td>
                    <td>${vehiculo.nombres} ${vehiculo.apellidos}</td>
                    <td>
                        <button class='btn btn-primary btn-sm' onclick='uno(${vehiculo.id})'>
                            <i class="bx bx-edit-alt"></i> Editar
                        </button>
                        <button class='btn btn-danger btn-sm' onclick='eliminar(${vehiculo.id})'>
                            <i class="bx bx-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>`;
            });
            $("#ListaVehiculos").html(html);
        } catch (error) {
            console.error("Error al cargar la lista: ", error);
        }
    });
};

var CargarClientes = () => {
    $.get(rutaClientes + "todos", (lista) => {
        try {
            let clientes = (typeof lista === "string") ? JSON.parse(lista) : lista;
            let html = "<option value=''>Seleccione un Cliente</option>";
            
            $.each(clientes, (index, cliente) => {
                html += `<option value='${cliente.id}'>${cliente.nombres} ${cliente.apellidos}</option>`;
            });
            
            $("#id_cliente").html(html);
        } catch (error) {
            console.error("Error al cargar clientes: ", error);
        }
    });
};

var nuevo = () => {
    $("#tituloModal").html("Nuevo Vehículo");
    $("#form_vehiculos")[0].reset();
    $("#idVehiculo").val("");
    $("#ModalVehiculos").modal("show");
};

var uno = (id) => {
    $("#tituloModal").html("Editar Vehículo");
    $.post(ruta + "uno", { idVehiculo: id }, (vehiculo) => {
        try {
            vehiculo = (typeof vehiculo === "string") ? JSON.parse(vehiculo) : vehiculo;
            
            $("#idVehiculo").val(vehiculo.id);
            $("#id_cliente").val(vehiculo.id_cliente);
            $("#marca").val(vehiculo.marca);
            $("#modelo").val(vehiculo.modelo);
            $("#anio").val(vehiculo.anio);
            $("#tipo_motor").val(vehiculo.tipo_motor);
            
            $("#ModalVehiculos").modal("show");
        } catch (error) {
            console.error("Error al cargar datos:", error);
        }
    });
};

var GuardarEditar = (e) => {
    e.preventDefault();
    var DatosFormulario = new FormData($("#form_vehiculos")[0]);
    var accion = "";
    var id = $("#idVehiculo").val();

    if (id > 0) {
        accion = ruta + "actualizar";
        DatosFormulario.append("idVehiculo", id);
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
    if(confirm("¿Estás seguro de eliminar este vehículo?")){
        $.post(ruta + "eliminar", { idVehiculo: id }, (respuesta) => {
            try {
                let r = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
                if (r.status === "ok") {
                    alert("Vehículo eliminado");
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
    $("#idVehiculo").val("");
    $("#form_vehiculos")[0].reset();
    $("#ModalVehiculos").modal("hide");
};

init();