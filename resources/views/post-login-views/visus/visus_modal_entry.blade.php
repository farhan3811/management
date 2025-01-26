<div>
    <style>
    .form-visus{
        background-color:#fff !important;
        color:#000;
        padding-left:7px !important;
        border-radius: 3px !important;
        border:solid 1px #d2d2d2 !important;
    }
    .form-visus:disabled{
        background-color: #d1efab;;
    }
    .modal-body < .form-label{
        color:#7e98bf !important; 
    }
    </style>

    <div class="row clearfix">
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input readonly type="text" {{ $disabled }} class="form-control form-visus" id="queue" value="{{ isset($cd_bkp)? $cd_bkp : '' }}">
                        <input id="bypass" type="hidden" value="{{ Request::segment(4) }}"/>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="visus_mata_kiri_data" value="{{ isset($result->visus_mata_kiri)? $result->visus_mata_kiri : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Visus Mata Kiri</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="visus_mata_kanan_data" value="{{ isset($result->visus_mata_kanan)? $result->visus_mata_kanan : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Visus Mata Kanan</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="segment_anterior_data" value="{{ isset($result->segment_anterior)? $result->segment_anterior : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Segment Anterior</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="segment_posterior_data" value="{{ isset($result->segment_posterior)? $result->segment_posterior : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Segment Posterior</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="penglihatan_warna_data" value="{{ isset($result->penglihatan_warna)? $result->penglihatan_warna : '' }}">
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Penglihatan Warna</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <textarea rows="5" {{ $disabled }}  id="keterangan_data" class="form-visus form-control no-resize auto-growth" style="overflow: hidden; overflow-wrap: break-word;">{{ isset($result->keterangan)? $result->keterangan : '' }}</textarea>
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Keterangan</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <textarea rows="5" {{ $disabled }}  id="saran_data" class="form-visus form-control no-resize auto-growth" style="overflow: hidden; overflow-wrap: break-word;">{{ isset($result->saran)? $result->saran : '' }}</textarea>
                        <label class="form-label" style="color:#7d800d;padding-left:5px">Saran</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-4 ">
                <div style="padding-left:100px">
                    <input  {{ $disabled }} id="kacamata" class="filled-in chk-col-teal"  type="checkbox" {{ (isset($result->is_glasses_direct_from_visus)? ($result->is_glasses_direct_from_visus == 'Y')?  " checked "  : "" : "") }}>
                    <label for="kacamata" style="color:black">Kacamata</label>
                </div>
            </div>
            <div class="col-sm-4 ">
                <div style="padding-left:30px">
                    <input {{ (isset($billed)? ($billed > 0)?  " checked "  : "" : "") }} disabled id="tagihan" class="filled-in chk-col-teal"  type="checkbox" >
                    <label for="tagihan" id="tagihan-label" style="color:black">Jasa dan Pembayaran <b>({{ $billed }})</b> </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <input {{ $disabled }} {{ $bypass? ' disabled ' : '' }} id="selesai" class="filled-in chk-col-teal" type="checkbox" {{ (isset($result->is_done)? ($result->is_done == 'Y')?  " checked "  : "" :  "") }}>
                    <label for="selesai" style="color:black">Sudah Selesai</label>
                </div>
            </div>
        </div>
        @if(!empty($disabled))
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12 ">
                    <p style="text-align:center;color:#848484"><i>*Data pasien yang sudah selesai tidak dapat dirubah kembali. Apabila ada perubahan hubungi operator.</i></p>
                </div>
            </div>
        @endif
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));

        var result = null;
        var disabled = '{{ $disabled }}';
        $("#tagihan-label").popover({
            placement: 'top',
            container: '#largeModal',
            html: true,
            content: function () {
                $.ajax({
                    url: $('.mainurl').val() +'/getListPrice/VISUS/'+$('#queue').val()+'/'+ disabled ,
                    type: "get",
                    cache: false,
                    async: false,
                    success:function(data)
                    {
                        result = data;
               
                    },
                });
                return result;
                
            }
        }).on("show.bs.popover", function(){ $(this).data("bs.popover").tip().css("max-width", "600px"); });   


        $(".modal").on("hide.bs.modal", function(event) {
            $('.popover').popover('destroy');
        });
    });
</script>
<style>

.popover-content {
    color: red;
    height: 300px;
}</style>