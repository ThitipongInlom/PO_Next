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

// Time Setting
workerTimers.setInterval(() => {
    submitOnlineUser();
}, 60000);