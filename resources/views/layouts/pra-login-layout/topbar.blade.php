<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='author' content='Dani Gunawan, danigunawan.elektroug@gmail.com'>
    <link rel="shortcut icon" href="{{ asset('img/faviconkmu.ico')}}" type="image/x-icon" />
    <title >PENDAFTARAN PASIEN BARU | KMU</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('step-form/plugins/jquery-2.1.4.min.js') }}"></script>

    <!-- bootstrap for better look example, but not necessary -->
    <link rel="stylesheet" href="{{ asset('step-form/plugins/bootstrap/css/bootstrap.min.css') }}" type="text/css" media="screen, projection">

    <!-- Step Form Wizard plugin -->
    <link rel="stylesheet" href="{{ asset('step-form/step-form-wizard/css/step-form-wizard-all.css') }}" type="text/css" media="screen, projection">
    <script src="{{ asset('step-form/step-form-wizard/js/step-form-wizard.js') }}"></script>

    <!-- nicer scroll in steps -->
    <link rel="stylesheet" href="{{ asset('step-form/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <script src="{{ asset('step-form/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- validation library http://jqueryvalidation.org/ -->
    <script src="{{ asset('step-form/plugins/jquery-validation/jquery.validate.min.js')}}"></script>

    <!-- validation library http://parsleyjs.org/ -->
    <link rel="stylesheet" href="{{ asset('step-form/plugins/parsley/parsley.css')}}" type="text/css" media="screen, projection">
    <script src="{{ asset('step-form/plugins/parsley/parsley.min.js')}}"></script>

    <!-- DATE PICKER KLINIK -->
    <link href="{{asset('vendors/bower_components/datepicker/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendors/bower_components/datepicker/datepicker.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Datetimepicker CSS -->
    <link href="{{asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Touchspin CSS -->
    <link href="{{asset('vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet"
        type="text/css" />

    <!-- Bootstrap Touchspin CSS -->
    <link href="{{asset('vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css')}}" rel="stylesheet"
        type="text/css" />


    <!-- select2 CSS -->
    <link href="{{asset('vendors/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />


    <style>
        .sf-t2 .sf-nav-number {
            font-size: 45px
        }
    </style>

    <script>
        var sfw;
        if($(location).attr('href').split('/')[3] == 'booking'){
            var start = 3;
        }else{
            var start = 0;
        }

        $(document).ready(function () {
            sfw = $("#wizard_example").stepFormWizard({
                startStep: start,
                showNav: 'top',
                theme: 'sky' // sea, sky, simple, circle, sun
            });

        })
        $(window).load(function () {
            /* only if you want use mcustom scrollbar */
            $(".sf-step").mCustomScrollbar({
                theme: "dark-3",
                scrollButtons: {
                    enable: true
                }
            });
        });
    </script>

    <style>
        pre {
            margin: 45px 0 60px;
        }

        h2 {
            margin: 60px 0 30px 0;
        }

        p {
            margin-bottom: 10px;
        }
    </style>

</head>

<body  style="
	background-image: url('img/login-bg.jpg');top:-40px">
    <div id="app">

        <nav class="navbar navbar-default navbar-static-top" style="background-color:#ff5100">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" style="padding-top:15px">
                        <img src="/" alt="Klinik Mata Utama Tangerang Selatan" image_download_for_instagram="true" style="float:left">
                        <h4  style="padding-left:15px;color:white;margin-top:1px;float:left"> -  Pendaftaran Pasien Baru</h4>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <?php /* <li><a href="{{ url('login') }}">Login</a></li>
                                <li><a href="{{ url('front_daftarpasien') }}">Register</a></li>*/?>
                            <li>
                                <a href="{{url('/')}}">
                                <i class="fa fa-arrow-left"></i> Kembali Ke Booking Antrian
                                </a>
                            </li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                     <i class="fa fa-user"></i>  {{ Auth::user()->username }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @if (Auth::user()) 
                                    @if (Auth::user()->roles()->get(array('name'))->first()->name == 'admin')
                                        <li><a href="{{ url('admin') }}"><i class="fa fa-user"></i> Ke Menu Admin</a></li>
                                        <li><a href="{{ url('touchscreen') }}"><i class="fa fa-television"></i> Interactive Screen</a></li>
                                        <li><a href="{{ url('logoutadmin') }}"><i class="fa fa-sign-out"></i> Keluar</a></li>
                                    @elseif (Auth::user()->roles()->get(array('name'))->first()->name == 'dokter')
                                        <li><a href="{{ url('dokter') }}"><i class="fa fa-user"></i> Ke Menu Dokter</a></li>
                                        <li><a href="{{ url('logoutdokter') }}"><i class="fa fa-user"></i> Keluar</a></li>
                                    @elseif (Auth::user()->roles()->get(array('name'))->first()->name == 'pasien')
                                        <li><a href="{{ url('pendaftaran_poli') }}"><i class="fa fa-user"></i> Pendaftaran Ke Poli</a></li>
                                        <li><a href="{{ url('antrian_pasien') }}"><i class="fa fa-user"></i> Antrian Pasien</a></li>
                                        <li><a href="{{ url('pasien') }}"><i class="fa fa-user"></i> Ke Menu Pasien</a></li>
                                        <li><a href="{{ url('logoutpasien') }}"><i class="fa fa-user"></i> Keluar</a></li>
                                    @elseif (Auth::user()->roles()->get(array('name'))->first()->name == 'operator')
                                        <li><a href="{{ url('operator') }}"><i class="fa fa-user"></i> Ke Menu Operator</a></li>
                                        <li><a href="{{ url('logoutoperator') }}"><i class="fa fa-user"></i> Keluar</a></li>
                                    @elseif (Auth::user()->roles()->get(array('name'))->first()->name == 'kasir')
                                        <li><a href="{{ url('kasir') }}"><i class="fa fa-user"></i> Ke Menu Kasir</a></li>
                                        <li><a href="{{ url('logoutkasir') }}"><i class="fa fa-user"></i> Keluar</a></li>
                                    @else 
                                        Anda Belum Login 
                                    @endif 
                                @endif
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="site-index">

                @yield('content')

            </div>
        </div>

    </div>
</body>

</html>




<!-- JavaScript -->
<!-- Get Wilayah -->
<!-- basic scripts -->
<script src="{{asset('js/getwilayah_pasien.js')}}"></script>


<!-- jQuery -->
<!--<script src="{{asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>-->

<script src="{{asset('vendors/bower_components/moment/min/moment.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<!-- Bootstrap Touchspin -->
<script src="{{asset('vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>

<!-- Bootstrap Switch-->
<script src="{{asset('vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.js')}}"></script>
<script src="{{asset('vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js')}}"></script>


<script src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/bootstrap-validator/dist/validator.min.js')}}"></script>


<!-- Select2 JavaScript -->
<script src="{{asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<!-- Bootstrap Select JavaScript -->
<script src="{{asset('vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>


<!-- Multiselect JavaScript -->
<script src="{{asset('vendors/bower_components/multiselect/js/jquery.multi-select.js')}}"></script>



<!-- Bootstrap Datetimepicker JavaScript -->
<script type="text/javascript" src="{{asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

<!-- Form Advance Init JavaScript -->
<script src="{{asset('js/form-advance-data.js')}}"></script>

<!-- DATEPICKER  JS -->
{{-- {{ Html::script('bsbmd/plugins/momentjs/moment.js')}} --}}
<script src="{{asset('vendors/bower_components/datepicker/bootstrap-datepicker.js')}}"></script>

<!-- Function Datepicker -->
<script>
    $(function () {
        $(".datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker();
    });
</script>