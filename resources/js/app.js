//jQuery
window.$ = window.jQuery = require('jquery');
// Pace
window.Pace = require('pace-js');
window.Pace.start({
    document: false,
    eventLag: false,
    restartOnPushState: false,
    elements: {
        selectors: ['.my-page']
    }
});
// Sweetalert2
window.Swal = require('sweetalert2');
// Moment
window.moment = require('moment');
// worker-timers
window.workerTimers = require('worker-timers');
// Bootstrap Axios
require('./bootstrap');
