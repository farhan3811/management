<style>
    .form-consult{
        background-color:#fff7d4 !important;
        color:#7d5214 !important;
        text-transform: capitalize;
        padding-left:7px !important;
        border-radius: 3px !important;
        border:solid 1px #d2d2d2 !important;
    }
    .modal-body  .form-label{
        color:#7e98bf !important; 
    }
</style>

<div>
    <div class="row clearfix">
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input readonly type="text" {{ $disabled }} class="form-control form-consult" id="queue" value="{{ isset($cd_bkp)? $cd_bkp : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div id="info-kacamata" class="info-box waves-effect {{($result->is_glasses == 'Y')? ' bg-green ' : ''}} " style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_glasses == 'Y')? 'done' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>Kacamata</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"  style="text-align:center">125<div style="font-size:12px;line-height:8px"> Patient Today</div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="info-obat" class="info-box waves-effect {{($result->is_medicine == 'Y')? ' bg-green ' : ''}}" style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_medicine == 'Y')? ' done ' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>Obat</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"  style="text-align:center">125<div style="font-size:12px;line-height:8px"> Patient Today</div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="info-rujukan" class="info-box waves-effect {{($result->is_refer == 'Y')? ' bg-green ' : ''}}" style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_refer == 'Y')? ' done ' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>Rujukan</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"  style="text-align:center">125<div style="font-size:12px;line-height:8px"> Patient Today</div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="info-operasi" class="info-box waves-effect {{($result->is_operation == 'Y')? ' bg-amber ' : ''}}" style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_operation == 'Y')? ' event_available ' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>Operasi</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20" style="text-align:center">125<div style="font-size:12px;line-height:8px"> Patient Today</div></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-entry-consult">

        @if($result->is_medicine == 'Y')

            @include('post-login-views.consult.consult_entry_medicine')
            
        @endif

        @if($result->is_operation == 'Y')

            @include('post-login-views.consult.consult_entry_operation')

        @endif

            <div class="col-sm-12" style="padding-top:40px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <textarea rows="1" {{ $disabled }}  id="keterangan_data" class="form-consult form-control no-resize auto-growth" style="color:white;background-color:#0078ff;overflow: hidden; overflow-wrap: break-word; height: 32px;">{{ isset($result->desc)? $result->desc : '' }}</textarea>
                            <label class="form-label" style="color:white;padding-left:5px;">Keterangan</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-6 ">
                    <div style="padding-left:180px">
                        <input  {{ $disabled }} id="tagihan" class="filled-in chk-col-teal"  type="checkbox" {{ (isset($result->is_billed)? ($result->is_billed == 'Y')?  " checked "  : "" : " checked ") }}>
                        <label for="tagihan" class="form-label">Masukkan ke tagihan</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style="padding-left:100px">
                        <input {{ $disabled }} id="selesai" class="filled-in chk-col-teal" type="checkbox" {{ (isset($result->is_done)? ($result->is_done == 'Y')?  " checked "  : "" :  "") }}>
                        <label for="selesai" class="form-label">Sudah Selesai</label>
                    </div>
                </div>
            </div>
            @if(!empty($disabled))
                <div class="col-sm-12" style="padding-top:20px" id="disabled_state">
                    <div class="col-sm-12 ">
                        <p style="text-align:center"  class="form-label"><i>*Data pasien yang sudah selesai tidak dapat dirubah kembali. Apabila ada perubahan hubungi operator.</i></p>
                    </div>
                </div>
            @endif
            
        </div>

    </div>
</div>

<script>
var new_op = "<?= $result->is_operation ?>";
    $(function () {
        autosize($('textarea.auto-growth'));
    });
</script>

@if(isset($result->is_operation) or isset($result->is_medicine) )
    @if($result->is_operation != 'Y' and $result->is_medicine != 'Y')
        <script>
            setTimeout(function () { 
                $.AdminBSB.browser.activate();
                $.AdminBSB.leftSideBar.activate();
                $.AdminBSB.rightSideBar.activate();
                $.AdminBSB.navbar.activate();
                $.AdminBSB.dropdownMenu.activate();
                $.AdminBSB.input.activate();
                $.AdminBSB.select.activate();
                $.AdminBSB.search.activate();
                $('.page-loader-wrapper').fadeOut(); 
            }, 100);
        </script>
    @endif
@endif
