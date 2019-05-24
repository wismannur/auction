$(document).ready(function() {
    // untuk menambahkan script hitung mundur yg di ambil dari server
    $('section.content').append("<script type='text/javascript' src='"+ hostNow +"phpjs/customjs/count_down_auction.js'></script>")

    // for show the loading
    // $('body').addClass('loaded');
    $('body').removeClass('loaded');

    $('[data-name="row_id"]').hide()
    $('[data-phrase="ButtonExport"]').closest('button').hide()
    $('[data-name="bid_val"]').css({'width' : '150px'})
    $('[data-name="bid_step"]').hide()
    $('[data-name="open_bid"]').hide()

    window.auc_status = $('#auc_status').find('span > span').text().slice(1);
    window.countDown_first = 1;
    window.difference_days_start_bid = 0;
    window.row_id_lelang_item = $('#row_id_lelang_item').find('span > span').text().slice(1);
    window.master_id = getDataUrl('fk_row_id');

    let messangeConnect = `<div class="col-sm-5 field-br"> 
            <div class="row"> 
                <div class="col-sm-5" style="padding: 0%"> Status Connect MQTT Server :</div>
                <div class="col-sm-6 status_mqtt" style="padding: 0%; margin-left: -20px;"> </div>
            </div>
        </div>`
    $('section.content').prepend(messangeConnect)
    $('.status_mqtt').html('DISCONNECT').css({'color': 'red', 'font-weight': 'bold'})
    $('.status_mqtt').append(' <i class="fa fa-times"></i>')

    function startCloseBid(nameClass, when) {
        var bid = $(nameClass).find('span')
        var bid_text = bid.find('span').text().split(' ')
        var bid_date = bid_text[0].split('/')
        var bid_time = bid_text[1]
        var get_date_bid = convertDate(bid_date[1], bid_date[0].slice(1), bid_date[2])
        bid.find('span').html(get_date_bid)
        bid.eq(0).append('<br><span>'+ bid_time +'</span>')

        if (when == 'start') {
            window.start_bid = bid_date;
        } else if (when == 'close') {
            window.close_bid = bid_date;
        }

    }

    function daysDifference(d0, d1) {
        var diff = new Date(+d1).setHours(12) - new Date(+d0).setHours(12);
        return Math.round(diff/8.64e7);
    }

    function differenceDays(yy, mm, dd) {
        n =  new Date();
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();

        let hasil = daysDifference(new Date(y,m,d), new Date(yy, mm, dd))
                
        return hasil;
    };

    function getLastBid(id, lastBid_list) {
        if (auc_status == '0' || auc_status == '1') {
            $.ajax({
                type : 'GET',
                url : API + hostNow + 'run_sql.php',
                data : {
                    as : 'json',
                    sql : 'SELECT bid_value FROM tr_bid WHERE master_id = '+ id +' AND user_id= '+ userID +'  ORDER BY row_id DESC LIMIT 1'
                },
                success: function(data) {
                    if (data != "0 results") {
                        var hasil = JSON.parse(data)
                        lastBid_list.find('span > span').html( numberWithCommas(hasil[0].bid_value) )
                    } else {
                        lastBid_list.find('span > span').html('-')
                    }
                    // console.log('get last bid', data)
                }
            })
        }
    };

    function getLastHighestBid(id, highBid_list, eq, bid_step_list) {
        let bid_step = bid_step_list.find('span > span').text().slice(1);
        if (auc_status == '0' || auc_status == '1') {
            $.ajax({
                type : 'GET',
                url : API + hostNow + 'run_sql.php',
                data : {
                    as : 'json',
                    
                    sql : 'SELECT bid_value,user_id FROM tr_bid WHERE master_id = '+ id +' ORDER BY bid_value DESC , bid_time  LIMIT 1'
					
                },
                success: function(data) {
                    // console.log(data)
                    if (data != "0 results") {
                        let result = JSON.parse(data)
                        highBid_list.find('span > span').html( numberWithCommas(result[0]['bid_value']) )
                        $('#bid_value_'+ eq).val(numberWithCommas(parseFloat(result[0]['bid_value']) + parseFloat(bid_step)))

                    } else {
                        highBid_list.find('span > span').html('-')
                    }
                    // console.log('get last highest bid', data)
                }
            })
        }
    }

    function reqSampleDoneAdmin(id, req_sample_list) {
        if (userLevel == '0') {
            $.ajax({
                type : 'GET',
                url : API + hostNow + 'run_sql.php',
                data : {
                    as : 'json',
                    
                    sql : 'SELECT COUNT(row_id) FROM tr_req_sample WHERE master_id='+ id +';'
                },
                success: function(data) {
                    // console.log(data)
                    if (data != "0 results") {
                        let result = JSON.parse(data)
                        let hasil = result[0]["COUNT(row_id)"]
                        if (hasil == "0") {
                            // console.log('tidak ada datanya req sample')
                            req_sample_list.find('span > div').remove()
                            var btn_req_sample = '<div class="btn-group" data-original-title="" title=""><a class="btn-sm ewRowLink ewDetail btn btn-lg btn-primary" disabled="disabled"> '+ hasil + ' Request&nbsp;</a></div>'
                            req_sample_list.find('span').append(btn_req_sample)
                        } else {
                            req_sample_list.find('span > div').remove()
                            var btn_req_sample = '<div class="btn-group" data-original-title="" title=""><a class="btn-sm ewRowLink ewDetail btn btn-lg btn-success" disabled="disabled"> '+ hasil + ' Request&nbsp;</a></div>'
                            req_sample_list.find('span').append(btn_req_sample)
                        }
                    }
                }
            }) 
        }
    }

    function reqSampleDoneUser() {
        $.ajax({
            type : 'GET',
            url : API + hostNow + 'run_sql.php',
            data : {
                as : 'json',
                sql : `SELECT * FROM tr_req_sample AS td1, tr_lelang_item AS td2
                    WHERE td1.master_id=td2.row_id AND td2.master_id='`+ master_id +`' AND td1.user_id='`+ userID +`' 
                    ORDER BY td2.row_id ;`
            },
            success: function(data) {
                if (userLevel != '0') {
                    if (data != "0 results") {
                        var result = JSON.parse(data)
                        let jumlahField = totalField('#tbl_v_tr_lelang_itemlist')
                        var tbl_lelang_item = $('#tbl_v_tr_lelang_itemlist').find('tbody tr')
                        for (let i = 0; i < jumlahField; i++) {
                            let checkDataIndex = tbl_lelang_item.eq(i).attr('data-rowindex')
                            let id_list = tbl_lelang_item.eq(i).find('[data-name="row_id"]')    
                            let req_sample_list = tbl_lelang_item.eq(i).find('[data-name="req_sample"]')
                            if (checkDataIndex != "$rowindex$" ) {
                                let get_id = id_list.find('span > span').text().slice(1)
                                for (let j = 0; j < result.length; j++) {
                                    if (get_id == result[j].row_id) {
                                        req_sample_list.find('span > div > a').removeClass('btn-primary').addClass('btn-success').removeAttr('data-target').html('Request Done').removeAttr('onclick')
                                        if (difference_days_start_bid < 7) {
                                            let icon_checklist = `<i class="fa fa-check" aria-hidden="true" style="margin: 0%;"></i>`
                                            req_sample_list.find('span > div > a').html(icon_checklist)
                                        }
                                    } else {
                                        if (req_sample_list.find('span > div > a').hasClass('btn-success') == false) {
                                            if (difference_days_start_bid < 7) {
                                                let icon_minus = `<i class="fa fa-minus" aria-hidden="true" style="margin: 0%;"></i>`
                                                req_sample_list.find('span > div > a').html(icon_minus)
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        })
    }

    function populateLastDataUser(ld) {
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

    function getLastDataUser() {
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
                if (data != '0 results') {
                    let result = JSON.parse(data)
                    console.log(' Success Get Last Data = ', result)
                    populateLastDataUser(result)
                } else {
                    populateLastDataUser(data)
                }
            }
        })
    }

    window.allCloseBidUser = function() {
        console.log('User - close bid berjalan')
        let jumlahField = totalField('#tbl_v_tr_lelang_itemlist')
        var tbl_lelang_item = $('#tbl_v_tr_lelang_itemlist').find('tbody tr')
        for (let i = 0; i < jumlahField; i++) {
            let checkDataIndex = tbl_lelang_item.eq(i).attr('data-rowindex')
            let id_list = tbl_lelang_item.eq(i).find('[data-name="row_id"]')    
            if (checkDataIndex != "$rowindex$" ) {
                let get_id = id_list.find('span > span').text().slice(1)
                // getHighestBidUser(get_id, highBid_list, bid_step_list, auction_status_list, winner_bid_list)
            }
        }

        setTimeout(function() {
            getLastDataUser()
        }, 2000)
    }

    window.populateTable = function(status) {
        // console.log(status)
        let jumlahField = totalField('#tbl_v_tr_lelang_itemlist')
        var tbl_lelang_item = $('#tbl_v_tr_lelang_itemlist').find('tbody tr')
        for (let i = 0; i < jumlahField; i++) {
            let checkDataIndex = tbl_lelang_item.eq(i).attr('data-rowindex')
            // let enterBid_list = $('#tbl_v_tr_lelang_itemlist').find('tbody tr').eq(i).find('[data-name="enter_bid"]')
            let highBid_list = tbl_lelang_item.eq(i).find('[data-name="highest_bid"]')
            let lastBid_list = tbl_lelang_item.eq(i).find('[data-name="last_bid"]')
            let bid_step_list = tbl_lelang_item.eq(i).find('[data-name="bid_step"]')
            let req_sample_list = tbl_lelang_item.eq(i).find('[data-name="req_sample"]')
            let auction_status_list = tbl_lelang_item.eq(i).find('[data-name="auction_status"]')
            let id_list = tbl_lelang_item.eq(i).find('[data-name="row_id"]')    
            if (checkDataIndex != "$rowindex$" ) {
                let get_id = id_list.find('span > span').text().slice(1)
                reqSampleDoneAdmin(get_id, req_sample_list)
                if (status == '0' || status == '1') {
                    // console.log('terpanggil')
                    getLastBid(get_id, lastBid_list)
                    getLastHighestBid(get_id, highBid_list, i, bid_step_list)
                    if (userLevel != '0') {
                    }
                }

                let state_auc = auction_status_list.find('span > span')
                if (state_auc.text().slice(1) == 'Opened') {
                    state_auc.addClass('auc_status_opened')
                } else if (state_auc.text().slice(1) == 'WD') {
                    state_auc.addClass('auc_status_wd')
                } else if (state_auc.text().slice(1) == 'Sold') {
                    state_auc.addClass('auc_status_sold')
                } 
            }
        }
    }

    // Called after form input is processed
    window.startConnect = function() {
        // Generate a random client ID
        clientID = "clientID-" + parseInt(Math.random() * 100);

        // Fetch the hostname/IP address and port number from the form
        host = "broker.hivemq.com";
        port = 8000;

        // Initialize new Paho client connection
        client = new Paho.MQTT.Client(host, Number(port), clientID);

        // Set callback handlers
        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;

        // Connect the client, if successful, call onConnect function
        client.connect({ 
            onSuccess: onConnect,
        });
    }

    // Called when the client connects
    function onConnect() {
        // Fetch the MQTT topic from the form
        topic = "mqtt/new/bid_server";

        // Print output for the user in the messages div
        console.log("[read.html] Subscribing to: " + topic);

        // Subscribe to the requested topic
        client.subscribe(topic);

        $('.status_mqtt').html('CONNECTED').css({'color': 'green', 'font-weight': 'bold'})
        $('.status_mqtt').append(' <i class="fa fa-check"></i>')
        $('.custom_message_lost').hide();
    }

    // Called when the client loses its connection
    function onConnectionLost(responseObject) {
        console.log("[read.html] ERROR: Connection lost");
        $('.status_mqtt').html('DISCONNECT').css({'color': 'red', 'font-weight': 'bold'})
        $('.status_mqtt').append(' <i class="fa fa-times"></i>')
        if (responseObject.errorCode !== 0) {
            $('.custom_message_lost').show();
            console.log("[read.html] ERROR: " + responseObject.errorMessage );
        }
    }

    // Called when a message arrives
    function onMessageArrived(message) {
        console.log("[read.html] onMessageArrived: " + message.payloadString);
        if(message.payloadString == "query")
        {
            populateTable(auc_status);
            console.log("[read.html] Sending query request...");
            if (userLevel == '0') {
                toastr.success("ADA BID BARU.");
            }
        }
    }

    // Called when the disconnection button is pressed
    window.startDisconnect = function() {
        client.disconnect();
        console.log('Connection server disconnect')
        // document.getElementById("messages").innerHTML += '<span>Disconnected</span><br/>';
    }

    window.getRowID = function (id) {
        window.row_id = id;
    }

    window.addBid = function (eq, id) {
        let c = $('#bid_value_' + eq)

        let obj = {
            master_id : "" + id + "",
            bid_time : dateNow + " " + $('#time_lelang_bid').text(),
            bid_value : $('#bid_value_' + eq).val().split(',').join(''),
            user_id : userID
        }

        function addNewBid(obj) {
            $.ajax({
                type : 'POST',
                url : API + hostNow + 'run_sql_insert.php',
                data : {
                    sql : "INSERT INTO tr_bid (master_id, bid_value, user_id) VALUES ('"+ obj.master_id +"', '"+ obj.bid_value +"', '"+ obj.user_id +"')",
                },
                success: function(data) {
                    console.log(data)
                    setTimeout(function() {
                        toastr.success("BID BERHASIL NILAI "+ c.val() +"");
                    }, 2000)
                }
            })
        }

        if (c.hasClass('input-error') == true) {
            toastr.error("NILAI BID LEBIH KECIL DARI HIGHEST BID TERAKHIR");
        } else {
            toastr.success("PROCESSING BID, LOADING.");
            let sql = "UPDATE tr_lelang_item SET last_bid='"+ obj.bid_value +"' WHERE row_id='"+ id +"'";
            $.ajax({
                type: 'POST',
                url : API + hostNow + 'run_sql_post.php',
                data : {
                    sql : sql,
                    db : obj.db
                },
                success: function(data) {
                    console.log(data)
                    addNewBid(obj)
                }
            })
        }

    }

    window.getReqSample = function (id, eq) {
        window.row_id = id;
        window.req_sample_eq = eq;
        $('#addReqSample').show();
        $('#cancelReqSample').html('Cancel');
    }

    window.addReqSample = function () {
        $('.spinner_req').show();
        $('#addReqSample').attr('disabled', 'disabled');
        let req_sample_list = $('#tbl_v_tr_lelang_itemlist').find('tbody tr').eq(req_sample_eq).find('[data-name="req_sample"]')

        let obj = {
            master_id : "" + row_id + "",
            req_date : dateNow + " " + $('#time_lelang_bid').text(),
            user_id : userID
        }

        let sql = "INSERT INTO tr_req_sample (master_id, req_date, user_id) VALUES ('"+ obj.master_id +"', '"+ obj.req_date +"', '"+ obj.user_id +"')";

        $.ajax({
            type : 'POST',
            url : API + hostNow + 'run_sql_insert.php',
            data : {
                sql : sql,
                db : obj.db
            },
            success: function(data) {
                console.log(data)
                reqSampleDone(row_id, userID, req_sample_list)
                $('.success-req-sample').show()
                $('#addReqSample').hide()
                $('.spinner_req').hide();
                $('#cancelReqSample').html('Close')
                setTimeout(function() {
                    $('.close').click();
                    $('.success-req-sample').hide();
                    $('#addReqSample').removeAttr('disabled');
                }, 3000)
            }
        })
    }

    function calculateRow(status) {
        console.log(status)
        let jumlahField = totalField('#tbl_v_tr_lelang_itemlist')
        var tbl_lelang_item = $('#tbl_v_tr_lelang_itemlist').find('tbody tr')
		for(let i = 0; i < jumlahField; i++){
            let checkDataIndex = tbl_lelang_item.eq(i).attr('data-rowindex')
            let enterBid_list = tbl_lelang_item.eq(i).find('[data-name="enter_bid"]')
            let lastBid_list = tbl_lelang_item.eq(i).find('[data-name="last_bid"]')
            let highBid_list = tbl_lelang_item.eq(i).find('[data-name="highest_bid"]')
            let bid_val = tbl_lelang_item.eq(i).find('[data-name="bid_val"]')
            let bid_step_list = tbl_lelang_item.eq(i).find('[data-name="bid_step"]')
            let open_bid_list = tbl_lelang_item.eq(i).find('[data-name="open_bid"]')
            let bid_list = tbl_lelang_item.eq(i).find('[data-name="btn_bid"]')
            let req_sample_list = tbl_lelang_item.eq(i).find('[data-name="req_sample"]')
            let sack_list = tbl_lelang_item.eq(i).find('[data-name="sack"]')
            let netto_list = tbl_lelang_item.eq(i).find('[data-name="netto"]')
            let gross_list = tbl_lelang_item.eq(i).find('[data-name="gross"]')
            let auction_status_list = tbl_lelang_item.eq(i).find('[data-name="auction_status"]')
            let winner_bid_list = tbl_lelang_item.eq(i).find('[data-name="winner_id"]')
            let check_list = tbl_lelang_item.eq(i).find('[data-name="check_list"]')
            let id_list = tbl_lelang_item.eq(i).find('[data-name="row_id"]')
            if (checkDataIndex != "$rowindex$" ) {
                enterBid_list.css({'text-align': 'center'})
                lastBid_list.css({'text-align': 'right'})
                highBid_list.css({'text-align': 'right'})
                winner_bid_list.css({'text-align': 'center'})
                bid_list.css({'text-align': 'center'})
                check_list.css({'text-align': 'center'})
                req_sample_list.css({'text-align': 'center'})
                sack_list.css({'text-align': 'right'})
                netto_list.css({'text-align': 'right'})
                gross_list.css({'text-align': 'right'})
                auction_status_list.css({'padding': '10px 5px'})

                check_list.find('span > span').remove()
                if (check_list.find('span > input').length == 0) {
                    if (userLevel != '0') {
                        let checkbox = `<input type="checkbox" data-field="" name="" id="check_bid_`+ i +`" value="1" class="form-checkbox">`
                        check_list.find('span').append(checkbox);
    
                        markCheckList(i, check_list)
                    }
                }

                let val_bid_step = bid_step_list.find('span > span').text().slice(1);
                let val_open_bid = open_bid_list.find('span > span').text().slice(1);
                let first_val_bid = parseFloat(val_bid_step) + parseFloat(val_open_bid);
                var bid_val_input = `<div class="input-group" >
                        <input type="" id="bid_value_`+ i +`" class="input-bid mod" value="`+ numberWithCommas(first_val_bid) +`"><span class="input-group-btn">
                            <button id="bidUp_`+ i +`" type="button" class="btn btn-primary btn-sm" style="font-size: 11px; height: 15.5px; padding: 0 10px;">
                                <i class="fa fa-angle-up" aria-hidden="true" style="margin: 0%;"></i>
                            </button><br>
                            <button id="bidDown_`+ i +`" type="button" class="btn btn-success btn-sm" style="font-size: 11px; height: 15.5px; padding: 0 10px;">
                                <i class="fa fa-angle-down" aria-hidden="true" style="margin: 0%;"></i>
                            </button>
                        </span>
                    </div>`;
                bid_val.find('span > span').remove()

                var id_lelang_item = id_list.find('span > span').text().slice(1)
                var btn_bid = `
                    <div class="spinner-border text-danger spinner_bid_`+i+`" role="status" style="display: none; margin-right: 10px;">
                        <span class="sr-only">Loading...</span>
                    </div>
                <div class="btn-group" data-original-title="" title=""><a class="btn-sm ewRowLink ewDetail btn btn-lg btn-danger"><i class="fa fa-usd" aria-hidden="true"></i> Bid&nbsp;</a></div>`
                bid_list.find('span > span').remove()

                var btn_req_sample = '<div class="btn-group" data-original-title="" title=""><a class="btn-sm ewRowLink ewDetail btn btn-lg btn-primary" data-toggle="modal" data-target="#modalReqSample" onclick="getReqSample('+ id_lelang_item +', '+ i +')">Request Sample&nbsp;</a></div>'
                req_sample_list.find('span > span').remove()

                if (bid_val.find('span > div').length == 0) {
                    bid_val.find('span').append(bid_val_input)
                    bid_list.find('span').append(btn_bid)
                }

                if (userLevel != '0') {
                    if (req_sample_list.find('span > div').length == 0) {
                        req_sample_list.find('span').append(btn_req_sample)
                    }
                }

                if (status == '-1') {
                    bid_list.find('span > div > a').attr('disabled', 'disabled')
                    bid_val.find('span > div > span > button').attr('disabled', 'disabled')
                    lastBid_list.find('span > span').html('-')
                    highBid_list.find('span > span').html('-')
                    winner_bid_list.find('span > span').html('-')
                    $('#bid_value_'+ i).addClass('form-control').attr('readonly', 'readonly')
                } else if (status == '0') {
                    bid_list.find('span > div > a').attr('onclick', 'addBid('+ i +' ,'+ id_lelang_item +')')
                    bid_list.find('span > div > a').removeAttr('disabled')
                    bid_val.find('span > div > span > button').removeAttr('disabled', 'disabled')
                    highBid_list.find('span > span').attr('id', 'highest_bid_' + i + '')
                    winner_bid_list.find('span > span').html('-')
                    $('#bid_value_'+ i).removeClass('form-control').removeAttr('readonly')
                    bidUpDown(i, bid_step_list, open_bid_list, highBid_list)
                } 

			} else {
				console.log('NOT eksekusi = ' + checkDataIndex)
            }
            
            if (difference_days_start_bid < 7) {
                // console.log(difference_days_start_bid, 'kurang tujuh hari')
                req_sample_list.find('span > div > a').removeAttr('onclick')
                req_sample_list.find('span > div > a').removeAttr('data-target')
                req_sample_list.find('span > div > a').removeAttr('data-toggle')
                req_sample_list.find('span > div > a').attr('disabled', 'disabled')

                if (userLevel == '1') {
                    let icon_checklist = `<i class="fa fa-check" aria-hidden="true"></i>`
                    let icon_minus = `<i class="fa fa-minus" aria-hidden="true"></i>`
                    if (req_sample_list.find('span > div > a').hasClass('btn-primary') == true) {
                        req_sample_list.find('span > div > a').html(icon_minus)
                    } else {
                        req_sample_list.find('span > div > a').html(icon_checklist)
                    }
                }
            }
		}
    };

    function bidUpDown(eq , bid_step_list, open_bid_list, highBid_list) {
        var bid_step = bid_step_list.find('span > span').text().slice(1);
        
        function checkCorrectBid(bid) {
            let open_bid = open_bid_list.find('span > span').text().slice(1);
            let high_bid = highBid_list.find('span > span').text();
            let lastHighest_bid = $('#highest_bid_'+ eq + '').text().split(',').join('')

            if (high_bid == '-' || high_bid == ' ') {
                console.log('lebih ' + parseFloat(bid), parseFloat(open_bid))
                if (parseFloat(bid) <= parseFloat(open_bid) || parseFloat(bid) <= 0) {
                    $('#bid_value_'+ eq + '').addClass('input-error');
                } else {
                    $('#bid_value_'+ eq + '').removeClass('input-error');
                }
            } else {
                console.log('kurang ' + parseFloat(bid), parseFloat(lastHighest_bid))
                if (parseFloat(bid) <= parseFloat(lastHighest_bid) || parseFloat(bid) <= 0) {
                    $('#bid_value_'+ eq + '').addClass('input-error');
                } else {
                    $('#bid_value_'+ eq + '').removeClass('input-error');
                }
            }
        }

        $('#bidUp_' + eq).on('click', function() {
            let bid_value = $('#bid_value_' + eq).val().split(',').join('');
            let hasil = parseFloat(bid_value) + parseFloat(bid_step);
            // console.log(hasil)
            if (hasil == 0) {
                $('#bid_value_' + eq).val( 0 )
            } else {
                $('#bid_value_' + eq).val( numberWithCommas(hasil) )
            }

            checkCorrectBid(parseFloat(bid_value) + parseFloat(bid_step))
        })

        $('#bidDown_' + eq).on('click', function() {
            let bid_value = $('#bid_value_' + eq).val().split(',').join('');
            let hasil = parseFloat(bid_value) - parseFloat(bid_step) ;
            // console.log(hasil)
            if (hasil == 0) {
                $('#bid_value_' + eq).val( 0 )
            } else {
                $('#bid_value_' + eq).val( numberWithCommas(hasil) )
            }

            checkCorrectBid(parseFloat(bid_value) - parseFloat(bid_step))
        })

        $('#bid_value_' + eq).on('keyup', function() {
            let getValueBid = $(this).val().split(',').join('')
            let hasil = numberWithCommas(getValueBid)
            $(this).val(hasil)
            
            checkCorrectBid(getValueBid)
        })
    }

    function markCheckList(i, check_list) {
        $('#check_bid_'+ i).on('click', function() {
            var tableLelangItem = $('#tbl_v_tr_lelang_itemlist').find('tbody tr')
            if ($(this).prop('checked') == true) {
                console.log('berhasil')
                tableLelangItem.eq(i).css({'background': 'green'})
                tableLelangItem.eq(i).find('td').css({'color': '#fff'})
            } else {
                if (tableLelangItem.eq(i).hasClass('ewTableAltRow') == false) {
                    tableLelangItem.eq(i).css({'background': '#fff'})
                } else {
                    tableLelangItem.eq(i).css({'background': '#EEF4E0'})
                }
                tableLelangItem.eq(i).find('td').css({'color': '#000'})
            }
        })
    }

    $('#cancelReqSample').on('click', function() {
        $('.spinner_req').hide();
        $('.success-req-sample').hide();
        $('#addReqSample').removeAttr('disabled');
    })

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

    function convertItemIdr(nameClass) {
        var item = $(nameClass).find('span > span')
        if (item.slice(1) != '') {
            var item_text = item.text()
            var getFormatIdr = numberWithCommas(item_text)
            if (getFormatIdr.split('.').length == 1) {
                item.html(getFormatIdr + '.00')
            } else if (getFormatIdr.split('.').length == 2) {
                item.html(getFormatIdr)
            }
        }
    }

    window.loadDataFirst = function() {
        if (auc_status == '-1') {
            calculateRow(auc_status)
            reqSampleDoneUser()
            setTimeout(function() {
                populateTable(auc_status)
                startConnect();
            }, 2500)
            setTimeout(function() {
                $('body').addClass('loaded');
            }, 3500);
        } else if (auc_status == '0') {
            calculateRow(auc_status)
            reqSampleDoneUser()
            setTimeout(function() {
                populateTable(auc_status);
                startConnect();
                $('body').addClass('loaded');
            }, 3500);
        } else if (auc_status == '1') {
            calculateRow(auc_status)
            reqSampleDoneUser()
            setTimeout(function() {
                populateTable(auc_status);
                $('body').addClass('loaded');
            }, 1000);
            $('[data-name="bid_val"]').remove();
            $('[data-name="btn_bid"]').remove();
        }
    }

    startCloseBid('.start-bid-v-tr-lelang-item', 'start')
    startCloseBid('.close-bid-v-tr-lelang-item', 'close')
    difference_days_start_bid = differenceDays(start_bid[2], start_bid[0].slice(1), start_bid[1])
    loadDataFirst()
    convertItemIdr('.sack-item')
    convertItemIdr('.gross-item') 
    convertItemIdr('.rate-item') 
    // convertItemIdr('.netto-item')
    
    // for add new script Admin
    setTimeout(function() {
        if (userLevel == '0') {
            $('section.content').append("<script type='text/javascript' src='"+ hostNow +"phpjs/customjs/v_tr_lelang_item_for_admin.js'></script>")
            console.log('Ini Admin')
        } else {
            console.log('Ini User')
        }
    }, 2500)
})