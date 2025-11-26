function loadProyectos() {
    $.ajax({
        type: "GET",
        url: "loadProyectos.php",
        success: function(response) {
            $(".proyectos_img").html(response);
        }
    });
}

$(document).ready(function() {
    loadProyectos();
});


function insertProyectos() {
    // Obtiene el formulario
    let form = document.getElementById("formInsertProyectos");

    // Crea un FormData con TODO (inputs + archivo)
    let formData = new FormData(form);

    let mensajeInsert = document.getElementById("mensajeInsert");

    $.ajax({
        type: "POST",
        url: "insertProyectos.php",
        data: formData,
        processData: false,  // IMPORTANTE: no convertir a querystring
        contentType: false,  // IMPORTANTE: dejar que el navegador ponga el boundary
        success: function(response) {

            mensajeInsert.style.display = "block";

            if (response.trim() === "ok") {
                mensajeInsert.className = "mensaje exitoso";
                mensajeInsert.textContent = "Proyecto agregado correctamente.";
                form.reset(); // Limpia el formulario
                loadProyectos();
            } else {
                mensajeInsert.className = "mensaje error";
                mensajeInsert.textContent = response;
            }
        }
    });
}

function deleteProyectos() {
    let id = $("#idEliminar").val();

    if (id === "") {
        $("#mensajeDelete").text("Ingrese un ID válido").css("color", "red");
        return;
    }

    $.ajax({
        type: "POST",
        url: "deleteProyectos.php",
        data: { id: id },
        success: function(response) {
            console.log("Respuesta delete:", response);

            if (response.trim() === "ok") {
                $("#mensajeDelete")
                    .text("Proyecto eliminado correctamente")
                    .css("color", "green");

                loadProyectos(); // Recargar lista
            } else {
                $("#mensajeDelete")
                    .text(response)
                    .css("color", "red");
            }
        },
        error: function() {
            $("#mensajeDelete")
                .text("Error al procesar la solicitud")
                .css("color", "red");
        }
    });
}

function updateProyectos() {

    let form = document.getElementById("formUpdateProyectos");
    let formData = new FormData(form);
    let mensajeUpdate = document.getElementById("mensajeUpdate");

    $.ajax({
        url: "updateProyectos.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

            mensajeUpdate.style.display = "block";

            if (response.trim() === "ok") {
                mensajeUpdate.className = "mensaje exitoso";
                mensajeUpdate.textContent = "Proyecto actualizado correctamente.";
                form.reset();
                loadProyectos();
            } else {
                mensajeUpdate.className = "mensaje error";
                mensajeUpdate.textContent = response;
            }
        }
    });
}


