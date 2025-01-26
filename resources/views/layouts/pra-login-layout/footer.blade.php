
    <!-- Jquery Core Js -->
        <script src="{{ asset('adminbsb/plugins/jquery/jquery.min.js') }}"></script>

        <!-- Bootstrap Core Js -->
        <script src="{{ asset('adminbsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="{{ asset('adminbsb/plugins/node-waves/waves.js') }}"></script>

        <!-- Validation Plugin Js -->
        <script src="{{ asset('adminbsb/plugins/jquery-validation/jquery.validate.js') }}"></script>   

        <!-- Custom Js -->
        <script src="{{ asset('adminbsb/js/admin.js') }}"></script>
        <script src="{{ asset('adminbsb/js/pages/examples/forgot-password.js') }}"></script>

        @if(isset($js_script))
            @foreach($js_script as $jsdatascript )
                <script src="{{ asset($jsdatascript) }}"></script>
            @endforeach
        @endif

        @if(isset($js))
            @foreach($js as $jsdata )
                <script src="{{ asset('js/pages/'.$jsdata.'.js') }}"></script>
            @endforeach
        @endif

<style>

    .sf-nav-step{
        background-color:#009622 !important;
    }
</style>