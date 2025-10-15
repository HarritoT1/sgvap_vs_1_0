function asig_listener_change_vehicle_foto_prev() {
    document.getElementById('ruta_foto_1').addEventListener('change', function (event) {
        console.log("Evento change generado.");
        const file = event.target.files[0]; //
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('prev_foto').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        else {
            document.getElementById('prev_foto').src = "http://127.0.0.1:8000/img/sin_img.jpg";
        }
    });
}

function save_values_of_inputs_with_files () {
    const form = document.getElementById("actualizar");
    const inputs = form.querySelectorAll("input, textarea, select");

    valoresOriginales = {};
    inputs.forEach(input => {
        if (!(input.type === 'radio')) valoresOriginales[input.name] = input.value;
        if (input.type === 'radio' && input.checked === true) valoresOriginales[input.name] = input.value;
    });

    console.log(valoresOriginales);
}