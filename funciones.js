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

