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
                            <div class="mt-3 mt-sm-0 ml-sm-3">
                                <span class="animated fadeIn" id="dateTimeToday">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </span>
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
                                    <table class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full nowrap" style="width:100%" id="staffListTable" role="grid">
                                        <thead>
                                            <tr role="row" class="text-center">
                                                <th data-priority="1">{{ __('staff_list.full_name') }}</th>
                                                <th>{{ __('staff_list.roles') }}</th>
                                                <th>{{ __('staff_list.language') }}</th>
                                                <th>{{ __('staff_list.last_online') }}</th>
                                                <th>{{ __('staff_list.status') }}</th>
                                                <th data-priority="1">{{ __('staff_list.tool') }}</th>
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
                                                <option value="user">{{ __('general.admin') }}</option>
                                                <option value="admin">{{ __('general.user') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="create-language">{{ __('staff_list.language') }}</label>
                                            <select class="js-select2 select_lang form-control" id="create-language" name="create-language" style="width: 100%;">
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
                                <h3 class="block-title text-white"><i class="fas fa-key mr-1"></i>{{ __('general.change_password') }}</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content font-size-sm">
                                <div class="form-group mb-3">
                                    <label for="change_password-password">{{ __('staff_list.password_new') }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="change_password-password" name="change_password-password" placeholder="{{ __('staff_list.password_new') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-password_set="change_password-password" onclick="setRandomPassword(this)"><i class="fas fa-random mr-1"></i>{{ __('staff_list.random_code') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="change_password-password_confirm">{{ __('staff_list.password_confirm') }}</label>
                                    <input type="text" class="form-control form-control-sm" id="change_password-password_confirm" name="change_password-password_confirm" placeholder="{{ __('staff_list.password_confirm') }}">
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="button" class="btn btn-sm btn-block btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>{{ __('general.close') }}</button>
                                    </div>
                                    <div class="col-6 col-sm-6 col-xl-6">
                                        <button type="submit" class="btn btn-sm btn-block btn-success" id="btnSubmitChangePassword"><i class="fas fa-save mr-1"></i>{{ __('general.save') }}</button>
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
                                <h3 class="block-title text-white"><i class="fa fa-plus mr-1"></i>{{ __('staff_list.edit_user') }}</h3>
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
                                            <label for="edit-fname">{{ __('staff_list.first_name') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="edit-fname" name="edit-fname" placeholder="{{ __('staff_list.first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-lname">{{ __('staff_list.last_name') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="edit-lname" name="edit-lname" placeholder="{{ __('staff_list.last_name') }}">
                                        </div> 
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-department_id">{{ __('staff_list.department') }}</label>
                                            <select class="js-select2 form-control" id="edit-department_id" name="edit-department_id" style="width: 100%;">
                                                @foreach ($department as $value)
                                                    <option value="{{ $value->department_id }}">{{ $value->department_code }} | @if(app()->getLocale() == 'en') {{ $value->department_name_en }} @else {{ $value->department_name_th }} @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-email">{{ __('staff_list.email') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="edit-email" name="edit-email" placeholder="{{ __('staff_list.email') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-username">{{ __('staff_list.username') }}</label>
                                            <input type="text" class="form-control form-control-sm" id="edit-username" name="edit-username" placeholder="{{ __('staff_list.username') }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-password">{{ __('staff_list.password') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="edit-password" name="edit-password" placeholder="{{ __('staff_list.password') }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-roles">{{ __('staff_list.roles') }}</label>
                                            <select class="js-select2 form-control" id="edit-roles" name="edit-roles" style="width: 100%;">
                                                <option value="user">{{ __('general.admin') }}</option>
                                                <option value="admin">{{ __('general.user') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-language">{{ __('staff_list.language') }}</label>
                                            <select class="js-select2 select_lang form-control" id="edit-language" name="edit-language" style="width: 100%;">
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
                                        <button type="submit" class="btn btn-sm btn-block btn-success" id="btnSubmitEdit"><i class="fas fa-save mr-1"></i>{{ __('general.save') }}</button>
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
        <script type="text/javascript" src="{{ asset('js/admin/staff_list.js?t='.time()) }}"></script>
    </body>
</html>