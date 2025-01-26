<div id="entry_medicine" class="">
    <style>
    .form-normal{
        background-color:#fff7d4;
        color:#7d5214;
        text-transform: capitalize;
        padding-left:7px !important;
        border-radius: 3px !important;
        border:solid 1px #d2d2d2 !important;
    }
    .form-normal:disabled{
        background-color: #d1efab;;
    }
    .modal-body < .form-label{
        color:#7e98bf !important; 
    }
    </style>

    <div class="row clearfix">
        <div class="col-sm-12" style="padding-top:20px">
            <!-- ============ hidden =========== -->
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input readonly type="hidden" {{ $disabled }} class="form-control form-normal" id="cd" value="{{ isset($cd)? $cd : '' }}">
                    </div>
                </div>
            </div>
            <!-- ============ hidden =========== -->


            <div class="col-sm-12">
                <div class="form-group form-float">

                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="service_name_data" value="{{ isset($result->service_name)? $result->service_name : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Nama Pelayanan (Service)</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <label class="form-label" style="color:#7d800d;padding-left:5px">Kategori Pelayanan</label>
                    <select {{ $disabled }} id="service_category_data" style="background-color:#45c3d8" class="form-control show-tick" data-live-search="true" style="background-color:aliceblue;color:white" >
                        <option></option>
                        <option {{ isset($result->service_category)? ($result->service_category == "VISUS")? " selected "  : '' : '' }} value="VISUS">PEMERIKSAAN</option>
                        <option {{ isset($result->service_category)? ($result->service_category == "CONSULT")? " selected "  : '' : '' }}  value="CONSULT">KONSULTASI DOKTER</option>
                        <option {{ isset($result->service_category)? ($result->service_category == "GLASSES")? " selected "  : '' : '' }}  value="GLASSES">KACAMATA</option>
                        <option {{ isset($result->service_category)? ($result->service_category == "REQLAB")? " selected "  : '' : '' }}  value="REQLAB">LABORATORIUM</option>
                        <option {{ isset($result->service_category)? ($result->service_category == "OPERATION")? " selected "  : '' : '' }}  value="OPERATION">OPERASI</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="service_subcategory_data" value="{{ isset($result->service_subcategory)? $result->service_subcategory : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Sub-Kategori Pelayanan</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="price_data" value="{{ isset($result->price)? $result->price : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Harga</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <label class="form-label" style="color:#7d800d;padding-left:5px">Bisa lebih dari satu?</label>
                    <select {{ $disabled }} id="is_multiple_data" style="background-color:#45c3d8" class="form-control show-tick" data-live-search="true" style="background-color:aliceblue;color:white" >
                        <option></option>
                        <option {{ isset($result->is_multiple)? ($result->is_multiple == "Y")? " selected "  : '' : '' }} value="Y">YA</option>
                        <option {{ isset($result->is_multiple)? ($result->is_multiple == "N")? " selected "  : '' : '' }} value="N">TIDAK</option>
                    </select>
                </div>
            </div>
        </div>

        @if($type == 'dt')
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="created_at_data" value="{{ isset($result->created_at)? $result->created_at : ' ' }}">
                            <label class="form-label" style="color:#7d800d;padding-left:5px">Dibuat Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="created_by_data" value="{{ isset($result->created_by)? $result->created_by : ' ' }}">
                            <label class="form-label" style="color:#7d800d;padding-left:5px">Dibuat Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="deleted_at_data" value="{{ isset($result->deleted_at)? $result->deleted_at : ' ' }}">
                            <label class="form-label" style="color:#7d800d;padding-left:5px">Dihapus Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="deleted_by_data" value="{{ isset($result->deleted_by)? $result->deleted_by : ' ' }}">
                            <label class="form-label" style="color:#7d800d;padding-left:5px">Dihapus Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        </div>
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
        padding-top:5px;
    }
    #entry_medicine  .dropdown-toggle{
        background-color:#279516 !important;
    }


</style>