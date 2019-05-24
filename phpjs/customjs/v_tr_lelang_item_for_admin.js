$(document).ready(function() {
    console.log('Admin terpanggil')

    $('[data-name="bid_val"]').remove();
    $('[data-name="btn_bid"]').remove();
    $('[data-name="check_list"]').remove();

    function populateLastData(ld) {
        let jumlahField = totalField('#tbl_v_tr_lelang_itemlist')
        var tbl_lelang_item = $('#tbl_v_tr_lelang_itemlist').find('tbody tr')
        for (let i = 0; i < jumlahField; i++) {
            let checkDataIndex = tbl_lelang_item.eq(i).attr('data-rowindex')
            let highBid_list = tbl_lelang_item.eq(i).find('[data-name="highest_bid"]')
            let auction_status_list = tbl_lelang_item.eq(i).find('[data-name="auction_status"]')
            let winner_bid_list = tbl_lelang_item.eq(i).find('[data-name="winner_id"]')
            let id_list = tbl_lelang_item.eq(i).find('[data-name="row_id"]')    
            if (checkDataIndex != "$rowindex$" ) {
                let get_id = id_list.find('span > span').text().slice(1)

                if (ld == '0 results') {
                    auction_status_list.find('span > span').addClass('auc_status_wd')
                    auction_status_list.find('span > span').html( 'WD' )
                } else {
                    for (let j = 0; j < ld.length; j++) {
                        if (get_id == ld[j].row_id) {
                            highBid_list.find('span > span').html( ld[j].highest_bid )
                            auction_status_list.find('span > span').html( ld[j].auction_status )
                            if (ld[j].auction_status == 'WD') {
                                auction_status_list.find('span > span').addClass('auc_status_wd')
                                auction_status_list.find('span > span').html( ld[j].auction_status )
                                console.log('wd')
                            } else if (ld[j].auction_status == 'Sold') {
                                auction_status_list.find('span > span').addClass('auc_status_sold')
                                auction_status_list.find('span > span').html( ld[j].auction_status )
                                console.log('sold')
                            } 
                            winner_bid_list.find('span > span').html( ld[j].CompanyName )
                        } else {
                            if (auction_status_list.find('span > span').hasClass('auc_status_sold') == false) {
                                auction_status_list.find('span > span').addClass('auc_status_wd')
                                auction_status_list.find('span > span').html( 'WD' )
                            }
                            console.log('wd luar')
                        }
                    }
                }
            }
        }
        $('body').addClass('loaded');
    }

    function getLastData() {
        $.ajax({
            type: 'GET',
            url : API + hostNow + 'run_sql.php',
            data : {
                as : 'json',
                sql : `SELECT row_id, highest_bid, sold_bid, auction_status, CompanyName 
                    FROM tr_lelang_item AS tr1, members AS tr2 
                    WHERE tr1.winner_id=tr2.user_id AND tr1.master_id= `+ master_id +`
                    ORDER BY row_id ;`
            },
            success: function(data) {
                console.log(data)
                if (data != '0 results') {
                    let result = JSON.parse(data)
                    console.log(' Success Get Last Data = ', result)
                    populateLastData(result)
                } else {
                    populateLastData(data)
                }
            }
        })
    }

    function setAuctionStatus() {
        $.ajax({
            type: 'POST',
            url : API + hostNow + 'run_sql_post.php',
            data : {
                as : 'json',
                sql : `UPDATE tr_lelang_item
                    SET auction_status = IF( sold_bid IS NOT NULL OR  sold_bid > 0, 'Sold','WD')
                    WHERE tr_lelang_item.master_id = `+ master_id +` ;`
            },
            success: function(data) {
                // console.log(' Success Set Auction Status = ', data)
                getLastData()
            }
        })
    }

    function setWinnerSoldBid() {
        $.ajax({
            type: 'POST',
            url : API + hostNow + 'run_sql_post.php',
            data : {
                as : 'json',
                sql : `UPDATE tr_lelang_item
                    LEFT JOIN tr_bid ON tr_lelang_item.row_id = tr_bid.master_id
                    SET
                    tr_lelang_item.highest_bid = (SELECT bid_value FROM tr_bid WHERE master_id = tr_lelang_item.row_id 
                    ORDER BY bid_value DESC ,bid_time,bid_time_ms  LIMIT 1),
                    tr_lelang_item.winner_id = (SELECT user_id FROM tr_bid WHERE master_id = tr_lelang_item.row_id 
                    ORDER BY bid_value DESC ,bid_time,bid_time_ms  LIMIT 1),
                    tr_lelang_item.sold_bid = (SELECT bid_value FROM tr_bid WHERE master_id = tr_lelang_item.row_id 
                    ORDER BY bid_value DESC ,bid_time,bid_time_ms  LIMIT 1)
                    WHERE tr_lelang_item.master_id = `+ master_id +` ;`
            },
            success: function(data) {
                // console.log(' Success Set Winner Bid = ', data)
                setAuctionStatus()
            }
        })
    }

    window.allCloseBid = function() {
        console.log('Admin - close bid berjalan')
        setWinnerSoldBid()
    }

});