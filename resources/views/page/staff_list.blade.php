<!DOCTYPE html>
<html dir="ltr" lang="th">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | ตั้งค่ายูสเซอร์</title>
        @include('component.app_css')
    </head>

    <body>
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed">
            @include('component.head')
            <!-- Content -->
            <main id="main-container">
                <div class="bg-body-light">
                    <div class="content content-full">      
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2 text-center text-sm-left">
                            <div class="flex-sm-fill">
                                <h1 class="h3 font-w700 mb-2">
                                    ตั้งค่ายูสเซอร์
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="row row-deck">
                        <div class="col-12 col-sm-12 col-xl-12">
                            <div class="block block-mode-loading" id="blockStaffListTable">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title"><i class="fa fa-table"></i> ตารางข้อมูล</h3>
                                    <div class="block-options">
                                        <button class="btn btn-sm btn-success" onclick="openModalCreate(this)"><i class="fa fa-plus mr-1"></i>เพิ่มยูสเซอร์</button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <table class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full dataTable" style="width:100%" id="staffListTable" role="grid">
                                        <thead>
                                            <tr role="row" class="text-center">
                                                <th data-priority="1">ชื่อนามสกุล</th>
                                                <th>สิทธิ์</th>
                                                <th>ออนไลน์ล่าสุด</th>
                                                <th data-priority="1">สถานะ</th>
                                                <th>เครื่องมือ</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        <!-- Modal Create -->
        <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideup" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <form id="form-create" action="javascript:void(0)">
                            <div class="block-header bg-success">
                                <h3 class="block-title text-white"><i class="fa fa-plus mr-1"></i>เพิ่มยูสเซอร์</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content font-size-sm">
                                <div class="row">
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-fname">ชื่อจริง</label>
                                            <input type="text" class="form-control form-control-sm" id="create-fname" name="create-fname" placeholder="ชื่อจริง">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-lname">นามสกุลจริง</label>
                                            <input type="text" class="form-control form-control-sm" id="create-lname" name="create-lname" placeholder="นามสกุลจริง">
                                        </div> 
                                    </div>
                                    <div class="col-sm-12 col-xl-12">
                                        <div class="form-group mb-3">
                                            <label for="create-email">อีเมล์</label>
                                            <input type="text" class="form-control form-control-sm" id="create-email" name="create-email" placeholder="อีเมล์">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-username">ยูสเซอร์</label>
                                            <input type="text" class="form-control form-control-sm" id="create-username" name="create-username" placeholder="ยูสเซอร์">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-password">รหัสผ่าน</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="create-password" name="create-password" placeholder="รหัสผ่าน">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-password_set="create-password" onclick="setRandomPassword(this)"><i class="fas fa-random mr-1"></i>สู่มรหัส</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-roles">กำหนดสิทธ์</label>
                                            <select class="js-select2 form-control" id="create-roles" name="create-roles" style="width: 100%;">
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">

                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>ปิด</button>
                                    </div>
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="submit" class="btn btn-sm btn-block btn-success" id="btnSubmitCreate"><i class="fas fa-save mr-1"></i>บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Login Log -->
        <div class="modal fade" id="modalLoginLog" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout modal-xl" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0 block-mode-loading" id="blockLoginLogTable">
                        <div class="block-header bg-primary">
                            <h3 class="block-title"><i class="fas fa-file-alt mr-1"></i>ดูประวัติ</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <table class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full dataTable" style="width:100%" id="LoginLogTable" role="grid">
                                <thead>
                                    <tr role="row" class="text-center">
                                        <th data-priority="1">เวลา</th>
                                        <th data-priority="1">IP</th>
                                        <th data-priority="1">Device</th>
                                        <th>Country</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Change Password -->
        <div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <form id="form-change_password" action="javascript:void(0)">
                            <div class="block-header bg-info">
                                <h3 class="block-title text-white"><i class="fas fa-key mr-1"></i>เปลี่ยนพาส</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content font-size-sm">
                                <div class="form-group mb-3">
                                    <label for="change_password-password">รหัสผ่านใหม่</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="change_password-password" name="change_password-password" placeholder="รหัสผ่านใหม่">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-password_set="change_password-password" onclick="setRandomPassword(this)"><i class="fas fa-random mr-1"></i>สู่มรหัส</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="change_password-password_confirm">รหัสผ่าน ยืนยัน</label>
                                    <input type="text" class="form-control form-control-sm" id="change_password-password_confirm" name="change_password-password_confirm" placeholder="รหัสผ่าน ยืนยัน">
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>ปิด</button>
                                    </div>
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="submit" class="btn btn-sm btn-block btn-success" id="btnSubmitChangePassword"><i class="fas fa-save mr-1"></i>บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <form id="form-edit" action="javascript:void(0)">
                            <div class="block-header bg-warning">
                                <h3 class="block-title text-white"><i class="fa fa-edit mr-1"></i>แก้ไขผู้ดูแล</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content font-size-sm">
                                <div class="form-group">
                                    <label for="edit-staff_name">นามแฝง</label>
                                    <input type="text" class="form-control form-control-sm" id="edit-staff_name" name="edit-staff_name" placeholder="นามแฝง เข่น พนักงานเช้า">
                                </div>
                                <div class="form-group">
                                    <label for="edit-status">สิทธิ์เข้าสู่ระบบ</label>
                                    <select class="js-select2 form-control" id="edit-status" name="edit-status" style="width: 100%;">
                                        <option value="">กรุณาเลือก</option>
                                        <option value="0">ไม่สามารถเข้าสู่ระบบได้</option>
                                        <option value="1">สามารถเข้าสู่ระบบได้</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit-permission">กำหนดสิทธ์</label>
                                    <select class="js-select2 form-control" id="edit-permission" name="edit-permission" style="width: 100%;">
                                        <option value="">กรุณาเลือก</option>
                                        <option value="0">พนักงาน</option>
                                        <option value="1">แอดมิน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>ปิด</button>
                                    </div>
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="submit" class="btn btn-sm btn-block btn-success" id="btnSubmitEdit"><i class="fas fa-save mr-1"></i>บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content -->
        @include('../component.footer')
        </div>
        <!-- APP JS -->
        @include('component.app_js')
        <!-- Page JS -->
        <script type="text/javascript" src="{{ url('js/page/staff_list.js') }}"></script>
    </body>
</html>