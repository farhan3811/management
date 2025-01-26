
    <!-- Jquery Core Js -->
    <script src="{{ asset('adminbsb/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/node-waves/waves.js') }}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-validation/jquery.validate.js') }}"></script>        

    <!-- Select Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('adminbsb/js/admin.js') }}"></script>
    <script src="{{ asset('adminbsb/js/pages/index.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('adminbsb/js/demo.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    
    
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <script src="{{ asset('adminbsb/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('adminbsb/js/pages/ui/tooltips-popovers.js') }}"></script>
    <!-- Autosize Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/autosize/autosize.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

    <!-- PAGES JS -->

    @if(isset($js_script))
        @foreach($js_script as $jsdatascript )
            <script src="{{ asset($jsdatascript) }}"></script>
        @endforeach
    @endif

    @if(isset($js))
        @foreach($js as $jsdata )
            @if($jsdata == 'visus')
                <!-- SOCKET IO JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
            @endif
            <script src="{{ asset('js/pages/'.$jsdata.'.js') }}"></script>
        @endforeach
    @endif