
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <style>
        /* fallback */
            @font-face {
                font-family: 'Material Icons';
                font-style: normal;
                font-weight: 400;
                src: url({{ asset('adminbsb/2fcrYFNaTjcS6g4U3t-Y5ZjZjT5FdEJ140U2DJYC3mY.woff2') }}) format('woff2');
            }

            .material-icons {
                font-family: 'Material Icons';
                font-weight: normal;
                font-style: normal;
                font-size: 24px;
                line-height: 1;
                letter-spacing: normal;
                text-transform: none;
                display: inline-block;
                white-space: nowrap;
                word-wrap: normal;
                direction: ltr;
                -moz-font-feature-settings: 'liga';
                -moz-osx-font-smoothing: grayscale;
            }
        </style>

        <!-- Bootstrap Core Css -->
        <link href="{{ asset('adminbsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ asset('adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ asset('adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="{{ asset('adminbsb/css/style.css') }}" rel="stylesheet">
        
        @if(isset($css_script))
            @foreach($css_script as $cssdatascript )
                <link href="{{ asset($cssdatascript) }}">
            @endforeach
        @endif

        @if(isset($css))
            @foreach($css as $cssdata )
        <link href="{{ asset('css/pages/'.$cssdata.'.css') }}">
            @endforeach
        @endif

