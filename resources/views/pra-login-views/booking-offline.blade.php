@extends('layouts.pra-login')

@section('content')
    <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);" style="color:#ff6300;"><b>KLINIK MATA UTAMA</b></a>
            <div style="width:100%;color:#088109 !important;text-align:center"><b>T A N G E R A N G &nbsp;&nbsp; S E L A T A N</b></div>
        </div>
    </div>
    <div style="width:800px;position:relative;left:-220px;text-align:center">
        <div class="alert" id="msg-view" style="display:none">            
            <i class="material-icons" style="font-size: 30px;padding-right:5px;float:left;top:-5px;position:relative">info</i><p id="msg-det" style="text-align: center;"></p>
        </div>
        @if ($message = Session::get('message'))
            <div class="alert @if(strpos($message, 'Berhasil') !== false) {{ 'alert-info' }} @else {{ 'alert-danger' }} @endif alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
    </div>
    <div class="fp-box">
        <div class="card" style="background-color:#fff0">
            <div class="body">
                <div class="msg">
                    Masukkan <b><span style="color:blue">identitas</span></b> anda apabila sudah terdaftar
                    </br>
                        <div style="padding-top:10px"><b>Pilih salah satu data identitas dibawah ini :</b></div>
                </div>
                <div class="form-group">
                    <input value="id_rekam_medis" name="identity" id="id_rekam_medis" class="with-gap identity-booking-offline" type="radio" checked autocomplete="off">
                    <label for="id_rekam_medis" >ID Rekam Medis</label>

                    <input value="nik" name="identity" id="nik" class="with-gap identity-booking-offline" type="radio">
                    <label for="nik" class="m-l-20" autocomplete="off">KTP</label>

                    <input value="no_asuransi" name="identity" id="no_asuransi" class="with-gap identity-booking-offline" type="radio">
                    <label for="no_asuransi" class="m-l-20" autocomplete="off">BPJS</label>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">account_circle</i>
                    </span>
                    <div class="form-line">
                        <input id="input-identity" type="text" class="form-control" name="email" placeholder="ID Rekam Medis" required autofocus autocomplete="off">
                    </div>
                </div>
                        <span class="help-block pull-right" style="display:none;top:-20px;position:relative">
                            <strong>Data inputan harus diisi</strong>
                        </span> 
                
                <button class="btn btn-block btn-lg bg-pink waves-effect" type="button" id="submit-queue">Daftar antrian</button>

                <div class="row m-t-20 m-b--5 align-center">
                    <a href="{{ url('/registration') }}">Belum pernah berobat? klik disini.</a>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    setTimeout(function(){ $('.alert').hide(); }, 6000);
</script>