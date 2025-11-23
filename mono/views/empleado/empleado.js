function init() {
    $("#form_empleado").on("submit", (e) => {
        GuardarEditar(e);
    });
}

const ruta = "../../controllers/empleado.controllers.php?op=";

$(document).ready(() => {
    CargaLista();
});

var CargaLista = () => {
    var html = "";
    $.get(ruta + "todos", (lista) => {
        try {
            let empleados = (typeof lista === "string") ? JSON.parse(lista) : lista;
            
            if(empleados.length === 0){
                 html = `<tr><td colspan="6" class="text-center">No hay empleados activos</td></tr>`;
            } else {
                $.each(empleados, (index, emp) => {
                    html += `<tr>
                        <td>${index + 1}</td>
                        <td>${emp.cedula}</td>
                        <td>${emp.nombres} ${emp.apellidos}</td>
                        <td>${emp.cargo}</td>
                        <td>${emp.correo || '-'}</td>
                        <td>
                            <button class='btn btn-primary btn-sm' onclick='uno(${emp.id})'>
                                <i class="bx bx-edit-alt"></i> Editar
                            </button>
                            <button class='btn btn-danger btn-sm' onclick='eliminar(${emp.id})'>
                                <i class="bx bx-trash"></i> Eliminar
                            </button>
                            <button class='btn btn-warning btn-sm' onclick='eliminarsuave(${emp.id})'>
                                <i class="bx bx-user-x"></i> Eliminar Suave
                            </button>
                        </td>
                    </tr>`;
                });
            }
            $("#ListaEmpleados").html(html);
        } catch (error) {
            console.error("Error al cargar lista:", error);
        }
    });
};

var nuevo = () => {
    $("#tituloModal").html("Nuevo Empleado");
    $("#form_empleado")[0].reset();
    $("#idEmpleado").val("");
    $("#ModalEmpleado").modal("show");
};

var uno = (id) => {
    $("#tituloModal").html("Editar Empleado");
    $.post(ruta + "uno", { idEmpleado: id }, (emp) => {
        try {
            emp = (typeof emp === "string") ? JSON.parse(emp) : emp;
            
            $("#idEmpleado").val(emp.id);
            $("#cedula").val(emp.cedula);
            $("#nombres").val(emp.nombres);
            $("#apellidos").val(emp.apellidos);
            $("#correo").val(emp.correo);
            $("#telefono").val(emp.telefono);
            $("#cargo").val(emp.cargo);
            
            $("#ModalEmpleado").modal("show");
        } catch (error) {
            console.error("Error al cargar datos:", error);
            alert("Error al cargar los datos.");
        }
    });
};

var GuardarEditar = (e) => {
    e.preventDefault();
    var DatosFormulario = new FormData($("#form_empleado")[0]);
    var accion = "";
    var id = $("#idEmpleado").val();

    if (id > 0) {
        accion = ruta + "actualizar";
        DatosFormulario.append("idEmpleado", id);
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
                alert("Error de conexión.");
            }
        },
    });
};

var eliminar = (id) => {
    if(confirm("¿Estás seguro de eliminar permanentemente?")){
        $.post(ruta + "eliminar", { idEmpleado: id }, (respuesta) => {
            let r = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
            if (r.status == "ok") {
                alert("Eliminado");
                CargaLista();
            } else {
                alert("Error al eliminar");
            }
        });
    }
};

var eliminarsuave = (id) => {
    if(confirm("¿Realizar eliminación suave?")){
        $.post(ruta + "eliminarsuave", { idEmpleado: id }, (respuesta) => {
            let r = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
            if (r.status == "ok") {
                alert("Eliminado suavemente");
                CargaLista();
            } else {
                alert("Error al desactivar");
            }
        });
    }
};

var LimpiarCajas = () => {
    $("#idEmpleado").val("");
    $("#form_empleado")[0].reset();
    $("#ModalEmpleado").modal("hide");
};

init();