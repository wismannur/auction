$(document).ready(function() {
    $('[data-field="x_gross"]').attr('readonly', 'readonly')
    var sack = $('[data-field="x_total_sack"]')
    var netto = $('[data-field="x_total_netto"]')
    var total_gross = $('[data-field="x_total_gross"]')

    $('[data-name="rate"]').hide()
    sack.css({'text-align': 'right'}).attr('readonly', 'readonly');
    netto.css({'text-align': 'right'}).attr('readonly', 'readonly');
    total_gross.css({'text-align': 'right'}).attr('readonly', 'readonly');

    function result_net_total() {
        let jumlahField = totalField('#tbl_tr_lelang_itemgrid')
        var count = 0
        var count_sack = 0
        for (let i = 0; i < jumlahField; i++) {
            let sack_list = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).find('[data-name="sack"]').find('span > input')
            let gross_list = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).find('[data-name="gross"]').find('span > input')
            let checkDataIndex = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).attr('data-rowindex')
            if (checkDataIndex != "$rowindex$") {
                val_gross = gross_list.val().split(',').join('')
                val_sack = sack_list.val().split(',').join('')
                if (val_gross != "") {
                    count = count + parseInt(val_gross) 
                }
                if (val_sack != "") {
                    count_sack = count_sack + parseInt(val_sack) 
                }
            }
        }
        // debugger

        $(sack).val(numberWithCommas(count_sack))
        $(total_gross).val(numberWithCommas(count))
    }

    function countTotal(i, sack_list, netto_list, gross_list) {

        let sack_val = sack_list.val().split(',').join('');
        let netto_val = netto_list.val().split(',').join('');

        
        let count = parseInt(sack_val) * parseInt(netto_val);

        console.log(sack_val, netto_val, count)
        let hasil = numberWithCommas(count)
        gross_list.val(hasil)
        result_net_total()
    }

    function countVolume(nameClass, eq, td) {
        let jumlahField = totalField('#tbl_tr_lelang_itemgrid')
        var count = 0
        let result = 0
        for (let i = 0; i < jumlahField; i++) {
            let checkDataIndex = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).attr('data-rowindex')
            if (checkDataIndex != "$rowindex$") {
                let item = $('#tbl_tr_lelang_itemgrid').find('tbody > tr').eq(i).find(td).find('span > input').val()
                if (item != "") {
                    let hasil = item.toString().split(',').join('')
                    result = result + parseInt(hasil) 
                    count+=1
                    // console.log(result)
                }
            }
        }

        let hasilAkhir = result / count;
        // console.log('this is hasil', hasilAkhir)
        $(nameClass).val(numberWithCommas(hasilAkhir))
    }

    function calculateRow(){
		let jumlahField = totalField('#tbl_tr_lelang_itemgrid')
		for(let i = 0; i < jumlahField; i++){
            let checkDataIndex = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).attr('data-rowindex')
            let sack_list = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).find('[data-name="sack"]').find('span > input')
            let netto_list = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).find('[data-name="netto"]').find('span > input')
            let gross_list = $('#tbl_tr_lelang_itemgrid').find('tbody tr').eq(i).find('[data-name="gross"]').find('span > input')
            if (checkDataIndex != "$rowindex$" ) {
                sack_list.css({'text-align': 'right'})
                netto_list.css({'text-align': 'right'})
                gross_list.css({'text-align': 'right'})

                sack_list.on('keyup', function() {
                    let this_value = $(this).val().split(',').join('')
                    let hasil = numberWithCommas(this_value)
                    $(this).val(hasil)
                    countTotal(i, sack_list, netto_list, gross_list)
                })

                netto_list.on('keyup', function() {
                    let this_value = $(this).val().split(',').join('')
                    let hasil = numberWithCommas(this_value)
                    $(this).val(hasil)
                    countTotal(i, sack_list, netto_list, gross_list)
                })

			} else {
				console.log('NOT eksekusi = ' + checkDataIndex)
            }
            // countVolume('[data-field="x_total_netto"]', i, '[data-name="netto"]')
            countTotal(i, sack_list, netto_list, gross_list)
        }
        result_net_total()
    };

    calculateRow()

    $('.ewAddBlankRow').on('click', function() {
        setTimeout(function() {
            calculateRow()
        }, 1000);
    });
});