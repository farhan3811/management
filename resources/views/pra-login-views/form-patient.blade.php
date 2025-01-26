@php $user = Auth::user(); @endphp

@extends('layouts.pra-login-layout.topbar') 

@section('content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('message'))
            <div class="alert @if(strpos($message, 'Berhasil') !== false) {{ 'alert-success' }} @else {{ 'alert-danger' }} @endif alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form autocomplete="off" id="wizard_example" role="form" method="POST" action="{{ route('bookingoffline.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('post') }}
                       
                @include('pra-login-views.registration')

                @if(Request::segment(1) == 'booking')

                    @include('pra-login-views.form-booking')
                    
                @endif
            </form>
        </div>
    </div>


</div>

<style>
    .site-index {
        margin-top: 10px;
    }

    .select2.select2-container.select2-container--default.select2-container--above {
        width: 100%;
    }

    .select2-selection{
        height: 33px !important
    }

</style>
@endsection