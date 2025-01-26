<div id="entry_medicine">
    <style>

.form-normal{
    background-color:#fff7d4;
    color:#7d5214;
    text-transform: capitalize;
    padding-left:7px !important;
    border-radius: 3px !important;
    border:solid 1px #d2d2d2 !important;
}
    </style>

    <div class="row clearfix" style="border:2px dotted white;padding:30px;background-color:#f3fbf4">
    <input readonly id="cd_con" class="form-control" value="{{ $cd_bkp }}" type="hidden" />
        @foreach($result as $data)
            @foreach($data->toConsultReqlabDetStateY as $data2)
                <div class="col-sm-12" style="padding-top:5px">
                    <label class="form-label" style="color:#717171">Pemeriksaan {{ $data2->toLab->detail_lab}}</label>
                    <div class="col-sm-12" style="padding-top:20px">
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name ="cd_val[{{ $data2->id }}]" type="text" {{ $disabled }} class="form-control form-normal value-reqlab" value="{{ isset($data2->value)? $data2->value : '' }}">
                                    <label class="form-label" style="color:#7d800d;padding-left:5px">Value</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name ="cd_state[{{ $data2->id }}]" type="text" {{ $disabled }} class="form-control form-normal state-reqlab" value="{{ isset($data2->positif_or_negatif)? $data2->positif_or_negatif : '' }}">
                                    <label class="form-label" style="color:#7d800d;padding-left:5px">Positif/Negatif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-6 ">
                <div style="padding-left:180px">
                    <input {{ (isset($billed)? ($billed > 0)?  " checked "  : "" : "") }} disabled id="tagihan" class="filled-in chk-col-teal"  type="checkbox" />
                    <label for="tagihan" id="tagihan-label" style="color:black">Masukkan ke tagihan <b>({{ $billed }})</b> </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div style="padding-left:100px">
                    <input {{ $disabled }} id="selesai" class="filled-in chk-col-teal" type="checkbox" {{ (isset($data->is_done)? ($data->is_done == 'Y')?  " checked "  : "" :  "") }}>
                    <label for="selesai" style="color:black">Sudah Selesai</label>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));var asd = null;
        var disabled = '{{ $disabled }}';
        $("#tagihan-label").popover({
            placement: 'top',
            container: '#largeModal',
            html: true,
            content: function () {
                $.ajax({
                    url: $('.mainurl').val() +'/getListPrice/REQLAB/'+$('#cd_con').val()+'/'+ disabled ,
                    type: "get",
                    cache: false,
                    async: false,
                    success:function(data)
                    {
                        asd = data;
               
                    },
                });
                return asd;
                
            }
        }).on("show.bs.popover", function(){ $(this).data("bs.popover").tip().css("max-width", "600px"); });   


        $(".modal").on("hide.bs.modal", function(event) {
            $('.popover').popover('destroy');
        });
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