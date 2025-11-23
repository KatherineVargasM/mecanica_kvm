function init() {
  $("#form_orden_trabajo").on("submit", (e) => GuardarEditarOrden(e));
  $("#btnAgregarItem").on("click", () => AgregarItemFila());
}

const rutaOrdenTrabajo = "../../controllers/orden_trabajo.controller.php?op=";
const rutaVehiculos    = "../../controllers/vehiculos.controllers.php?op=";
const rutaUsuarios     = "../../controllers/usuario.controllers.php?op=";
const rutaTipoServicio = "../../controllers/tipo_servicio.controllers.php?op=";

let listaTiposServicio = [];
let listaUsuarios      = [];
let listaVehiculos     = [];

$(document).ready(() => {
  CargarCombosBase();
  CargaLista();
});

var CargaLista = () => {
  $.get(rutaOrdenTrabajo + "todos", (response) => {
    try {
        let Lista_Ordenes = (typeof response === "string") ? JSON.parse(response) : response;
        let html = "";
        
        if(Lista_Ordenes.length === 0){
             html = `<tr><td colspan="6" class="text-center">No hay órdenes registradas</td></tr>`;
        } else {
            $.each(Lista_Ordenes, (i, ot) => {
              html += `<tr>
                  <td>${i + 1}</td>
                  <td>${ot.fecha}</td>
                  <td>${ot.vehiculo}</td>
                  <td>${ot.usuario}</td>
                  <td>${ot.cantidad_items}</td>
                  <td>
                    <button class="btn btn-primary btn-sm" onclick="editarOrden(${ot.idServicio})"><i class='bx bx-edit-alt'></i> Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="eliminarOrden(${ot.idServicio})"><i class='bx bx-trash'></i> Eliminar</button>
                  </td>
                </tr>`;
            });
        }
        $("#ListaOrdenesTrabajo").html(html);
    } catch (error) {
        console.error("Error al leer datos:", error);
    }
  });
};

var nuevaOrden = () => {
    $("#tituloModal").html("Nueva Orden");
    $("#form_orden_trabajo")[0].reset();
    $("#idServicio").val("");
    $("#tbodyItemsOrden").empty();
    AgregarItemFila(); 
    $("#ModalOrdenTrabajo").modal("show");
};

function editarOrden(idServicio) {
  $("#tituloModal").html("Editar Orden");
  $.post(rutaOrdenTrabajo + "unoServicio", { idServicio: idServicio }, (resp) => {
    let data = (typeof resp === "string") ? JSON.parse(resp) : resp;
    let srv = data.servicio;
    
    $("#idServicio").val(srv.id);
    $("#id_vehiculo").val(srv.id_vehiculo);
    $("#id_usuario_servicio").val(srv.id_usuario);
    $("#fecha_servicio").val(srv.fecha_servicio);

    $("#tbodyItemsOrden").empty();
    if(data.items && data.items.length > 0) {
        data.items.forEach(it => AgregarItemFila(it));
    } else { 
        AgregarItemFila(); 
    }

    $("#ModalOrdenTrabajo").modal("show");
  });
}

function CargarCombosBase() {
  $.get(rutaUsuarios + "todos", (d) => { 
      let data = (typeof d === "string") ? JSON.parse(d) : d; 
      listaUsuarios = data;
      
      let html = '<option value="">Seleccione responsable...</option>';
      
      data.forEach(u => {

          if(u.IdRol == 1 || u.IdRol == 2 || u.nombre == 'Administrador' || u.nombre == 'Secretaria'){
              html += `<option value="${u.id}">${u.nombre_usuario} (${u.nombre})</option>`;
          }
      });
      
      $("#id_usuario_servicio").html(html);
  });

  $.get(rutaVehiculos + "todos", (d) => { 
      let data = (typeof d === "string") ? JSON.parse(d) : d; 
      listaVehiculos = data;
      let html = '<option value="">Seleccione vehículo...</option>';
      data.forEach(v => html += `<option value="${v.id}">${v.marca} ${v.modelo} (${v.anio})</option>`);
      $("#id_vehiculo").html(html);
  });

  $.get(rutaTipoServicio + "todos", (d) => { 
      listaTiposServicio = (typeof d === "string") ? JSON.parse(d) : d; 
  });
}

