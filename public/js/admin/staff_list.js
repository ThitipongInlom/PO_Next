$(document).ready(function () {
    One.helpers("select2");

    readyFormSetting();
    readyTableSetting();
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
            }
        },
        messages: {
            "create-fname": {
                required: "กรุณากรอก ชื่อจริง",
            },
            "create-lname": {
                required: "กรุณากรอก นามสกุลจริง",
            },
            "create-department_id": {
                required: "กรุณาเลือก แผนก",
            },
            "create-email": {
                required: "กรุณากรอก อีเมล์",
            },
            "create-username": {
                required: "กรุณากรอก ยูสเซอร์"
            },
            "create-password": {
                required: "กรุณากรอก รหัสผ่าน",
            },
            "create-roles": {
                required: "กรุณาเลือก กำหนดสิทธ์",
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
                required: "กรุณากรอก Password ที่จะตั้งใหม่",
            },
            "change_password-password_confirm": {
                required: "กรุณากรอก Password ยืนยันที่จะตั้งใหม่",
                equalTo: "กรุณากรอกรหัสผ่านให้ตรงกัน"
            }
        },
        submitHandler: function (form) {
            submitModalChangePassword($("#btnSubmitChangePassword"));
        }
    });

    // Form Edit Validate
    $("#form-edit").validate({
        rules: {
            "edit-staff_name": {
                required: true
            }, 
            "edit-status": {
                required: true
            },
            "edit-permission": {
                required: true
            }
        },
        messages: {
            "edit-staff_name": {
                required: "กรุณากรอก ชื่อ หรือว่านามแฝง",
            },
            "edit-status": {
                required: "กรุณาเลือก สิทธิ์เข้าสู่ระบบ"
            },
            "edit-permission": {
                required: "กรุณาเลือก กำหนดสิทธ์"
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
                        return 'ข้อมูลยูสเซอร์ ' + data.full_name;
                    }
                }),
                "renderer": $.fn.dataTable.Responsive.renderer.tableAll({
                    "tableClass": 'table'
                })
            }
        },
        "aLengthMenu": [
            [10, 25, -1],
            ["10", "25", "ทั้งหมด"]
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
                    title: 'แจ้งเตือน!',
                    text: xhr.responseJSON.message,
                    confirmButtonText: 'ยืนยัน'
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
                "targets": [0, 1, 2, 3, 4]
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
            roles: $("#create-roles").val()
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
        $("#edit-staff_name").val(response.data.data.staff_name);
        $("#edit-status").val(response.data.data.status).trigger('change');
        $("#edit-permission").val(response.data.data.permission).trigger('change');
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
            staff_name: $("#edit-staff_name").val(),
            status: $("#edit-status").val(),
            permission: $("#edit-permission").val()
        }
    })
    .then(function (response) {
        $("#modalEdit").modal('hide');
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

var openModalDelete = function openModalDelete(element) {
    var toast = setToast();
    Swal.fire({
        title: 'ยืนยัน ลบข้อมูล',
        html: '<div class="text-danger text-center">การลบข้อมูล จะไม่สามารถเรียกข้อมูลเดิมกลับมาได้</div>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28C76F',
        cancelButtonColor: '#EA5455',
        confirmButtonText: '<i class="fas fa-check mr-1"></i>ยืนยัน',
        cancelButtonText: '<i class="fas fa-times mr-1"></i>ยกเลิก',
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