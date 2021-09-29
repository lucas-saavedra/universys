document.addEventListener('click', e => {
    const $btn = e.target.closest('.btn-edit')
    if (!$btn) return;

    const $modal = document.querySelector('#modif-doc-modal')

    const inputID = $modal.querySelector('input[name="id"]')
    const inputFecha = $modal.querySelector('input[name="fecha_recepcion"]')
    const inputDesc = $modal.querySelector('textarea[name="descripcion"]')
    const inputExpdte = $modal.querySelector('input[name="expdte_id"]')


    const strDate = $btn.closest('tr').querySelector('.fecha-rec').textContent + ' UTC'
    const fecha = new Date(strDate)

    inputID.value = $btn.dataset.id
    inputFecha.value = fecha.toISOString().slice(0, 16)
    inputDesc.textContent = $btn.closest('tr').querySelector('.desc').textContent
    inputExpdte.value = $btn.dataset.expdteid

    $('#modif-doc-modal').modal('show');
})