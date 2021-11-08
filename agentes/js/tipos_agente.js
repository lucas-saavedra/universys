const d = document

d.addEventListener('change', e => {
    if (!e.target.matches('.table-agente input[type="checkbox"]')) return

    const $input = e.target.closest('tr').querySelector('td input')

    if (e.target.checked) {
        $input.removeAttribute('disabled')
        $input.setAttribute('required', true)
    }
    else {
        $input.removeAttribute('required')
        $input.setAttribute('disabled', true)
    }
})