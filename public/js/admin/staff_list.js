$(document).ready(function () {
    One.helpers("select2");

    readyFormSetting();
    readyTableSetting();
    // Select สำหรับ ภาษา
    $(".select_lang").select2({
        templateResult: function (element) {
            if ($(element.element).attr('data-select-image') != null) {
                return $("<span><img width='30' src='" + $(element.element).attr('data-select-image') + "'> " + element.text + "</span>");
            } else {
                return $("<span>" + element.text + "</span>");
            }
        },
        templateSelection: function (element) {
            if ($(element.element).attr('data-select-image') != null) {
                return $("<span><img width='30' src='" + $(element.element).attr('data-select-image') + "'> " + element.text + "</span>");
            } else {
                return $("<span>" + element.text + "</span>");
            }
        }
    });
});

var readyFormSetting = function readyFormSetting() {
    // Form Create Validate
    $("#form-create").validate({
        rules: {
            "create-fname": {
                required: true
            },
            "create-lname": {
                required: true
            },
            "create-department_id": {
                required: true
            },
            "create-email": {
                required: true
            },
            "create-username": {
                required: true
            },
            "create-password": {
                required: true,
            },
            "create-roles": {
                required: true,
            },
            "create-lang": {
                required: true,
            }
        },
        messages: {
            "create-fname": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.first_name'),
            },
            "create-lname": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.last_name'),
            },
            "create-department_id": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.department'),
            },
            "create-email": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.email'),
            },
            "create-username": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.username'),
            },
            "create-password": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.password'),
            },
            "create-roles": {
                required: trans('general.please_select') + ' ' + trans('staff_list.roles'),
            },
            "create-lang": {
                required: trans('general.please_select') + ' ' + trans('staff_list.language'),
            }
        },
        submitHandler: function (form) {
            submitModalCreate($("#btnSubmitCreate"));
        }
    });

    // Form Change Password Validate
    $("#form-change_password").validate({
        rules: {
            "change_password-password": {
                required: true
            },
            "change_password-password_confirm": {
                required: true,
                equalTo: "#change_password-password"
            }
        },
        messages: {
            "change_password-password": {
                required: trans('general.please_select') + " " + trans('staff_list.password_new'),
            },
            "change_password-password_confirm": {
                required: trans('general.please_select') + " " + trans('staff_list.password_confirm'),
                equalTo: trans('general.please_enter_the_same')
            }
        },
        submitHandler: function (form) {
            submitModalChangePassword($("#btnSubmitChangePassword"));
        }
    });

    // Form Edit Validate
    $("#form-edit").validate({
        rules: {
            "edit-fname": {
                required: true
            },
            "edit-lname": {
                required: true
            },
            "edit-department_id": {
                required: true
            },
            "edit-email": {
                required: true
            },
            "edit-roles": {
                required: true,
            },
            "edit-lang": {
                required: true,
            }
        },
        messages: {
            "edit-fname": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.first_name'),
            },
            "edit-lname": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.last_name'),
            },
            "edit-department_id": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.department'),
            },
            "edit-email": {
                required: trans('general.please_enter') + ' ' + trans('staff_list.email'),
            },
            "edit-roles": {
                required: trans('general.please_select') + ' ' + trans('staff_list.roles'),
            },
            "edit-lang": {
                required: trans('general.please_select') + ' ' + trans('staff_list.language'),
            }
        },
        submitHandler: function (form) {
            submitModalEdit($("#btnSubmitEdit"));
        }
    });
}

