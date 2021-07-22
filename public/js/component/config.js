$(document).ready(function () {
    validateConfigSetting();

    // ตั้งค่า ซ้อน Modal หลายๆอัน
    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
    // ตั้งค่า การปิดแล้วให้ ยัง scroll ใน Modal ที่ยังไม่ปิดได้
    $(document).on('hidden.bs.modal', '.modal', function (event) {
        if ($('.modal:visible').length != 0) {
            $('body').addClass('modal-open').css('padding-right', '15px');
        }
    });
    // เปิดการใช้งาน swal Input
    $(document).on('shown.bs.modal', function () {
        $(document).off('focusin.modal');
    });
    // Pace.js
    Pace.stop();
});


var validateConfigSetting = function validateConfigSetting() {
    $.validator.setDefaults({
        ignore: ".ignore",
        errorElement: 'span',
        errorElementClass: 'input-validation-error',
        errorClass: 'text-danger font-weight-bold',
        errorPlacement: function (error, element) {
            if (element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else {
                if ($(element).hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + $(element).attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }
            }
        },
        invalidHandler: function (form, validator) {
            var htmlOutput = '';
            var errors = validator.numberOfInvalids();
            if (errors) {
                htmlOutput += '<div class="row">';
                htmlOutput += '<div class="col-12 col-sm-12 col-xl-12 mb-1"><b>' + trans('general.alert_description') + '</b></div>';
                validator.errorList.forEach(element => {
                    htmlOutput += '<div class="col-12 col-sm-12 col-xl-12 mb-1 text-left">* ' + element.message + '</div>';
                });
                htmlOutput += '</div>';
                // Alert
                Swal.fire({
                    icon: 'error',
                    title: trans('general.alert'),
                    html: htmlOutput,
                    confirmButtonText: '<i class="fas fa-check mr-1"></i>' + trans('general.confirm')
                })
            }
        },
        highlight: function (element, errorClass) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).addClass('is-invalid').removeClass('is-valid').removeClass(errorClass);
                $("#select2-" + $(element).attr("id") + "-container").parent().removeClass(errorClass);
            } else {
                $(element).addClass('is-invalid').removeClass('is-valid').removeClass(errorClass);
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).addClass('is-valid').removeClass('is-invalid').removeClass(errorClass);
                $("#select2-" + $(element).attr("id") + "-container").parent().addClass('is-valid').removeClass('is-invalid').removeClass(errorClass);
            } else {
                $(element).addClass('is-valid').removeClass('is-invalid').removeClass(errorClass);
            }
        }
    });

    $.validator.prototype.checkForm = function () {
        this.prepareForm();
        for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
            if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
                for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                    this.check(this.findByName(elements[i].name)[cnt]);
                }
            } else {
                this.check(elements[i]);
            }
        }
        return this.valid();
    };

    $('.js-select2').on("change", function (e) {
        $(e.currentTarget).valid()
    });
}