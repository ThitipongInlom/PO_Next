<footer id="page-footer" class="bg-body-light">
    <div class="content py-3">
        <div class="row font-size-sm">
            <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-right">
                <strong>Version {{ env('APP_VERSION') }}</strong>
            </div>
            <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
                <strong>{{ env('APP_NAME') }} &copy; <span data-toggle="year-copy"></span></strong>
            </div>
        </div>
    </div>
</footer>
<script>
    window.translations = {!! Cache::get('translations') !!};
</script>