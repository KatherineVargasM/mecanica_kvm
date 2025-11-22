function init() {
    $("#form_usuarios").on("submit", (e) => {
        GuardarEditar(e);
    });
}

const ruta = "../../controllers/usuario.controllers.php?op=";

$(document).ready(() => {
    CargaLista();
});


var CargaLista = () => {
    var html = "";
    $.get(ruta + "todos", (ListUsuarios) => {
        try {
            ListUsuarios = JSON.parse(ListUsuarios);
            $.each(ListUsuarios, (index, usuario) => {
                html += `<tr>
                    <td>${index + 1}</td>
                    <td>${usuario.nombre_usuario}</td>
                    <td>${usuario.nombre}</td>
                    <td>
                        <button class='btn btn-primary btn-sm' onclick='uno(${usuario.id})'>
                            <i class='bx bx-edit-alt'></i> Editar
                        </button>
                        <button class='btn btn-danger btn-sm' onclick='eliminar(${usuario.id})'>
                            <i class='bx bx-trash'></i> Eliminar
                        </button>
                        <button class='btn btn-warning btn-sm' onclick='eliminarsuave(${usuario.id})'>
                            <i class='bx bx-user-x'></i> Eliminar Suave
                        </button>
                    </td>
                </tr>`;
            });
            $("#ListaUsuarios").html(html);
        } catch (error) {
            console.error("Error al cargar la lista: ", error);
        }
    });
};


var nuevo = () => {
    $("#tituloModal").html("Nuevo Usuario");
    $("#form_usuarios")[0].reset();
    $("#idUsuarios").val("");
    roles();
    $("#ModalUsuarios").modal("show");
};


var uno = async (idUsuarios) => {
    $("#tituloModal").html("Editar Usuario");
    
    await roles();

    $.post(ruta + "uno", { idUsuarios: idUsuarios }, (usuario) => {
        usuario = JSON.parse(usuario);
        
        $("#idUsuarios").val(usuario.id);
        $("#NombreUsuario").val(usuario.nombre_usuario);
        $("#id_rol").val(usuario.id_rol);
        $("#contrasenia").val(usuario.contrasenia); 
        
        $("#ModalUsuarios").modal("show");
    });
};

var GuardarEditar = (e) => {
    e.preventDefault();
    var DatosFormularioUsuario = new FormData($("#form_usuarios")[0]);
    var accion = "";
    var UsuarioId = $("#idUsuarios").val();

    if (UsuarioId > 0) {
        accion = ruta + "actualizar";
        DatosFormularioUsuario.append("id", UsuarioId);
    } else {
        accion = ruta + "insertar";
    }

    $.ajax({
        url: accion,
        type: "post",
        data: DatosFormularioUsuario,
        processData: false,
        contentType: false,
        cache: false,
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);
            if (respuesta == "ok") {
                alert("¡Guardado con éxito!");
                CargaLista();
                LimpiarCajas();
            } else {
                alert("Error al guardar: " + respuesta);
            }
        },
    });
};

var roles = () => {
    return new Promise((resolve, reject) => {
        var html = `<option value="">Seleccione una opción</option>`;
        $.post("../../controllers/roles.controllers.php?op=todos", (ListaRoles) => {
            ListaRoles = JSON.parse(ListaRoles);
            $.each(ListaRoles, (index, rol) => {
                html += `<option value="${rol.id}">${rol.nombre}</option>`;
            });
            $("#id_rol").html(html);
            resolve();
        }).fail((error) => {
            console.error("Error cargando roles", error);
            reject();
        });
    });
};

var eliminar = (idUsuarios) => {
    if (confirm("¿Estás seguro de eliminar este usuario permanentemente?")) {
        $.post(ruta + "eliminar", { idUsuarios: idUsuarios }, (respuesta) => {
            respuesta = JSON.parse(respuesta);
            if (respuesta == "ok") {
                alert("Usuario eliminado");
                CargaLista();
            } else {
                alert("Error al eliminar");
            }
        });
    }
};

var eliminarsuave = (idUsuarios) => {
    if (confirm("¿Estás seguro de realizar la eliminación suave de este usuario?")) {
        $.post(ruta + "eliminarsuave", { idUsuarios: idUsuarios }, (respuesta) => {
            respuesta = JSON.parse(respuesta);
            if (respuesta == "ok") {
                alert("Usuario eliminado suavemente");
                CargaLista();
            } else {
                alert("Error al realizar eliminación suave");
            }
        });
    }
};

var LimpiarCajas = () => {
    $("#idUsuarios").val("");
    $("#form_usuarios")[0].reset();
    $("#ModalUsuarios").modal("hide");
};

init();