var readyTableSetting = function readyTableSetting() {
    // Staff List Table
    $('#staffListTable').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": {
            "details": {
                "display": $.fn.dataTable.Responsive.display.modal({
                    "header": function (row) {
                        var data = row.data();
                        return trans('staff_list.user_information') + ' ' + data.full_name;
                    }
                }),
                "renderer": $.fn.dataTable.Responsive.renderer.tableAll({
                    "tableClass": 'table'
                })
            }
        },
        "aLengthMenu": [
            [10, 25, -1],
            ["10", "25", trans('general.all')]
        ],
        "ajax": {
            "url": 'api/v1/datatable/get-datatable?action=Staff_List',
            "type": 'POST',
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "error": function (xhr, error, code) {
                Swal.fire({
                    icon: 'error',
                    title: trans('general.alert'),
                    text: xhr.responseJSON.message,
                    confirmButtonText: trans('general.confirm')
                })
            }
        },
        "columns": [{
            "data": 'full_name',
            "name": 'fname',
        }, {
            "data": 'roles',
            "name": 'roles',
        }, {
            "data": 'language',
            "name": 'language',
        }, {
            "data": 'updated_at',
            "name": 'updated_at',
        }, {
            "data": 'last_active',
            "name": 'last_active',
        }, {
            "data": 'action',
            "name": 'action',
            "orderable": false
        }],
        "columnDefs": [{
                "className": 'text-left',
                "targets": []
            },
            {
                "className": 'text-center',
                "targets": [0, 1, 2, 3, 4, 5]
            },
            {
                "className": 'text-right',
                "targets": []
            }
        ],
        "language": getLangDataTable(),
        "search": {
            "regex": true
        },
        "order": [
            [0, "desc"]
        ],
        "initComplete": function (settings, json) {
            setTimeout(function () {
                One.block('state_normal', '#blockStaffListTable');
            }, 1000);
        }
    });

    // Time Setting
    workerTimers.setInterval(() => {
        $('#staffListTable').DataTable().draw();
    }, 60000);
}

// Modal Create
var openModalCreate = function openModalCreate(element) {
    // Open Modal
    $("#modalCreate").modal({
        'backdrop': 'static',
        'show': true
    });
    // Hide Modal
    $('#modalCreate').on('hidden.bs.modal', function (e) {
        $("#form-create").validate().resetForm();
        $("#form-create input").val('').removeClass('is-valid').removeClass('is-invalid');
        $("#form-create .js-select2[name='create-roles']").val('user').trigger('change').removeClass('is-valid').removeClass('is-invalid');
    })
}

