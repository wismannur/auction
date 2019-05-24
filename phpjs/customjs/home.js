$(document).ready(function() {
    
    console.log('this is home')
    $.ajax({
        type: 'GET',
        url: 'run_sql.php',
        data: {
            as: 'json',
            sql: 'SELECT * FROM tr_home'
        },
        success: function(data) {
            var result = JSON.parse(data)
            console.log(result)
            // debugger

            let wellcome_msg = `<div class="wellcome_msg">${result[0].wellcome_msg}</div>`
            let home_msg = `<div class="home_msg">${result[0].home_msg}</div>`

            $('.content-header').hide()
            $('#homeAuction').append(wellcome_msg)
            $('#homeAuction').append(home_msg)
        }
    })
})