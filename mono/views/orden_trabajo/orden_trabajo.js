function init() {

  $("#form_orden_trabajo").on("submit", (e) => {
    GuardarEditarOrden(e);
  });


  $("#btnAgregarItem").on("click", () => {
    AgregarItemFila();
  });
}

const rutaOrdenTrabajo = "../../controllers/orden_trabajo.controller.php?op=";
const rutaVehiculos    = "../../controllers/vehiculos.controllers.php?op=";
const rutaUsuarios     = "../../controllers/usuario.controllers.php?op=";
const rutaTipoServicio = "../../controllers/tipo_servicio.controllers.php?op=";

let listaTiposServicio = [];
let listaUsuarios      = [];
let listaVehiculos     = [];

$().ready(() => {
  CargarCombosBase();
  CargaLista();
  AgregarItemFila(); 
});


var CargaLista = () => {
  let html = "";
  $.get(rutaOrdenTrabajo + "todos", (Lista_Ordenes) => {
    if (!Lista_Ordenes) return;

    Lista_Ordenes = JSON.parse(Lista_Ordenes);

    $.each(Lista_Ordenes, (i, ot) => {
      html += `
        <tr>
          <td>${i + 1}</td>
          <td>${ot.fecha}</td>
          <td>${ot.vehiculo}</td>
          <td>${ot.usuario}</td>
          <td>${ot.cantidad_items}</td>
          <td>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                    data-bs-target="#ModalOrdenTrabajo"
                    onclick="editarOrden(${ot.idServicio})">
              Editar
            </button>
            <button class="btn btn-danger btn-sm" onclick="eliminarOrden(${ot.idServicio})">
              Eliminar
            </button>
          </td>
        </tr>
      `;
    });

    $("#ListaOrdenesTrabajo").html(html);
  });
};


function CargarCombosBase() {
  CargarUsuarios();
  CargarVehiculos();
  CargarTiposServicio();
}


function CargarUsuarios() {
  $.get(rutaUsuarios + "todos", (data) => {
    if (!data) return;
    data = JSON.parse(data);
    listaUsuarios = data;

    let html = `<option value="">Seleccione un usuario</option>`;
    $.each(listaUsuarios, (i, u) => {
      const nombre = u.nombre_usuario || u.nombres || ("Usuario " + u.id);
      html += `<option value="${u.id}">${nombre}</option>`;
    });

    $("#id_usuario_servicio").html(html);
  });
}


function CargarVehiculos() {
  $.get(rutaVehiculos + "todos", (data) => {
    if (!data) return;
    listaVehiculos = JSON.parse(data);

    let html = `<option value="">Seleccione un vehículo</option>`;
    $.each(listaVehiculos, (i, v) => {
      const placa = v.placa || v.descripcion || ("Vehículo " + v.id);
      html += `<option value="${v.id}">${placa}</option>`;
    });

    $("#id_vehiculo").html(html);

    if (listaVehiculos.some(x => String(x.id) === "1")) {
      $("#id_vehiculo").val("1");
    }
  });
}


function CargarTiposServicio() {
  $.get(rutaTipoServicio + "todos", (data) => {
    if (!data) return;
    listaTiposServicio = JSON.parse(data);
  });
}