var AgregarItemFila = async (item = null) => {
  let opTipo = '<option value="">Seleccione servicio...</option>';
  listaTiposServicio.forEach(t => {
      let selected = (item && item.tipo_servicio_id == t.id) ? "selected" : "";
      opTipo += `<option value="${t.id}" ${selected}>${t.detalle} - $${t.valor}</option>`;
  });

  let opUsu = '<option value="">Seleccione técnico...</option>';
  listaUsuarios.forEach(u => {
      if(u.IdRol == 3 || u.IdRol == 4 || u.nombre == 'Mecanico' || u.nombre == 'Oficial'){
          let selected = (item && item.usuario_id == u.id) ? "selected" : "";
          opUsu += `<option value="${u.id}" ${selected}>${u.nombre_usuario}</option>`;
      }
  });

  let desc = item ? item.descripcion : "";
  let fecha = item ? item.fecha : $("#fecha_servicio").val() || new Date().toISOString().split('T')[0];

  let fila = `<tr>
      <td><input type="text" class="form-control desc-item" value="${desc}" required placeholder="Detalle del trabajo"></td>
      <td><select class="form-control tipo-item" required>${opTipo}</select></td>
      <td><select class="form-control usu-item" required>${opUsu}</select></td> <td><input type="date" class="form-control fec-item" value="${fecha}" required></td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('tr').remove()"><i class='bx bx-trash'></i></button></td>
    </tr>`;
    
  $("#tbodyItemsOrden").append(fila);
};

function GuardarEditarOrden(e) {
  e.preventDefault();
  let items = [];
  $("#tbodyItemsOrden tr").each(function() {
      let desc = $(this).find(".desc-item").val();
      let tipo = $(this).find(".tipo-item").val();
      let usu = $(this).find(".usu-item").val();
      let fec = $(this).find(".fec-item").val();
      
      if(desc && tipo && usu){
          items.push({
              descripcion: desc,
              tipo_servicio_id: tipo,
              usuario_id: usu,
              fecha: fec
          });
      }
  });

  if(items.length === 0) { alert("Agregue un ítem válido"); return; }

  let datos = new FormData($("#form_orden_trabajo")[0]);
  datos.append("items", JSON.stringify(items));
  
  let idServ = $("#idServicio").val();
  let accion = (idServ && idServ > 0) ? "actualizar" : "insertar";
  if(accion === "actualizar") datos.append("id", idServ);

  $.ajax({
    url: rutaOrdenTrabajo + accion,
    type: "post",
    data: datos,
    processData: false,
    contentType: false,
    success: (resp) => {
        let r = (typeof resp === "string") ? JSON.parse(resp) : resp;
        
        if(r.status === "ok") {
            alert("¡Guardado correctamente!");
            CargaLista();
            LimpiarFormularioOrden();
        } else { 
            alert("Error al guardar: " + (r.mensaje || "Error desconocido")); 
        }
    },
    error: (err) => {
        console.error(err);
        alert("Error de servidor");
    }
  });
}

var eliminarOrden = (id) => {
    if(confirm("¿Eliminar orden completa?")) {
        $.post(rutaOrdenTrabajo + "eliminar", { idServicio: id }, (r) => {
            let resp = (typeof r === "string") ? JSON.parse(r) : r;
            if(resp.status === "ok") { alert("Eliminado"); CargaLista(); }
            else { alert("Error al eliminar: " + resp.mensaje); }
        });
    }
};

function LimpiarFormularioOrden() {
  $("#ModalOrdenTrabajo").modal("hide");
}

init();