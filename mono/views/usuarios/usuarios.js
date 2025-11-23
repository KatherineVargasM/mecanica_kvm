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

        if (typeof ListUsuarios === "string") {
            ListUsuarios = JSON.parse(ListUsuarios);
        }
        
        $.each(ListUsuarios, (index, usuario) => {
          html += `<tr>
                <td>${index + 1}</td>
                <td>${usuario.nombre_usuario}</td>
                <td>${usuario.nombre}</td>
                <td>
                    <button class='btn btn-primary btn-sm' onclick='uno(${usuario.id})'>
                        <i class="bx bx-edit-alt"></i> Editar
                    </button>
                    <button class='btn btn-danger btn-sm' onclick='eliminar(${usuario.id})'>
                        <i class="bx bx-trash"></i> Eliminar
                    </button>
                    <button class='btn btn-warning btn-sm' onclick='eliminarsuave(${usuario.id})'>
                        <i class="bx bx-user-x"></i> Eliminar Suave
                    </button>
                </td>
               </tr> `;
        });
        $("#ListaUsuarios").html(html);
    } catch (error) {
        console.error("Error en CargaLista:", error);
    }
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioUsuario = new FormData($("#form_usuarios")[0]);
  var accion = "";
  var SucursalId = $("#idUsuarios").val();

  if (SucursalId > 0) {
    accion = ruta + "actualizar";
    DatosFormularioUsuario.append("id", SucursalId);
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
      try {
          if (typeof respuesta === "string") {
              respuesta = JSON.parse(respuesta);
          }

          if (respuesta == "ok" || respuesta.status == "ok") {
            alert("¡Guardado con éxito!");
            CargaLista();
            LimpiarCajas();
          } else {
            alert("Error al guardar: " + (respuesta.mensaje || respuesta));
          }
      } catch (error) {

          if(String(respuesta).includes("ok")){
              alert("¡Guardado con éxito!");
              CargaLista();
              LimpiarCajas();
          } else {
              console.error(error);
              alert("Error al procesar respuesta.");
          }
      }
    },
  });
};


var uno = async (idUsuarios) => {
  $("#tituloModal").html("Editar Usuario");
  
  await roles(); 
  $.post(ruta + "uno", { idUsuarios: idUsuarios }, (usuario) => {
    try {
      
        if (typeof usuario === "string") {
            usuario = JSON.parse(usuario);
        }
        
        $("#idUsuarios").val(usuario.id);
        $("#NombreUsuario").val(usuario.nombre_usuario);
        $("#contrasenia").val(usuario.contrasenia); 
        $("#id_rol").val(usuario.id_rol);
        

        $("#ModalUsuarios").modal("show");
    } catch (error) {
        console.error("Error en uno():", error);
    }
  });
};

var roles = () => {
  return new Promise((resolve, reject) => {
    var html = `<option value="0">Seleccione una opción</option>`;
    $.post("../../controllers/roles.controllers.php?op=todos", (ListaRoles) => {
        try {

            if (typeof ListaRoles === "string") {
                ListaRoles = JSON.parse(ListaRoles);
            }
            
            $.each(ListaRoles, (index, rol) => {
              html += `<option value="${rol.id}">${rol.nombre}</option>`;
            });
            $("#id_rol").html(html);
            resolve();
        } catch (error) {
            reject(error);
        }
    }).fail((error) => {
      reject(error);
    });
  });
};


var nuevo = () => {
    $("#tituloModal").html("Nuevo Usuario");
    $("#form_usuarios")[0].reset();
    $("#idUsuarios").val("");
    roles();
    $("#ModalUsuarios").modal("show");
};

var eliminar = (idUsuarios) => {
    if (confirm("¿Estás seguro de eliminar este usuario permanentemente?")) {
        $.post(ruta + "eliminar", { idUsuarios: idUsuarios }, (respuesta) => {
            
            if (!respuesta) {
                console.warn("Respuesta vacía del servidor");
                alert("NO SE PUEDE ELIMINAR: El usuario tiene historial registrado.");
                return;
            }
            try {
                if (typeof respuesta === "string" && (respuesta.startsWith("{") || respuesta.startsWith("\""))) {
                    respuesta = JSON.parse(respuesta);
                }
            } catch (e) {
                console.warn("La respuesta:", respuesta);
            }

            if (String(respuesta).trim() === "ok" || respuesta.status === "ok") {
                alert("Se eliminó con éxito");
                CargaLista();
            } else {
                alert(respuesta);
            }
        });
    }
};

var eliminarsuave = (idUsuarios) => {
    if(confirm("¿Eliminar suavemente?")){
        $.post(ruta + "eliminarsuave", { idUsuarios: idUsuarios }, (respuesta) => {
            if (typeof respuesta === "string") respuesta = JSON.parse(respuesta);
            
            if (respuesta == "ok" || respuesta.status == "ok") {
                alert("Eliminado suavemente");
                CargaLista();
            } else {
                alert("Error al eliminar");
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