$(document).ready(function() {
    $('#r_master_id').hide()
    var row_id = getDataUrl('row_id')
    $('[data-field="x_master_id"]').val(row_id)
});