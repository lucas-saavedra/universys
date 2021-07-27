const $check_doc = document.getElementById('check-docente')
const $check_no_doc = document.getElementById('check-no-docente')

const filtro_agentes = agentes => {

    document.addEventListener('change', e => {

        if (!e.target.matches('.filtro-agente input[type="checkbox"]')) return;


        const result = agentes.filter(a => {
            if ($check_doc.checked && $check_no_doc.checked)
                return a.docente_id !== null && a.no_docente_id !== null;

            if ($check_doc.checked)
                return a.docente_id !== null;
            if ($check_no_doc.checked)
                return a.no_docente_id !== null;

            return false;
        })

        const $select = document.querySelector('select[name="expdte[persona_id]"]')

        const $frag = document.createDocumentFragment()

        const options = result.map(r => {
            const $option = document.createElement('option')
            $option.value = r.id
            $option.text = r.nombre

            return $option
        })

        options.unshift(document.createElement('option'))

        options.forEach(o => $frag.appendChild(o))

        $select.textContent = ''
        $select.appendChild($frag)

    })
}

const filtro_codigos = codigos => {
    document.addEventListener('change', e => {

        if (!e.target.matches('.filtro-agente input[type="checkbox"]')) return;

        const $select = document.querySelector('select[name="expdte[codigo_id]"]')

        const result = codigos.filter(c => {
            if ($check_doc.checked && $check_no_doc.checked) return c.es_docente && c.es_no_docente;

            if ($check_doc.checked) return c.es_docente;

            if ($check_no_doc.checked) return c.es_no_docente;

            return false;
        })

        $frag = document.createDocumentFragment()

        const options = result.map(r => {
            const $option = document.createElement('option')
            $option.value = r.id
            $option.text = `${r.referencia} - ${r.nombre}`

            return $option
        })

        options.unshift(document.createElement('option'))
        options.forEach(o => $frag.appendChild(o))

        $select.textContent = ''
        $select.appendChild($frag)

    })
}