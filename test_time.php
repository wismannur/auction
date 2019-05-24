<?php

date_default_timezone_set('Asia/Jakarta');

$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

// echo $current_date = "$date-$month-$year $hour:$min:$sec";

?>

<!-- <br>
<div id="timeNow"></div>
<br>
<div id="countDown"></div> -->

<script type="text/javascript">
    window.onload = function() {
        if (window.location.pathname == "/auction/v_tr_lelang_itemlist.php" || window.location.pathname == "/v_tr_lelang_itemlist.php") {
            window.countDown_first = 1;
            window.getMasterUpdated = function(when) {
                $.ajax({
                    type : 'GET',
                    url : 'run_sql.php',
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
                                    getMasterUpdated('start')
                                } else {
                                    auc_status = '0'
                                    loadDataFirst()
                                }
                            } else {
                                if (hasil[0].auc_status == '0') {
                                    getMasterUpdated('close')
                                } else {
                                    auc_status = '1'
                                    loadDataFirst()
                                    allCloseBidUser()
                                }
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
                    url : 'run_sql_post.php',
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
    
            window.dateServer = function() {
                y =  "<?php echo $year ?>" ;
                m = monthNames[ parseInt("<?php echo $month ?>") - 1 ];
                d =  "<?php echo $date ?>" ;
                $('#date_lelang').html(d + " - " + m + " - " + y)
                window.dateNow = y +"-"+ parseInt("<?php echo $month ?>") +"-"+ d;
            }
            dateServer()
    
            // TIMER
            var timePhp = new Date( "<?php echo $current_date = "$month/$date/$year $hour:$min:$sec" ?>" ).getTime();
            
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
        
        
            // ==========================================================================================
            // COUNTDOWN
            var countDownStartBid = <?php echo strtotime( $_GET['start_bid'] ) ?> * 1000;
            var countDownCloseBid = <?php echo strtotime( $_GET['close_bid'] ) ?> * 1000;
            var nowStartBidUser = <?php echo time() ?> * 1000;
            var nowCloseBidUser = <?php echo time() ?> * 1000;
            var nowStartBidAdmin = <?php echo time() ?> * 1000;
            var nowCloseBidAdmin = <?php echo time() ?> * 1000;
        
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
                    getMasterUpdated('start');
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
    }
</script>
