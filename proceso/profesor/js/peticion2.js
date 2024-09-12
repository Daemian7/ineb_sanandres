document.addEventListener('DOMContentLoaded', () => {
    const cbxcurso = document.getElementById('curso');
    const cbxalumno = document.getElementById('alumno');
    const cbxact = document.getElementById('act');

    cbxcurso.addEventListener('change', () => {
        getStudents();
    });

    cbxact.addEventListener('change', () => {
        getStudents();
    });

    function fetchAndSetData(url, formData, targetElement) {
        return fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Selecciona Alumno</option>';
            data.forEach(item => {
                options += `<option value="${item.id_alumno}">${item.nombre_alumno}</option>`;
            });
            targetElement.innerHTML = options;
        })
        .catch(err => console.log(err));
    }

    function getStudents() {
        let curso = cbxcurso.value;
        let act = cbxact.value;
        let url = 'include/getalumno.php'; // Ruta al archivo PHP que devuelve los alumnos
        let formData = new FormData();
        formData.append('curso', curso);
        formData.append('act', act);

        fetchAndSetData(url, formData, cbxalumno);
    }
});