var AgregarItemFila = async (item = null) => {
  let opcionesTipo = `<option value="">Seleccione tipo de servicio</option>`;
  await $.each(listaTiposServicio, (i, t) => {
    const label = t.detalle || ("Tipo " + t.id);
    const selected = item && item.TipoServicio_Id == t.id ? "selected" : "";
    opcionesTipo += `<option value="${t.id}" ${selected}>${label}</option>`;
  });

  let opcionesUsuarios = `<option value="">Seleccione usuario</option>`;
  $.each(listaUsuarios, (i, u) => {
    const label = u.nombre_usuario || u.nombres || ("Usuario " + u.id);
    const selected = item && item.Usuario_Id == u.id ? "selected" : "";
    opcionesUsuarios += `<option value="${u.id}" ${selected}>${label}</option>`;
  });

  let descripcion = item ? item.Descripcion : "";
  let fecha = item ? item.fecha : $("#fecha_servicio").val() || "";

  const fila = `
    <tr>
      <td>
        <input type="text" class="form-control descripcion-item"
               value="${descripcion}" placeholder="Descripción">
      </td>
      <td>
        <select class="form-control tipo-servicio-item">${opcionesTipo}</select>
      </td>
      <td>
        <select class="form-control usuario-item">${opcionesUsuarios}</select>
      </td>
      <td>
        <input type="date" class="form-control fecha-item" value="${fecha}">
      </td>
      <td>
        <button type="button" class="btn btn-danger btn-sm"
                onclick="EliminarFilaItem(this)">X</button>
      </td>
    </tr>
  `;

  $("#tbodyItemsOrden").append(fila);
};

var EliminarFilaItem = (btn) => {
  $(btn).closest("tr").remove();
};


function GuardarEditarOrden(e) {
  e.preventDefault();

  const Form = new FormData($("#form_orden_trabajo")[0]);

  let idServicio = $("#idServicio").val() || 0;
  let accion     = idServicio > 0 ? "actualizar" : "insertar";


  const items = [];
  $("#tbodyItemsOrden tr").each(function () {
    const descripcion = $(this).find(".descripcion-item").val();
    const tipo        = $(this).find(".tipo-servicio-item").val();
    const usuario     = $(this).find(".usuario-item").val();
    const fecha       = $(this).find(".fecha-item").val();

    if (descripcion && tipo) {
      items.push({
        descripcion: descripcion,
        tipo_servicio_id: tipo,
        usuario_id: usuario,
        fecha: fecha
      });
    }
  });

  if (items.length === 0) {
    alert("Debe ingresar al menos un ítem.");
    return;
  }

  Form.append("items", JSON.stringify(items));
  
  Form.forEach((value, key) => {
    console.log(key + ': ' + value);
  });

  $.ajax({
    url: rutaOrdenTrabajo + accion,
    type: "post",
    data: Form,
    contentType: false,
    processData: false,
    success: (resp) => {
      let r;
      try { r = JSON.parse(resp); } catch { r = resp; }

      if (r.ok || r === "ok") {
        alert(r.mensaje || "Orden guardada con éxito");
        CargaLista();
        LimpiarFormularioOrden();
      } else {
        alert(r.mensaje || "Error en el guardado");
      }
    }
  });
}


function editarOrden(idServicio) {
  $.post(rutaOrdenTrabajo + "unoServicio", { idServicio: idServicio }, (resp) => {
    let data = JSON.parse(resp);

    const srv  = data.servicio;
    const items = data.items;

    $("#idServicio").val(srv.id);
    $("#id_vehiculo").val(srv.id_vehiculo);
    $("#id_usuario_servicio").val(srv.id_usuario);
    $("#fecha_servicio").val(srv.fecha_servicio);

    $("#tbodyItemsOrden").empty();
    items.forEach(it => AgregarItemFila(it));

    $("#ModalOrdenTrabajo").modal("show");
  });
}


var eliminarOrden = (idServicio) => {
  if (!confirm("¿Desea eliminar esta orden?")) return;

  $.post(rutaOrdenTrabajo + "eliminar", { idServicio }, (resp) => {
    let r;
    try { r = JSON.parse(resp); } catch { r = resp; }

    if (r.ok || r === "ok") {
      alert(r.mensaje || "Eliminado con éxito");
      CargaLista();
    } else {
      alert(r.mensaje || "Error al eliminar");
    }
  });
};


function LimpiarFormularioOrden() {
  $("#idServicio").val("");
  $("#id_vehiculo").val("");
  $("#id_usuario_servicio").val("");
  $("#fecha_servicio").val("");

  $("#tbodyItemsOrden").empty();
  AgregarItemFila();

  $("#ModalOrdenTrabajo").modal("hide");
}

init();
