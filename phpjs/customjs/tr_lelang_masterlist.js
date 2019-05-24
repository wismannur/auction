$(document).ready(function() {
    // $('[data-name="detail_tr_lelang_item"]').hide()

    function convertDate(date, month, year) {
        if (month.slice(0,1) == 0) {
            month = month.slice(1) - 1
        } else if (month.slice(0,1) == 1) {
            month = month - 1
        }

        let d = date
        let m = monthNames[month];
        let y = year
        var hasil = d + " - " + m + " - " + y;
        return hasil;
    }

    function startCloseBid(nameClass) {
        var bid = nameClass.find('span')
        var bid_text = bid.find('span').text().split(' ')
        var bid_date = bid_text[0].split('/')
        var bid_time = bid_text[1]
        var get_date_bid = convertDate(bid_date[0], bid_date[1], bid_date[2])
        bid.find('span').html(get_date_bid)
        bid.eq(0).append('<br><span>'+ bid_time +'</span>')
    }

    function calculateRow(){
        let jumlahField = totalField('#tbl_tr_lelang_masterlist')
        var tbl_list = $('#tbl_tr_lelang_masterlist').find('tbody tr')
		for(let i = 0; i < jumlahField; i++){
            let checkDataIndex = tbl_list.eq(i).attr('data-rowindex')
            let start_bid_list = tbl_list.eq(i).find('[data-name="start_bid"]')
            let close_bid_list = tbl_list.eq(i).find('[data-name="close_bid"]')
            let catalog_list = tbl_list.eq(i).find('[data-name="detail_tr_lelang_item"]')
            // let sack_list = $('#tbl_tr_lelang_masterlist').find('tbody tr').eq(i).find('td').eq(9)
            // let netto_list = $('#tbl_tr_lelang_masterlist').find('tbody tr').eq(i).find('td').eq(10)
            // let gross_list = $('#tbl_tr_lelang_masterlist').find('tbody tr').eq(i).find('td').eq(11)
            // let id_list = $('#tbl_tr_lelang_masterlist').find('tbody tr').eq(i).find('td').eq(1)
            if (checkDataIndex != "$rowindex$" ) {
                // let a_href_catalog = catalog_list.find('a').removeAttr('href')

                startCloseBid(start_bid_list)
                startCloseBid(close_bid_list)
			} else {
				console.log('NOT eksekusi = ' + checkDataIndex)
			}
		}
    };

    calculateRow()
})