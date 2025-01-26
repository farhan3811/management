<div id="entry_medicine">
    <style>
    .form-normal{
        background-color:#35a0ff;
        color:white;
        font-size:20px;
    }
    </style>

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
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="nama_obat_data" value="{{ isset($result->nama_obat)? $result->nama_obat : '' }}">
                        <label class="form-label" style="color:white">Nama Obat</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                <label class="form-label">Satuan Obat</label>
                    <select {{ $disabled }} id="satuan_jenis_data" style="background-color:#45c3d8" class="form-control show-tick" data-live-search="true" style="background-color:aliceblue;color:white" >
                        <option></option>
                        @foreach($unit as $data)
                        <option value="{{ $data->code_medicine_unit }}" {{ isset($result->code_medicine_unit)? ($data->code_medicine_unit == $result->code_medicine_unit)? ' selected ' : '' : '' }} >{{ $data->satuan }}</option>
                        @endforeach
                    </select>
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