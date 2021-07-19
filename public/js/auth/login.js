$(document).ready(function () {
    One.helpers("validation");

    readyFormSetting();

});

var readyFormSetting = function readyFormSetting() {
    // Form Login Validate
    $("#form-login").validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "กรุณากรอก username",
            },
            password: {
                required: "กรุณากรอก password",
            }
        },
        submitHandler: function (form) {
            submitLogin($("#btnLogin"));
        }
    });
}

var submitLogin = function submitLogin(element) {
    setButtonLoading(element, 'input');
    axios({
        method: 'POST',
        url: 'api/v1/auth/submit-login',
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            username: $("#username").val(),
            password: $("#password").val(),
            device: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? "Mobile" : "Desktop"
        }
    })
    .then(function (response) {
        $("#username").removeClass('is-valid').removeClass('is-invalid');
        $("#password").removeClass('is-valid').removeClass('is-invalid');
        location.href = "/dashboard";
    })
    .catch(function (error) {
        generateSwalError(error.response.data);
    })
    .then(function () {
        setButtonLoading(element, 'output');
    })
}
