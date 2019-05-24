window.lastData = []
$(document).ready(function() {
    $('[data-name="row_id"]').hide()

    function realtimeLelang() {
        lastData = []
        let jumlahField = totalField('#tbl_tr_lelang_itemlist')
		for(var i = 0; i < jumlahField; i++){
            let checkDataIndex = $('#tbl_tr_lelang_itemlist').find('tbody tr').eq(i).attr('data-rowindex')
            let fieldRow = $('#tbl_tr_lelang_itemlist').find('tbody tr').eq(i)
            var toSpan = '> div > span > span'            
			if (checkDataIndex != "$rowindex$" ) {
                fieldRow.find('[data-name="row_id"] '+ toSpan +'').html(dataLelang[i].row_id)
                fieldRow.find('[data-name="lot_number"] '+ toSpan +'').html(dataLelang[i].lot_number)
                fieldRow.find('[data-name="chop"] '+ toSpan +'').html(dataLelang[i].chop)
                fieldRow.find('[data-name="estate"] '+ toSpan +'').html(dataLelang[i].estate)
                fieldRow.find('[data-name="grade"] '+ toSpan +'').html(dataLelang[i].grade)
                fieldRow.find('[data-name="sack"] '+ toSpan +'').html(dataLelang[i].sack)
                fieldRow.find('[data-name="netto"] '+ toSpan +'').html(dataLelang[i].netto)
                fieldRow.find('[data-name="gross"] '+ toSpan +'').html(dataLelang[i].gross)
                fieldRow.find('[data-name="currency"] '+ toSpan +'').html(dataLelang[i].currency)
                fieldRow.find('[data-name="rate"] '+ toSpan +'').html(dataLelang[i].rate)
			} else {
				console.log('NOT eksekusi ke = ' + i)
			}
		}
    }

    // setInterval(function() {
    //     realtimeLelang()
    // }, 3000);
})