<div>
    <style>
    .form-visus{
        background-color:#fff;
        color:black;

        padding-left:7px !important;
    }
    .receipt{
        background-color:#fff7d4;
        text-align:center;
    }
    #table-wrapper {
        position:relative;
    }
    #table-scroll {
        height:280px;
        overflow-y: hidden;    /* Trigger vertical scroll    */
        overflow-x: auto;
        margin-top:20px;
    }
    #table-wrapper table {
        width:100%;
    }

    .header-row, .header-column, .header-middle {
        background-color: #c1f8ff;
        color:#868686;
    }

    #table-wrapper table thead th .text {
        position:absolute;   
        top:-20px;
        z-index:2;
        height:20px;
        width:35%;
        border:1px solid red;
    }
    #glasses-table tbody tr:hover{
        background-color: #7ebbff;   
    }         
    .modal-kacamata-div{
        color: #878383;   
    }         
    </style>
    
    <div class="row clearfix modal-kacamata-div">
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input readonly type="text" {{ $disabled }} class="form-control form-visus" id="queue" value="{{ isset($cd_bkp)? $cd_bkp : '' }}">
                        <input id="bypass" type="hidden" value="{{ Request::segment(4) }}"/>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" style="text-align:center;">
                <div>
                    <input {{ $disabled }} class="radio-col-deep-orange" id="tipe1"  name="group1" type="radio" {{ (isset($result['glasses']->tipe)? ($result['glasses']->tipe == 'BIFOKUS')?  " checked "  : "" :  "") }}>
                    <label for="tipe1"><b>Kacamata Bifokus</b></label>
                </div>
            </div>
            <div class="col-sm-6" style="text-align:center;">
                <div>
                    <input {{ $disabled }}  class="radio-col-deep-orange" name="group1" id="tipe2" type="radio" {{ (isset($result['glasses']->tipe)? ($result['glasses']->tipe == 'NORMAL')?  " checked "  : "" :  "") }}>
                    <label for="tipe2"><b>Kacamata Biasa</b></label>
                </div>
            </div>
            <div class="col-sm-12">
                <div id="table-scroll">
                    <div id="table-wrapper">
                        <table class="table table-bordered table-hover" id="glasses-table">
                            <thead>
                                <tr>
                                    <th align="center" class="header-middle" style="width:500px !important;padding:5px;"><div style="width:100px"></div></th>
                                    @foreach($result['header'] as $col1)
                                        <th align="center" class="header-column" style="text-align:center;width:500px !important;padding-top:10px;padding-bottom:10px;padding-left:5px;padding-right:5px;vertical-align:middle;">
                                            <div  style="width:90px">
                                                <b> {{$col1->header}} </b>
                                            </div>
                                        </th>
                                    @endforeach
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['sider'] as $col2)
                                <tr>
                                    <td align="center" class="header-row" style="width:500px !important;padding:5px;"><b>{{$col2->sider}}</b></td>
                                    @foreach($result['header'] as $col1)
                                    <td>
                                        <input  {{ $disabled }}  class="form-control receipt" style="width:70px;height:auto" name="KACAMATA[{{$col2->code_sider}}][{{$col1->code_header}}]" value="<?= isset($result['glasses_receipt'][$col2->code_sider][$col1->code_header])? $result['glasses_receipt'][$col2->code_sider][$col1->code_header] : ''; ?>"
                                            type="text">
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3" style="padding-top:40px">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="pro_data" value="{{ isset($result['glasses']->pro)? $result['glasses']->pro : '' }}">
                        <label class="form-label" style="padding-left:5px" >Pro</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3" style="padding-top:40px">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-visus" id="tahun_data" value="{{ isset($result['glasses']->tahun)? $result['glasses']->tahun : '' }}">
                        <label class="form-label" style="padding-left:5px">Tahun</label>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3 " style="padding-top:50px">
                <div>
                    <input disabled id="tagihan" class="filled-in chk-col-teal"  type="checkbox" {{ (isset($billed)? ($billed > 0)?  " checked "  : "" : "") }} />

                    <label for="tagihan" id="tagihan-label" style="color:black">Masukkan ke tagihan <b>({{ $billed }})</b> </label>
                </div>
            </div>
            <div class="col-sm-3" style="padding-top:50px">
                <div>
                    <input {{ $disabled }} id="selesai" class="filled-in chk-col-teal" type="checkbox" {{ (isset($result['glasses']->is_done)? ($result['glasses']->is_done == 'Y')?  " checked "  : "" :  "") }}>
                    <label for="selesai">Sudah Selesai</label>
                </div>
            </div>
        </div>
        @if(!empty($disabled))
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12 ">
                    <p style="text-align:center"><i>*Data pasien yang sudah selesai tidak dapat dirubah kembali. Apabila ada perubahan hubungi operator.</i></p>
                </div>
            </div>
        @endif
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));
        var asd = null;
        var disabled = '{{ $disabled }}';
        $("#tagihan-label").popover({
            placement: 'top',
            container: '#largeModal',
            html: true,
            content: function () {
                $.ajax({
                    url: $('.mainurl').val() +'/getListPrice/GLASSES/'+$('#queue').val()+'/'+ disabled ,
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
    #glasses-table th, #glasses-table td{
        border:2px #c6c6c6 solid !important;
    }
    #glasses-table tr{
        background-color:aliceblue;
    }
    </style>