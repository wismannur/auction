$(document).ready(function() {
    $('[data-name="row_id"]').hide();
    $('[data-name="auc_status"]').hide();
    $('[data-name="rate"]').hide();
    $('[data-name="auc_number"]').hide();
    $('[data-name="start_bid"]').hide();
    $('[data-name="close_bid"]').hide();

    function convertDate(date, month, year) {
        let numMonth = parseInt(month) -1;
        let d = date
        let m = monthNames[numMonth.toString()];
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
        // bid.eq(0).append('<br><span>'+ bid_time +'</span>')
    }

    function calculateRow(){
        let jumlahField = totalField('#tbl_v_tr_lelang_masterlist')
        console.log(jumlahField)
        var tbl_lelang_item = $('#tbl_v_tr_lelang_masterlist').find('tbody tr')
		for(let i = 0; i < jumlahField; i++){
            let checkDataIndex = tbl_lelang_item.eq(i).attr('data-rowindex')
            let auc_date = tbl_lelang_item.eq(i).find('[data-name="auc_date"]')
            let detail_v_tr_lelang_item = tbl_lelang_item.eq(i).find('[data-name="detail_v_tr_lelang_item"]')
            let start_bid_list = tbl_lelang_item.eq(i).find('[data-name="start_bid"]')
            let close_bid_list = tbl_lelang_item.eq(i).find('[data-name="close_bid"]')
            let cetak_katalog_list = tbl_lelang_item.eq(i).find('[data-name="btn_cetak_catalog"]')
            let row_id_list = tbl_lelang_item.eq(i).find('[data-name="row_id"]')
            
            if (checkDataIndex != "$rowindex$" ) {
                let row_id = row_id_list.find('span > span').text().slice(1)
                var btn_cetak_catalog = '<div class="btn-group" data-original-title="" title=""><a class="btn btn-primary btn_cetak_catalog btn-sm ewRowLink ewDetail" data-action="list" ><i class="fa fa-print"></i> Cetak Catalog</a></div>'
                cetak_katalog_list.css({'text-align': 'center'})
                cetak_katalog_list.find('span > span').remove()
                cetak_katalog_list.find('span').append(btn_cetak_catalog)
                cetak_katalog_list.find('span > div > a').attr("onclick", "window.open('reports/index.php?row_id="+ row_id +"',  '_blank');")
                cetak_katalog_list.find('span > .btn-group').eq(1).remove()
    
                startCloseBid(auc_date)

                let start_bid = start_bid_list.find('span > span').text().slice(1)
                let close_bid = close_bid_list.find('span > span').text().slice(1)
                let btn_catalog = detail_v_tr_lelang_item.find('span > div > a')
                let btn_catalog_href = btn_catalog.attr('href')

                btn_catalog.attr('href', btn_catalog_href + '&start_bid=' + start_bid + '&close_bid=' + close_bid)
                // console.log(btn_catalog_href, start_bid, close_bid)

			} else {
				console.log('NOT eksekusi = ' + checkDataIndex)
			}
        }
    };

    calculateRow()
})