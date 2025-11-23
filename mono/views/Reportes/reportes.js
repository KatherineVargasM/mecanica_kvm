function init() {

}

const ruta = "../../controllers/reportes.controllers.php?op=";

$(document).ready(() => {
    cargarReporte();
});

var cargarReporte = () => {
    var html = "";
    $.get(ruta + "top_clientes", (response) => {
        try {
            let datos = (typeof response === "string") ? JSON.parse(response) : response;
            
            if (datos.length > 0) {
                $.each(datos, (index, item) => {
                    html += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.nombres}</td>
                        <td>${item.apellidos}</td>
                        <td>${item.telefono || '-'}</td>
                        <td>${item.correo_electronico || '-'}</td>
                        <td class="text-center">${item.total_visitas}</td>
                    </tr>`;
                });
            } else {
                html = `<tr>
                            <td colspan="6" class="text-center">No hay datos registrados</td>
                        </tr>`;
            }
            
            $("#ListaReporte").html(html);
            
        } catch (error) {
            console.error("Error al cargar reporte:", error);
        }
    });
};

init();