const d = document;

d.addEventListener('change', async e => {

    const input_names = ['fecha_inicio', 'fecha_fin', 'codigo_id', 'persona_id']

    if (!input_names.some(name => e.target.matches(`[name="expdte[${name}]"`))) return
    const $form = d.querySelector('form')
    const data = new FormData($form)

    const response = await fetch('verificar-cupo.php', {
        method: 'POST',
        body: data,
    })

    const $infoDiv = d.getElementById('info-cupo')
    const json = await response.json()

    const $checkCupo = d.getElementById('check-cupo')
    const $inputCupo = d.querySelector('[name="expdte[cupo_superado]"]')

    if (json.cupo_superado) {
        $checkCupo.checked = true
        $inputCupo.value = 1
    }
    else {
        $checkCupo.checked = false
        $inputCupo.value = 0
    }

    $infoDiv.innerHTML = `
        <div class="col alert alert-${json.msg_type}">
            ${json.msg}
        </div>
    `


})