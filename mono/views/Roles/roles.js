function init() {
    $("#form_roles").on("submit", (e) => {
        GuardarEditar(e);
    });
}

const ruta = "../../controllers/roles.controllers.php?op=";

$(document).ready(() => {
    CargaLista();
});

var CargaLista = () => {
    var html = "";
    $.get(ruta + "todos", (lista) => {
        try {
            let roles = (typeof lista === "string") ? JSON.parse(lista) : lista;
            
            $.each(roles, (index, rol) => {
                html += `<tr>
                    <td>${index + 1}</td>
                    <td>${rol.nombre}</td>
                    <td>${rol.descripcion || '-'}</td>
                    <td>
                        <button class='btn btn-primary btn-sm' onclick='uno(${rol.id})'>
                            <i class="bx bx-edit-alt"></i> Editar
                        </button>
                        <button class='btn btn-danger btn-sm' onclick='eliminar(${rol.id})'>
                            <i class="bx bx-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>`;
            });
            $("#ListaRoles").html(html);
        } catch (error) {
            console.error("Error al cargar la lista: ", error);
        }
    });
};

var nuevo = () => {
    $("#tituloModal").html("Nuevo Rol");
    $("#form_roles")[0].reset();
    $("#idRol").val("");
    $("#ModalRoles").modal("show");
};

var uno = (id) => {
    $("#tituloModal").html("Editar Rol");
    $.post(ruta + "uno", { idRol: id }, (rol) => {
        try {
            rol = (typeof rol === "string") ? JSON.parse(rol) : rol;
            
            $("#idRol").val(rol.id);
            $("#nombre").val(rol.nombre);
            $("#descripcion").val(rol.descripcion);
            
            $("#ModalRoles").modal("show");
        } catch (error) {
            console.error("Error al cargar datos:", error);
        }
    });
};

var GuardarEditar = (e) => {
    e.preventDefault();
    var DatosFormulario = new FormData($("#form_roles")[0]);
    var accion = "";
    var id = $("#idRol").val();

    if (id > 0) {
        accion = ruta + "actualizar";
        DatosFormulario.append("idRol", id);
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
    if(confirm("¿Estás seguro de eliminar este rol?")){
        $.post(ruta + "eliminar", { idRol: id }, (respuesta) => {
            try {
                let r = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
                if (r.status === "ok") {
                    alert("Rol eliminado");
                    CargaLista();
                } else {
                    alert("Error al eliminar: " + (r.mensaje || "Error desconocido"));
                }
            } catch (error) {
                console.error("Error al eliminar:", error);
            }
        });
    }
};

var LimpiarCajas = () => {
    $("#idRol").val("");
    $("#form_roles")[0].reset();
    $("#ModalRoles").modal("hide");
};

init();