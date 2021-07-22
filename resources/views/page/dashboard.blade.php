<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | {{ __('menu.dashboard') }}</title>
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
                                    {{ __('menu.dashboard') }} 
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="row row-deck">

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