<!DOCTYPE html>
<html>

    <head>

        @include('layouts.post-login-layout.meta')

        <title>Klinik Mata Utama Tangerang Selatan</title>

        <link rel="icon" href="favicon.ico" type="image/x-icon">

        @include('layouts.post-login-layout.header')

    </head>

    <body class="theme-teal">
        <input type="hidden" id="mainurl-A543FD876YGhJY746392GUYXydsX" class="mainurl" value="{{URL::to('/')}}"/>
        @include('layouts.post-login-layout.background-process')

        @include('layouts.post-login-layout.navbar')

        @include('layouts.post-login-layout.sidebar')

        @yield('content')
        

        @include('layouts.post-login-layout.footer')
        </br>
        </br>
        <!-- <footer class="" style="background-color:white; padding:15px 15px 15px 15px; text-align:right;border-top:1px solid #eee;">
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">Rajonet Indonesia</a>.
                </div>
                <!--<div class="version">
                    <b>Version: </b> 1.0.5
                </div>-->
            </div>
        </footer> 
    </body>

</html>