$(document).ready(function() {
    $('[data-name="row_id"]').hide()
    $('[data-name="btn_pay"]').css({'width': '110px'})

    function getDetailPayment(id, pay_list) {
        var btn_pay = pay_list.find('span > div > a')
        $.ajax({
            type : 'GET',
            url : API + hostNow + 'run_sql.php',
            data : {
                as : 'json',
                sql : 'SELECT row_id FROM tr_payment WHERE user_id='+ userID +' AND master_id='+ id +''
            },
            success: function(data) {
                // console.log(data)
                if (data != "0 results") {
                    let result = JSON.parse(data)
                    // console.log(result[0].row_id)
                    btn_pay.removeClass('btn-default')
                    btn_pay.addClass('btn-success')
                    btn_pay.attr('href', 'tr_paymentview.php?showdetail=&row_id='+ result[0].row_id +'')
                    btn_pay.html('Detail Payment')
                } else {
                    btn_pay.attr('href', 'tr_paymentadd.php?row_id='+ id +'')
                }
            }
        })
    }

    function calculateRow(){
		let jumlahField = totalField('#tbl_v_proformalist')
		for(let i = 0; i < jumlahField; i++){
            let checkDataIndex = $('#tbl_v_proformalist').find('tbody tr').eq(i).attr('data-rowindex')
            let pay_list = $('#tbl_v_proformalist').find('tbody tr').eq(i).find('[data-name="btn_pay"]')
            let id_list = $('#tbl_v_proformalist').find('tbody tr').eq(i).find('[data-name="row_id"]')
            if (checkDataIndex != "$rowindex$" ) {
                var id_proforma = id_list.find('span > span').text().slice(1)
                var btn_payment = '<div class="btn-group" data-original-title="" title=""><a class="btn btn-default btn_pay btn-sm ewRowLink ewDetail" data-action="list" >Payment&nbsp;</a></div>'
                pay_list.css({'text-align': 'center'})
                pay_list.find('span > span').remove()
                pay_list.find('span').append(btn_payment)
			} else {
				// console.log('NOT eksekusi = ' + checkDataIndex)
			}
		}
    };

    function populateTable() {
        let jumlahField = totalField('#tbl_v_proformalist')
		for(let i = 0; i < jumlahField; i++){
            let checkDataIndex = $('#tbl_v_proformalist').find('tbody tr').eq(i).attr('data-rowindex')
            let pay_list = $('#tbl_v_proformalist').find('tbody tr').eq(i).find('[data-name="btn_pay"]')
            let id_list = $('#tbl_v_proformalist').find('tbody tr').eq(i).find('[data-name="row_id"]')
            if (checkDataIndex != "$rowindex$" ) {
                var id_proforma = id_list.find('span > span').text().slice(1)
                getDetailPayment(id_proforma, pay_list)
			} else {
				// console.log('NOT eksekusi = ' + checkDataIndex)
			}
		}
    }

    $('.btn_pay').on('click', function(event) {
    })

    calculateRow()
    setTimeout(function() {
        populateTable()
    }, 3000);
})