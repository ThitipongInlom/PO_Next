<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | {{ __('menu.user_setting') }}</title>
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
                                    {{ __('menu.user_setting') }}
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
                                    <h3 class="block-title"><i class="fa fa-table"></i> {{ __('general.data_table') }}</h3>
                                    <div class="block-options">
                                        <button class="btn btn-sm btn-success" onclick="openModalCreate(this)"><i class="fa fa-plus mr-1"></i>{{ __('staff_list.add_user') }}</button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <table class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full dataTable" style="width:100%" id="staffListTable" role="grid">
                                        <thead>
                                            <tr role="row" class="text-center">
                                                <th data-priority="1">{{ __('staff_list.full_name') }}</th>
                                                <th>{{ __('staff_list.roles') }}</th>
                                                <th>{{ __('staff_list.last_online') }}</th>
                                                <th data-priority="1">{{ __('staff_list.status') }}</th>
                                                <th>{{ __('staff_list.tool') }}</th>
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
                                <h3 class="block-title text-white"><i class="fa fa-plus mr-1"></i>{{ __('staff_list.add_user') }}</h3>
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
                                            <label for="create-fname">{{ __('staff_list.first_name') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="create-fname" name="create-fname" placeholder="{{ __('staff_list.first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-lname">{{ __('staff_list.last_name') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="create-lname" name="create-lname" placeholder="{{ __('staff_list.last_name') }}">
                                        </div> 
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-department_id">{{ __('staff_list.department') }}</label>
                                            <select class="js-select2 form-control" id="create-department_id" name="create-department_id" style="width: 100%;">
                                                @foreach ($department as $value)
                                                    <option value="{{ $value->department_id }}">{{ $value->department_code }} | @if(app()->getLocale() == 'en') {{ $value->department_name_en }} @else {{ $value->department_name_th }} @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-email">{{ __('staff_list.email') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="create-email" name="create-email" placeholder="{{ __('staff_list.email') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-username">{{ __('staff_list.username') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="create-username" name="create-username" placeholder="{{ __('staff_list.username') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-password">{{ __('staff_list.password') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="create-password" name="create-password" placeholder="{{ __('staff_list.password') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-password_set="create-password" onclick="setRandomPassword(this)"><i class="fas fa-random mr-1"></i>{{ __('staff_list.random_code') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-roles">{{ __('staff_list.roles') }}</label>
                                            <select class="js-select2 form-control" id="create-roles" name="create-roles" style="width: 100%;">
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-lang">{{ __('staff_list.language') }}</label>
                                            <select class="js-select2 select_lang form-control" id="create-lang" name="create-lang" style="width: 100%;">
                                                <option value="th" data-select-image="{{ asset(Storage::url('assets/static/image/th.png')) }}">{{ __('general.thai') }}</option>
                                                <option value="en" data-select-image="{{ asset(Storage::url('assets/static/image/en.png')) }}">{{ __('general.english') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>{{ __('general.close') }}</button>
                                    </div>
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="submit" class="btn btn-sm btn-block btn-success" id="btnSubmitCreate"><i class="fas fa-save mr-1"></i>{{ __('general.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            <div class="modal-dialog modal-dialog-slideup" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <form id="form-edit" action="javascript:void(0)">
                            <div class="block-header bg-warning">
                                <h3 class="block-title text-white"><i class="fa fa-edit mr-1"></i>{{ __('staff_list.edit_user') }}</h3>
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
        <script type="text/javascript" src="{{ asset('js/admin/staff_list.js') }}"></script>
    </body>
</html>