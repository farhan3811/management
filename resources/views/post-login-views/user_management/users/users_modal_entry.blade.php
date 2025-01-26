<div id="entry_users">
    <style>
    .form-normal{
        background-color:#35a0ff;
        color:white;
        font-size:20px;
    }
    </style>
<form>
    <div class="row clearfix">
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input readonly type="text" {{ $disabled }} class="form-control form-normal" id="cd" value="{{ isset($cd)? $cd : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="email" {{ $disabled }} class="form-control form-normal" id="email_data" value="{{ isset($result->email)? $result->email : '' }}">
                        <label class="form-label" style="color:white">Email</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="username_data" value="{{ isset($result->username)? $result->username : '' }}">
                        <label class="form-label" style="color:white">Username</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" {{ $disabled }} class="form-control form-normal" id="password_data" value="{{ isset($result->password)? $result->password : '' }}">
                        <label class="form-label" style="color:white">Password</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group form-float">
                <label class="form-label">Level User</label>
                    <select {{ $disabled }} id="roles" style="background-color:#45c3d8" class="form-control show-tick" data-live-search="true" style="background-color:aliceblue;color:white" >
                        <option></option>
                        @foreach($unit as $data)
                        <option value="{{ $data->id }}" {{ isset($result->display_name)? ($data->id == $result->role_id)? ' selected ' : '' : '' }} >{{ $data->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="nik_data" value="{{ isset($result->nik)? $result->nik : '' }}">
                        <label class="form-label" style="color:white">NIK</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_data" value="{{ isset($result->nama)? $result->nama : '' }}">
                        <label class="form-label" style="color:white">Nama</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="gender_data" value="{{ isset($result->gender)? $result->gender : '' }}">
                        <label class="form-label" style="color:white">Jenis Kelamin</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="telepon_data" value="{{ isset($result->telepon)? $result->telepon : '' }}">
                        <label class="form-label" style="color:white">Telepon</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="handphone_data" value="{{ isset($result->handphone)? $result->handphone : '' }}">
                        <label class="form-label" style="color:white">Handphone</label>
                    </div>
                </div>
            </div>
        </div>
        
        @if($type == 'dt')
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->created_at)? $result->created_at : '' }}">
                            <label class="form-label" style="color:white">Dibuat Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->created_by)? $result->created_by : '' }}">
                            <label class="form-label" style="color:white">Dibuat Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->updated_at)? $result->updated_at : '' }}">
                            <label class="form-label" style="color:white">Diubah Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->updated_by)? $result->updated_by : '' }}">
                            <label class="form-label" style="color:white">Diubah Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->deleted_at)? $result->deleted_at : '' }}">
                            <label class="form-label" style="color:white">Dihapus Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->deleted_by)? $result->deleted_by : '' }}">
                            <label class="form-label" style="color:white">Dihapus Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));
    });
</script>
<style>
    #entry_medicine .bootstrap-select{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .dropdown-toggle{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .filter-option{
        color:white;
        padding-top:5px
    }
</style>