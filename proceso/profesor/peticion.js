$(document).ready(function() {
    $('#curso').on('change', function() {
        var cursoId = $(this).val();

        if (cursoId) {
            $.ajax({
                url: 'get_data.php',
                type: 'POST',
                data: { curso_id: cursoId },
                dataType: 'json',
                success: function(response) {
                    // Limpiar selects de actividades y alumnos
                    $('#act').empty().append('<option value="">Selecciona Actividad</option>');
                    $('#alumno').empty().append('<option value="">Selecciona Alumno</option>');

                    // Rellenar el select de actividades
                    $.each(response.actividades, function(index, actividad) {
                        $('#act').append('<option value="' + actividad.id_actividad + '">' + actividad.nombre_act + '</option>');
                    });

                    // Rellenar el select de alumnos
                    $.each(response.alumnos, function(index, alumno) {
                        $('#alumno').append('<option value="' + alumno.id_alumno + '">' + alumno.nombre + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " " + error);
                    alert('Hubo un problema al obtener los datos.');
                }
            });
        } else {
            // Si no hay curso seleccionado, limpiar los selects
            $('#act').empty().append('<option value="">Selecciona Actividad</option>');
            $('#alumno').empty().append('<option value="">Selecciona Alumno</option>');
        }
    });
});
