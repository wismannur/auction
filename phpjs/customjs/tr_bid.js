$(document).ready(function() {
    // $('#r_master_id').hide()
    var row_id = getDataUrl('row_id')
    $('[data-field="x_master_id"]').val(row_id)

    $('#el_tr_bid_bid_winner').find('input').addClass('form-checkbox')

    $('#btnAction').on('click', function() {
        $.ajax({
            type : 'GET',
            url : API + hostNow + 'insertBid.php',
            data : {
            },
            success: function(msg) {
                console.log(msg)
            }
        })
    })
});