// this is for create number with separator comma
function numberWithCommas(x) {
    if (x == 0 || x == "↵") {
        return 0
    } else if (x !== "") {
        let e = x.toString().split('')
        e[0] == '0' ? e = e.slice(1).join('') : '' ;
        let f = e.toString().split(',').join('')
        let y = f.toString().split('.')
        if (y.length == 2) {
            var a = y[0]
            var b = y[1].slice(0,2)
            // console.log('dari result commas = ' + a + ' . ' + b)
            return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' + b;
        } else if (y.length == 1) {
            return y[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    } else {
        return 0
    }
}

// this is for get data by url
function getDataUrl(data) {
    let lengthDataUrl = window.location.search.split('&').length
    for (let i = 0; i < lengthDataUrl; i++) {
        let checkDataUrl = window.location.search.split('&')[i].split('=')[0]
        var dataUrl = ''
        i == 0 ? dataUrl = checkDataUrl.slice(1) : dataUrl = checkDataUrl ;
        if (data == dataUrl) {
            let result = window.location.search.split('&')[i].split('=')[1]
            return result
        }
    }
}

// this is for change to be width 100% input
function responsiveWidthTable() {
    $('form.ewForm').css({'margin':'0%'})
    $('.ewTableHeader').find('th').css({'font-size': '12px'})

    $('.ewTableRow').find('td > span').css({'width':'100%'})
    $('.ewTableRow').find('td > span > input').css({'width':'100%'})
    $('.ewTableRow').find('td > span > span > span > input').css({'width':'100%'})
    $('.ewTableRow').find('td > span > div').css({'width':'100%'})
    $('.ewTableRow').find('td').css({'font-size': '12px'})
    $('.ewTableRow').find('td > .btn-group.ewButtonGroup').css({'text-align':'center', 'display': 'block' })
    
    $('.ewTableAltRow').find('td > span').css({'width':'100%'})
    $('.ewTableAltRow').find('td > span > input').css({'width':'100%'})
    $('.ewTableAltRow').find('td > span > span > span > input').css({'width':'100%'})
    $('.ewTableAltRow').find('td > span > div').css({'width':'100%'})
    $('.ewTableAltRow').find('td').css({'font-size': '12px'})
    $('.ewTableAltRow').find('td > .btn-group.ewButtonGroup').css({'text-align':'center', 'display': 'block' })
}

// this is for count total row in table detail
function totalField(nameTable) {
    let jumlahField = $(nameTable).find('tbody tr').length
    return jumlahField
};

function addCustomJS(nameJS) {
	let takeJS = "";
	if (nameJS.slice(-3) == "add") {
		takeJS = nameJS.slice(0, -3)
	} else if (nameJS.slice(-4) == "edit") {
		takeJS = nameJS.slice(0, -4)
	} else {
        takeJS = nameJS;
    }

    $.ajax({
        url: API + hostNow + 'phpjs/customjs/' + takeJS +'.js',
        type: 'GET',
        success: function() {
            console.log('file exists')
            // $('section.content').append("<script type='text/javascript' src='phpjs/customjs/" + takeJS +".js'></script>")
        },
        error: function(xhr) {
            console.log('file not exists')
        },
    });
};

window.monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
window.userID = "";
window.userLevel = "";

window.getUserID = function() {
    let username = $('.user-body').find('p').text().slice(2);
    $.ajax({
        type: 'GET',
        url : API + hostNow + 'run_sql.php',
        data : {
            as: 'json',
            sql : 'SELECT user_id, UserLevel FROM members WHERE username = "'+ username +'"',
        }, 
        success: function(data) {
            if (data != '0 results') {
                let result = JSON.parse(data);
                userID = result[0].user_id;
                userLevel = result[0].UserLevel;

                if (userLevel == '0') {
                    $('[name="mi_v_tr_lelang_master"]').find('a > span').html('Auction Monitoring')
                }
            }
        }
    });
}

setTimeout(function() {
    getUserID();
}, 2000)


$(document).ready(function() {
    // this is for add custom tittle navbar
    var custom_nav = '<h5 class="nav-title">Online Tea Auction - PT. KABEPE CHAKRA</h5>'
    $(custom_nav).insertBefore('.navbar-custom-menu')

    // this is for display username
	$("<p class='nav-username'>"+ $('.user-body').find('p').text() +"</p>").insertBefore('.navbar-nav')

	$('.ewTableHeader').find('th').css({'text-align':'center'});
	$('.ewGrid ').css({'display':'block'});
	$('.ewTable').css({'overflow-x':'auto !important'});

	// this is for change button images icon edit and delete
	//$('.ewEdit').find('span').remove()
	//$('.ewDelete').find('span').remove()
	//$('.ewGridDelete').find('span').remove()
	//$('.ewEdit').append('<img src="phpimages/btn_edit.jpg" border="0">')
	//$('.ewDelete').append('<img src="phpimages/btn_deletes.jpg" border="0">')
	//$('.ewGridDelete').append('<img src="phpimages/btn_deletes.jpg" border="0">')

	// this is for add icon save and cancel to button
	//$('#btnAction').prepend('<i class="fa fa-check" aria-hidden="true"></i> ')
	//$('#btnCancel').prepend('<i class="fa fa-times" aria-hidden="true"></i> ')

	// this function to call function will change width input table responsive
	responsiveWidthTable()

	// this is for disabled button detail in list table
	// $('.ewDetail').removeAttr('href')
	// $('.ewDetail').removeClass('btn btn-defaut btn-sm')
	// $('.ewDetail').addClass('detail-list')

    // ini untuk menyederhanakan alamat domain yg di gunakan.
    window.API = origin;

    // ini untuk membedakan antara project ini di jalankan di localhost atau di server.
	if (window.location.host == 'localhost' || '127.0.0.1') {
        if (window.location.pathname.slice(0, 9) == '/auction/') {
            window.hostNow = '/auction/'
        } else {
            window.hostNow = '/'
        }
    } else {
        if (window.location.pathname.slice(0, 9) == '/auction/') {
            window.hostNow = '/auction/'
        } else {
            window.hostNow = '/'
        }
    }

    // ini untuk memanggil function yg di mana function tersebut akan menambahkan script khusus untuk page tersebut 
    // dengan membawa parameter nama script dari page yg di jalankan
    if (hostNow == '/auction/') {
        addCustomJS( window.location.pathname.slice(9, -4) )
    } else {
        addCustomJS( window.location.pathname.slice(1, -4) )
    }

})