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

    $infoDiv.innerHTML = `
        <div class="col alert alert-${json.msg_type}">
            ${json.msg}
        </div>
    `


})