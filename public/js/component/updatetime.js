$(document).ready(function () {
    submitSetDateTimeToday();
});

var submitOnlineUser = function submitOnlineUser() {
    axios({
        method: 'POST',
        url: 'api/v1/general/submit-online_user'
    })
    .then(function (response) {
        console.log('User Time Update OK')
    })
    .catch(function (error) {
        console.log('User Time Update Error')
    })
    .then(function () {
        window.Pace.stop();
    })
}

var submitSetDateTimeToday = function submitSetDateTimeToday() {
    if ($('html').attr('lang') == 'th') {
        $("#dateTimeToday").html('<i class="fas fa-clock"></i> ' + moment().lang("th").format(' H:mm:ss') + ' | <i class="fas fa-calendar-alt"></i> วัน ' + moment().lang("th").format(' Do MMMM YYYY'));
    }else {
        $("#dateTimeToday").html('<i class="fas fa-clock"></i> ' + moment().lang("en").format(' H:mm:ss') + ' | <i class="fas fa-calendar-alt"></i> Day ' + moment().lang("en").format(' Do MMMM YYYY'));
    }
}

// Time Setting
workerTimers.setInterval(() => {
    submitOnlineUser();
}, 60000);

// Loop Time
workerTimers.setInterval(() => {
    submitSetDateTimeToday();
}, 1000);