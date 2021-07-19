var setButtonLoading = function setButtonLoading(element, action) {
    var buttonOldText = window.localStorage.getItem('setButtonLoading');
    var loadingText = '<div class="spinner-border spinner-border-sm mr-1" role="status"><span class = "sr-only"> Loading... </span></div>กำลังดำเนินการ';
    if (action == 'input') {
        window.localStorage.setItem('setButtonLoading', $(element).html());
        $(element).html(loadingText).attr('disabled', 'disabled');
    } else if (action == 'output') {
        window.Pace.stop();
        $(element).html(buttonOldText).removeAttr('disabled');
    } else {
        Swal.fire({
            icon: 'error',
            title: 'แจ้งเตือน!',
            text: 'ระบบ setButtonLoading Error',
            confirmButtonText: '<i class="fas fa-check mr-1"></i>ยืนยัน'
        });
    }
}

var setRandomPassword = function setRandomPassword(element, length = 8) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    $("#" + $(element).attr('data-password_set')).val(result);
}

var setNumberWithCommas = function setNumberWithCommas(data) {
    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

var generateSwalError = function generateSwalError(data) {
    // ถ้าไม่มี Error 
    if (!data.error) {
        Swal.fire({
            icon: 'error',
            title: 'แจ้งเตือน!',
            text: data.message,
            confirmButtonText: '<i class="fas fa-check mr-1"></i>ยืนยัน'
        })
    }else {
        var htmlOutput = '';
        htmlOutput += '<div class="row">';
        htmlOutput += '<div class="col-12 col-sm-12 col-xl-12 mb-1"><b>' + data.message + '</b></div>';
        $.map(data.error, function (val1, key1) {
            htmlOutput += '<div class="col-12 col-sm-12 col-xl-12 mb-1 text-center">----- ' + key1 + ' -----</div>';
            $.each(val1, function (key2, val2) {
                htmlOutput += '<div class="col-12 col-sm-12 col-xl-12 mb-1 text-left">* ' + val2 + '</div>';
            });
        });
        htmlOutput += '</div>';
        // Alert
        Swal.fire({
            icon: 'error',
            title: 'แจ้งเตือน!',
            html: htmlOutput,
            confirmButtonText: '<i class="fas fa-check mr-1"></i>ยืนยัน'
        })
    }
}

var submitChangeData = function submitChangeData(element) {
    var toast = setToast();
    setButtonLoading(element, 'input');
    axios({
        method: 'POST',
        url: 'backend/api/v1/setting_list/submit-change_data',
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            setting_key: $(element).attr('data-update_value'),
            setting_value: $("#" + $(element).attr('data-update_value')).val()
        }
    })
    .then(function (response) {
        toast.fire({
            icon: 'success',
            title: response.data.message
        })
    })
    .catch(function (error) {
        generateSwalError(error.response.data);
    })
    .then(function () {
        setButtonLoading(element, 'output');
    })
}

var getLangDataTable = function getLangDataTable() {
    if ($('html').attr('lang') == 'th') {
        var url = "//cdn.datatables.net/plug-ins/1.10.13/i18n/Thai.json";
    } else {
        var url = "//cdn.datatables.net/plug-ins/1.10.13/i18n/English.json";
    }
    return url;
}

var setImagePreviewData = function setImagePreviewData(element) {
    var fileName = $(element).val().split("\\").pop();
    $(element).siblings("label").addClass("selected").html(fileName);
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#' + $(element).attr('data-update_value')).attr('src', e.target.result);
    }
    reader.readAsDataURL(element.files[0]);
}

var setUpperCaseData = function setUpperCaseData(element) {
    $(element).val($(element).val().toUpperCase())
}

var setToast = function setToast() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    return Toast;
}

// var submitOnlineUser = function submitOnlineUser() {
//     axios({
//         method: 'POST',
//         url: 'backend/api/v1/general/submit-online_user'
//     })
//     .then(function (response) {
//         console.log('User Time Update OK')
//     })
//     .catch(function (error) {
//         console.log('User Time Update Error')
//     })
//     .then(function () {
//         window.Pace.stop();
//     })
// }

// // Time Setting
// workerTimers.setInterval(() => {
//     submitOnlineUser();
// }, 60000);