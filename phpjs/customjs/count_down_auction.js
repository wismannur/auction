$(document).ready(function() {

    window.countDown_first = 1;
    window.getMasterUpdated = function(when) {
        $.ajax({
            type : 'GET',
            url : API + hostNow + 'run_sql.php',
            data : {
                as : 'json',
                sql : 'SELECT auc_status FROM tr_lelang_master WHERE row_id = '+ getDataUrl('fk_row_id') +';'
            },
            success: function(data) {
                console.log('data auc status = ' + data)
                if (data != "0 results") {
                    var hasil = JSON.parse(data)
                    if (when == 'start') {
                        if (hasil[0].auc_status == '-1') {
                            setTimeout(function() {
                                getMasterUpdated('start')
                            }, 500)
                        } else {
                            auc_status = '0'
                            loadDataFirst()
                        }
                        console.log('start masuk')
                    } else {
                        if (hasil[0].auc_status == '0') {
                            setTimeout(function() {
                                getMasterUpdated('close')
                            }, 500)
                        } else {
                            auc_status = '1'
                            loadDataFirst()
                            allCloseBidUser()
                        }
                        console.log('close masuk')
                    }
                } else {
                    console.log(data)
                }
            }
        })
    }

    window.changeAucStatus = function(val) {
        let obj = {
            id : row_id_lelang_item,
            auc_status : val
        }

        let sql = "UPDATE tr_lelang_master SET auc_status='"+ obj.auc_status +"' WHERE row_id='"+ obj.id +"'";
        $.ajax({
            type: 'POST',
            url : API + hostNow + 'run_sql_post.php',
            data : {
                sql : sql,
                db : obj.db
            },
            success: function(data) {
                console.log(data)
                if (auc_status == '-1') {
                    auc_status = '0'
                    loadDataFirst()
                } else if (auc_status == '0') {
                    auc_status = '1'
                    loadDataFirst()
                }
            }
        })
    }

    window.dateServer = function(year, month, date) {
        y =  year ;
        m = monthNames[ parseInt( month ) - 1 ];
        d =  date ;
        $('#date_lelang').html(d + " - " + m + " - " + y)
        window.dateNow = y +"-"+ parseInt( month ) +"-"+ d;
    }

    // TIMER
    function timer(current_date) {
        var timePhp = new Date( current_date ).getTime();
        
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }
    
        var w = setInterval(function() {
            timePhp = timePhp + 1000;
            var h = new Date(timePhp).getHours();
            var m = new Date(timePhp).getMinutes();
            var s = new Date(timePhp).getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            // console.log(timePhp +" | "+  h + ":" + m + ":" + s)
            // document.getElementById("timeNow").innerHTML = "Time Now = " + h + ":" + m + ":" + s;
            window.timeNow = h + ":" + m + ":" + s;
            document.getElementById("time_lelang").innerHTML = timeNow;
            // console.log(timeNow)
        }, 1000);
    }

    // ==========================================================================================
    // COUNTDOWN
    function countDown(start_bid, close_bid, time) {
        
        var countDownStartBid = start_bid * 1000;
        var countDownCloseBid = close_bid * 1000;
        var nowStartBidUser = time * 1000;
        var nowCloseBidUser = time * 1000;
        var nowStartBidAdmin = time * 1000;
        var nowCloseBidAdmin = time * 1000;
    
        // Update the count down every 1 second
        var xUser = setInterval(function() {
            // Set the date we're counting down to
            nowStartBidUser = nowStartBidUser + 1000;
                
            // Find the distance_first between now and the count down date
            window.distance_first = countDownStartBid - nowStartBidUser;
                
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance_first / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance_first % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance_first % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance_first % (1000 * 60)) / 1000);
                
            // Output the result in an element with id="demo"
            // console.log( days + " Hari | " + hours + ":" + minutes + ":" + seconds )
            $('#countDown').find('span').html( days + " Hari | " + hours + ":" + minutes + ":" + seconds )
            $('.custom-width-4').css({'border': '3px solid yellow'}); 
            $('.custom-width-4').find('.tittle-v-tr-lelang-item').html('Remaining Start')
    
            // If the count down is over, write some text 
            if (distance_first < 0) {
                countDown_first = 0;
                if ($('#auc_status').find('span > span').text().slice(1) == '-1') {
                    getMasterUpdated('start');
                }
                clearInterval(xUser);
            }       
        }, 1000);
    
        var yUser = setInterval(function() {
            // Set the date we're counting down to
            nowCloseBidUser = nowCloseBidUser + 1000;
                
            // Find the distance_last between now and the count down date
            window.distance_last = countDownCloseBid - nowCloseBidUser;
                
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance_last / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance_last % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance_last % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance_last % (1000 * 60)) / 1000);
                
            // Output the result in an element with id="demo"
            // console.log( days + " Hari | " + hours + ":" + minutes + ":" + seconds )
            if (countDown_first == 0) {
                $('#countDown').find('span').html( days + " Hari | " + hours + ":" + minutes + ":" + seconds )
                $('.custom-width-4').css({'border': '3px solid green'}); 
                $('.custom-width-4').find('.tittle-v-tr-lelang-item').html('Time Left')
            }
            
            // If the count down is over, write some text 
            if (distance_last < 0) {
                if (auc_status == '0') {
                    $('body').removeClass('loaded');
                    getMasterUpdated('close')
                    startDisconnect()
                }
    
                clearInterval(yUser);
                $('.custom-width-4').css({'border': '3px solid red'}); 
                $('#countDown').find('span').html("<h4 style='font-weight: bold; text-transform: uppercase; color: red;' >closed</h4>");
            }       
        }, 1000);
    
        // =============================================================================================================================
    
        var xAdmin = setInterval(function() {
            // Set the date we're counting down to
            nowStartBidAdmin = nowStartBidAdmin + 1000;
                
            // Find the distance_first between now and the count down date
            window.distance_first_admin = countDownStartBid - nowStartBidAdmin;
                
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance_first_admin / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance_first_admin % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance_first_admin % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance_first_admin % (1000 * 60)) / 1000);
                
            // If the count down is over, write some text 
            if (distance_first_admin < 0) {
                console.log(auc_status)
                if (userLevel == '0') {
                    if (auc_status == '-1') {
                        changeAucStatus('0')
                    }
                }
                clearInterval(xAdmin);
            }       
        }, 1000);
    
        var yAdmin = setInterval(function() {
            // Set the date we're counting down to
            nowCloseBidAdmin = nowCloseBidAdmin + 1000;
                
            // Find the distance_last between now and the count down date
            var distance_last_admin = countDownCloseBid - nowCloseBidAdmin;
                
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance_last_admin / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance_last_admin % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance_last_admin % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance_last_admin % (1000 * 60)) / 1000);
                
            // console.log(distance_last_admin)
            // If the count down is over, write some text 
            if (distance_last_admin < 0) {
                console.log(auc_status)
                if (userLevel == '0') {
                    if (auc_status == '0') {
                        console.log('semua close')
                        changeAucStatus('1')
                        $('body').removeClass('loaded');
                        allCloseBid()
                    }
                }
                clearInterval(yAdmin);
            } 
        }, 1000);
    }

    $.ajax({
        type : 'GET',
        // url : API + hostNow + 'count_down_auction.php?start_bid='+ getDataUrl('start_bid').split('%20').join(' ') + '&close_bid=' + getDataUrl('close_bid').split('%20').join(' ') ,
        url : API + hostNow + 'count_down_auction.php',
        data : {
            start_bid : getDataUrl('start_bid').split('%20').join(' '),
            close_bid : getDataUrl('close_bid').split('%20').join(' ')
        },
        success : function(data) {
            let result = JSON.parse(data)
            console.log(result)

            dateServer( result.year, result.month, result.date )
            timer( result.current_date )
            countDown( result.start_bid, result.close_bid, result.time )
        }
    })

});