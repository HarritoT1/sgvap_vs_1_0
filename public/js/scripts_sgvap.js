function asig_listeners_of_submit_forms() {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
}

function enable_inpus_edit_mode() {
    document.querySelectorAll('.form-control').forEach( input => {
        input.removeAttribute('disabled');
    });

    document.getElementById('save').removeAttribute('disabled');
    document.getElementById('edit').setAttribute('disabled', 'true');
}

function ask_before_submit() {
    if (confirm("¿Está seguro de guardar los cambios del proyecto?")) {
        document.getElementById('actualizar_proyecto').requestSubmit();
    }
    else {
        window.location.reload();
    }
}
