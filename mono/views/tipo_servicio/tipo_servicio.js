function init() {
  $("#form_tipo_servicio").on("submit", (e) => {
    GuardarEditar(e);
  });
}
const ruta = "../../controllers/tipo_servicio.controllers.php?op=";

$(document).ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (Lista_Servicios) => {
    try {
        Lista_Servicios = JSON.parse(Lista_Servicios);
        $.each(Lista_Servicios, (index, servicio) => {
          html += `<tr>
                <td>${index + 1}</td>
                <td>${servicio.detalle}</td>
                <td>${servicio.valor}</td>
                <td>
                    <button class='btn btn-primary btn-sm' onclick='uno(${servicio.id})'>
                        <i class="bx bx-edit-alt"></i> Editar
                    </button>
                    <button class='btn btn-danger btn-sm' onclick='eliminar(${servicio.id})'>
                        <i class="bx bx-trash"></i> Eliminar
                    </button>
                    <button class='btn btn-warning btn-sm' onclick='eliminarsuave(${servicio.id})'>
                        <i class="bx bx-user-x"></i> Eliminar Suave
                    </button>
               </td>
               </tr> `;
        });
        $("#ListaServicios").html(html);
    } catch (error) {
        console.error("Error cargando lista", error);
    }
  });
};

var nuevo = () => {
    $("#tituloModal").html("Nuevo Servicio");
    $("#form_tipo_servicio")[0].reset();
    $("#idTipoServicio").val("");
    
    $("#estado").prop("checked", true);
    updateEstadoLabel();
    
    $("#ModalTipo_Servicio").modal("show");
};

var uno = async (idTipoServicio) => {
  $("#tituloModal").html("Editar Servicio");
  
  $.post(ruta + "uno", { id_tipo_servicio: idTipoServicio }, (tipo_servicio) => {
    tipo_servicio = JSON.parse(tipo_servicio);
    
    $("#idTipoServicio").val(tipo_servicio.id);
    $("#detalle").val(tipo_servicio.detalle);
    $("#valor").val(tipo_servicio.valor);
    
    if (tipo_servicio.estado == 1) {
      $("#estado").prop("checked", true);
    } else {
      $("#estado").prop("checked", false);
    }
    updateEstadoLabel();
    
    $("#ModalTipo_Servicio").modal("show");
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioServicio = new FormData($("#form_tipo_servicio")[0]);
  var accion = "";
  var id = $("#idTipoServicio").val();

  if (id > 0) {
    accion = ruta + "actualizar";
    DatosFormularioServicio.append("idTipoServicio", id);
  } else {
    accion = ruta + "insertar";
  }

  $.ajax({
    url: accion,
    type: "post",
    data: DatosFormularioServicio,
    processData: false,
    contentType: false, 
    cache: false,
    success: (respuesta) => {
      respuesta = JSON.parse(respuesta);
      if (respuesta == "ok") {
        alert("Se guardó con éxito");
        CargaLista();
        LimpiarCajas();
      } else {
        alert("Error al guardar: " + respuesta);
      }
    },
  });
};

var eliminar = (idTipoServicio) => {
  if(confirm("¿Estás seguro de eliminar permanentemente?")){
      $.post(ruta + "eliminar", { idTipoServicio: idTipoServicio }, (respuesta) => {
        respuesta = JSON.parse(respuesta);
        if (respuesta == "ok") {
          alert("Se eliminó con éxito");
          CargaLista();
        } else {
          alert("Error al eliminar");
        }
      });
  }
};

var eliminarsuave = (idTipoServicio) => {
  if(confirm("¿Estás seguro de eliminar suavemente?")){
      $.post(ruta + "eliminarsuave", { idTipoServicio: idTipoServicio  }, (respuesta) => {
        respuesta = JSON.parse(respuesta);
        if (respuesta == "ok") {
          alert("Se eliminó con éxito");
          CargaLista();
        } else {
          alert("Error al eliminar");
        }
      });
  }
};

var LimpiarCajas = () => {
  $("#idTipoServicio").val("");
  $("#form_tipo_servicio")[0].reset();
  $("#ModalTipo_Servicio").modal("hide");
};

var updateEstadoLabel = () => {
  const estadoCheckbox = document.getElementById("estado");
  const estadoLabel = document.getElementById("lblEstado");

  if (estadoCheckbox.checked) {
    estadoLabel.textContent = "Activo";
  } else {
    estadoLabel.textContent = "No Activo";
  }
}

init();