var submitModalCreate = function submitModalCreate(element) {
    var toast = setToast();
    setButtonLoading(element, 'input');
    axios({
        method: 'POST',
        url: 'api/v1/auth/submit-register',
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            fname: $("#create-fname").val(),
            lname: $("#create-lname").val(),
            department_id: $("#create-department_id").val(),
            email: $("#create-email").val(),
            username: $("#create-username").val(),
            password: $("#create-password").val(),
            roles: $("#create-roles").val(),
            language: $("#create-language").val()
        }
    })
    .then(function (response) {
        $("#modalCreate").modal('hide');
        $('#staffListTable').DataTable().draw();
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

var openModalChangePassword = function openModalChangePassword(element) {
    // Open Modal
    $("#modalChangePassword").modal({
        'backdrop': 'static',
        'show': true
    });
    // Btn Submit
    $("#btnSubmitChangePassword").attr('data-user_id', $(element).attr('data-user_id'));
    // Hide Modal
    $('#modalChangePassword').on('hidden.bs.modal', function (e) {
        $("#form-change_password").validate().resetForm();
        $("#form-change_password input").val('').removeClass('is-valid').removeClass('is-invalid');
        $("#form-change_password .js-select2").val('').trigger('change').removeClass('is-valid').removeClass('is-invalid');
    })
}

var submitModalChangePassword = function submitModalChangePassword(element) {
    var toast = setToast();
    setButtonLoading(element, 'input');
    axios({
        method: 'POST',
        url: 'api/v1/staff_list/submit-change_password',
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            user_id: $(element).attr('data-user_id'),
            password: $("#change_password-password").val(),
            password_confirmation: $("#change_password-password_confirm").val()
        }
    })
    .then(function (response) {
        $("#modalChangePassword").modal('hide');
        $('#staffListTable').DataTable().draw();
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

// Modal Edit
var openModalEdit = function openModalEdit(element) {
    // Btn Submit
    $("#btnSubmitEdit").attr('data-user_id', $(element).attr('data-user_id'));
    // Action
    axios({
        method: 'POST',
        url: 'api/v1/staff_list/get-user_data_id',
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            user_id: $(element).attr('data-user_id')
        }
    })
    .then(function (response) {
        // Open Modal
        $("#modalEdit").modal({
            'backdrop': 'static',
            'show': true
        });
        // Set Data
        $("#edit-fname").val(response.data.data.fname);
        $("#edit-lname").val(response.data.data.lname);
        $("#edit-department_id").val(response.data.data.department_id).trigger('change');
        $("#edit-email").val(response.data.data.email);
        $("#edit-username").val(response.data.data.username);
        $("#edit-password").val(response.data.data.password_plain_text == null ? '**********' : response.data.data.password_plain_text);
        $("#edit-roles").val(response.data.data.roles).trigger('change');
        $("#edit-language").val(response.data.data.language).trigger('change');
    })
    .catch(function (error) {
        generateSwalError(error.response.data);
    })
    .then(function () {
        window.Pace.stop();
    })
    // Hide Modal
    $('#modalEdit').on('hidden.bs.modal', function (e) {
        $("#form-edit").validate().resetForm();
        $("#form-edit input").val('').removeClass('is-valid').removeClass('is-invalid');
        $("#form-edit .js-select2").val('').trigger('change').removeClass('is-valid').removeClass('is-invalid');
    })
}

var submitModalEdit = function submitModalEdit(element) {
    var toast = setToast();
    setButtonLoading(element, 'input');
    axios({
        method: 'POST',
        url: 'api/v1/staff_list/submit-edit',
        headers: {
            "Content-Type": "application/json"
        },
        data: {
            user_id: $(element).attr('data-user_id'),
            fname: $("#edit-fname").val(),
            lname: $("#edit-lname").val(),
            department_id: $("#edit-department_id").val(),
            email: $("#edit-email").val(),
            roles: $("#edit-roles").val(),
            language: $("#edit-language").val()
        }
    })
    .then(function (response) {
        if (response.data.reloadPage == true) {
            location.reload();
        }else {
            $("#modalEdit").modal('hide');
            $('#staffListTable').DataTable().draw();
            toast.fire({
                icon: 'success',
                title: response.data.message
            })
        }
    })
    .catch(function (error) {
        generateSwalError(error.response.data);
    })
    .then(function () {
        setButtonLoading(element, 'output');
    })
}

var openModalDelete = function openModalDelete(element) {
    var toast = setToast();
    Swal.fire({
        title: trans('staff_list.confirm_delete'),
        html: '<div class="text-danger text-center">' + trans('staff_list.confirm_delete_description') + '</div>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28C76F',
        cancelButtonColor: '#EA5455',
        confirmButtonText: '<i class="fas fa-check mr-1"></i>' + trans('general.confirm'),
        cancelButtonText: '<i class="fas fa-times mr-1"></i>' + trans('general.cancel'),
        reverseButtons: true,
        allowOutsideClick: () => {
            const popup = Swal.getPopup()
            popup.classList.remove('swal2-show')
            setTimeout(() => {
                popup.classList.add('animated', 'shake')
            })
            setTimeout(() => {
                popup.classList.remove('animated', 'shake')
            }, 500)
            return false
        }
    }).then((result) => {
        if (result.isConfirmed) {
            axios({
                method: 'POST',
                url: 'api/v1/staff_list/submit-delete',
                headers: {
                    "Content-Type": "application/json"
                },
                data: {
                    user_id: $(element).attr('data-user_id')
                }
            })
            .then(function (response) {
                $('#staffListTable').DataTable().draw();
                toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
            })
            .catch(function (error) {
                generateSwalError(error.response.data);
            })
            .then(function () {
                window.Pace.stop();
            })
        }
    })
}