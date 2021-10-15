<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | {{ __('menu.profile_setting') }}</title>
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
                                    {{ __('menu.profile_setting') }} 
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
                    <div class="block block-rounded">
                        <div class="block-header">
                            <h3 class="block-title"><i class="fas fa-portrait mr-1"></i>ข้อมูลของผู้ใช้งาน</h3>
                        </div>
                        <div class="block-content">
                            <div class="row row-push">
                                <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-xl-6">
                                            <div class="form-group">
                                                <label for="edit-username">{{ __('staff_list.username') }}</label>
                                                <input type="text" class="form-control" id="edit-username" name="edit-username" placeholder="{{ __('staff_list.username') }}">
                                            </div>   
                                            <div class="form-group">
                                                <label for="edit-fname">ชื่อต้น</label>
                                                <input type="text" class="form-control" id="edit-fname" name="edit-fname" placeholder="Enter your username.." >
                                            </div>                                     
                                        </div>
                                        <div class="col-6 col-sm-6 col-xl-6">
                                            <div class="form-group">
                                                <label for="edit-password">{{ __('staff_list.password') }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="edit-username" name="edit-password" placeholder="{{ __('staff_list.password') }}" >
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-password_set="edit-password" onclick="setRandomPassword(this)"><i class="fas fa-random mr-1"></i>{{ __('staff_list.random_code') }}</button>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="one-profile-edit-username">ชื่อท้าย</label>
                                                <input type="text" class="form-control" id="one-profile-edit-username" name="one-profile-edit-username" placeholder="Enter your username.." >
                                            </div>            
                                        </div>
                                        <div class="col-12 col-sm-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="one-profile-edit-username">อีเมล์</label>
                                                <input type="text" class="form-control" id="one-profile-edit-username" name="one-profile-edit-username" placeholder="Enter your username.." >
                                            </div>      
                                            <div class="form-group">
                                                <label for="one-profile-edit-username">แผนก</label>
                                                <input type="text" class="form-control" id="one-profile-edit-username" name="one-profile-edit-username" placeholder="Enter your username.." >
                                            </div>                                 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-group">
                                        <label>รูปภาพของคุณ</label>
                                        <div class="push text-center">
                                            <img class="img-avatar img-avatar96" src="#" alt="">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input js-custom-file-input-enabled" data-toggle="custom-file-input" id="one-profile-edit-avatar" name="one-profile-edit-avatar">
                                            <label class="custom-file-label" for="one-profile-edit-avatar" data-browse="เลือก"><i class="fas fa-image mr-1"></i>เลือกรูปภาพของคุณใหม่</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="one-profile-edit-email">เปลี่ยนภาษา</label>
                                        <input type="text" class="form-control" id="one-profile-edit-email" name="one-profile-edit-email" placeholder="Enter your email.." >
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-xl-12 mb-2 mt-2">
                                    <div class="text-center">
                                        <button class="btn btn-sm btn-success"><i class="fas fa-save mr-1"></i>{{ __('general.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        <!-- End Content -->
        @include('../component.footer')
        </div>
        <!-- APP JS -->
        @include('component.app_js')
        <!-- Page JS -->
    </body>
</html>