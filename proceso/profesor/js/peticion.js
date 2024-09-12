document.addEventListener('DOMContentLoaded', () => {
    const cbxcurso = document.getElementById('curso');
    const cbxact = document.getElementById('act');

    cbxcurso.addEventListener('change', getact);

    function fetchAndSetData(url, formData, targetElement) {
        return fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Selecciona Actividad</option>';
            data.forEach(item => {
                options += `<option value="${item.id_actividad}">${item.nombre_actividad}</option>`;
            });
            targetElement.innerHTML = options;
        })
        .catch(err => console.log(err));
    }

    function getact() {
        let curso = cbxcurso.value;
        let url = 'include/getact.php';
        let formData = new FormData();
        formData.append('curso', curso);

        fetchAndSetData(url, formData, cbxact);
    }
});
