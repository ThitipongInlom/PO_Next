<!DOCTYPE html>
<html dir="ltr" lang="th">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | {{ __('menu.login') }}</title>
        @include('component.app_css')
    </head>

    <body>
        <div id="page-container">
            <main id="main-container">
                <div class="bg-image" style="background-image: url('{{ $urlImageBackgroundIogin }}');">
                    <div class="row no-gutters bg-primary-dark-op">
                        <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                            <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                                <div class="w-100">
                                    <span class="font-w600 font-size-h2 text-white">{{ env('APP_NAME') }}</span>
                                    <p class="text-white-75 mr-xl-8 mt-2">
                                        {{ __('login.text_description') }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center font-size-sm">
                                <p class="font-w500 text-white-50 mb-0">
                                    <strong>{{ env('APP_NAME') }} V {{ env('APP_VERSION') }}</strong> &copy; <span data-toggle="year-copy"></span>
                                </p>
                                <ul class="list list-inline mb-0 py-2">
                                    <li class="list-inline-item">
                                        <a class="text-white-75 font-w500" href="javascript:void(0)">Legal</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-white-75 font-w500" href="javascript:void(0)">Contact</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-white-75 font-w500" href="javascript:void(0)">Terms</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-white">
                            <div class="p-3 w-100 d-lg-none text-center">
                                <span class="font-w600 font-size-h2 text-dark">{{ env('APP_NAME') }}</span>
                            </div>
                            <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                                <div class="w-100">
                                    <div class="text-center mb-5">
                                        <p class="mb-3">
                                            <i class="fa fa-2x fa-people-carry text-primary-light"></i>
                                        </p>
                                        <h1 class="font-w700 mb-2">
                                            {{ __('login.signin') }}
                                        </h1>
                                        <h2 class="font-size-base text-muted">
                                            {{ __('login.login_description') }}
                                        </h2>
                                    </div>
                                    <div class="row no-gutters justify-content-center">
                                        <div class="col-sm-8 col-xl-4">
                                            <form id="form-login" action="javascript:void(0)">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg form-control-alt py-4" id="username" name="username" placeholder="{{ __('login.username') }}" tabindex="1">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-lg form-control-alt py-4" id="password" name="password" placeholder="{{ __('login.password') }}" tabindex="2">
                                                </div>
                                                <div class="form-group d-flex justify-content-between align-items-center">
                                                    <button type="submit" class="btn btn-lg btn-block btn-alt-primary" id="btnLogin">
                                                        <i class="fa fa-fw fa-sign-in-alt mr-1 opacity-50"></i> {{ __('login.signin') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between font-size-sm text-center text-sm-left">
                                <p class="font-w500 text-black-50 py-2 mb-0">
                                    <strong>{{ env('APP_NAME') }} V {{ env('APP_VERSION') }}</strong> &copy; <span data-toggle="year-copy"></span>
                                </p>
                                <ul class="list list-inline py-2 mb-0">
                                    <li class="list-inline-item">
                                        <a class="text-muted font-w500" href="javascript:void(0)">Legal</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted font-w500" href="javascript:void(0)">Contact</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted font-w500" href="javascript:void(0)">Terms</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script>
            // setup data
            window.translations = {!! Cache::get('translations') !!};
            // setup function
            function trans(key, replace = {}){
                let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);
                for (var placeholder in replace) {
                    translation = translation.replace(`:${placeholder}`, replace[placeholder]);
                }
                return translation;
            }
        </script>
        <!-- APP JS -->
        @include('component.app_js')
        <!-- Page JS -->
        <script type="text/javascript" src="{{ asset('js/auth/login.js?t='.time()) }}"></script>
    </body>
</html>