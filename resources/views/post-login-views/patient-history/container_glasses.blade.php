@if(isset($result['glasses']))
    <style>
    .form-visus{
        background-color:#fff7d4;
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


    #table-wrapper table thead th .text {
        position:absolute;   
        top:-20px;
        z-index:2;
        height:20px;
        width:35%;
        border:1px solid red;
    }
    #glasses-table-data tbody tr:hover{
        background-color: #7ebbff;   
    }         
    .modal-kacamata-div{
        color: #878383;   
    }         
    </style>
<div class="row clearfix ">

            <div class="col-sm-12 button-edit-bypass" style="padding-top:20px">
            
                <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class="entry-kacamata btn btn-primary waves-effect untouch-column">Edit Kacamata</button>
            </div>
        <div class="col-sm-12" style="padding-top:20px">
        <input id="cd_kacamata" type="hidden" value="{{ isset($result['glasses']->tipe)? $result['glasses']->code_queue_visus_glasses : '' }}"/>
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input disabled readonly type="text"  class="form-control form-visus" value="{{ '' }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-6" style="text-align:center;">
                <div>
                    <input disabled  class="radio-col-deep-orange" type="radio" {{ (isset($result['glasses']->tipe)? ($result['glasses']->tipe == 'BIFOKUS')?  " checked "  : "" :  "") }}>
                    <label for="tipe1"><b>Kacamata Bifokus</b></label>
                </div>
            </div>
            <div class="col-sm-6" style="text-align:center;">
                <div>
                    <input disabled   class="radio-col-deep-orange" type="radio" {{ (isset($result['glasses']->tipe)? ($result['glasses']->tipe == 'NORMAL')?  " checked "  : "" :  "") }}>
                    <label for="tipe2"><b>Kacamata Biasa</b></label>
                </div>
            </div>
            <div class="col-sm-12">
                <div id="table-scroll">
                    <div id="table-wrapper">
                        <table class="table table-bordered table-hover" id="glasses-table-data">
                            <thead>
                                <tr>
                                    <th align="center" class="bg-light-blue" style="width:500px !important;padding:5px;"><div style="width:100px"></div></th>
                                    @foreach($result['header'] as $col1)
                                        <th align="center" class="bg-light-blue" style="text-align:center;width:500px !important;padding-top:10px;padding-bottom:10px;padding-left:5px;padding-right:5px;vertical-align:middle;">
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
                                    <td align="center" class="bg-light-blue" style="width:500px !important;padding:5px;"><b>{{$col2->sider}}</b></td>
                                    @foreach($result['header'] as $col1)
                                    <td>
                                        <input disabled    class="form-control receipt" style="" name="KACAMATA[{{$col2->code_sider}}][{{$col1->code_header}}]" value="<?= isset($result['glasses_receipt'][$col2->code_sider][$col1->code_header])? $result['glasses_receipt'][$col2->code_sider][$col1->code_header] : ''; ?>"
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
                    <div class="form-line">
                        <label class="form-label" style="padding-left:5px" >Pro</label>
                        <input disabled type="text"  class="form-control form-visus" value="{{ isset($result['glasses']->pro)? $result['glasses']->pro : '' }}">
                    </div>
            </div>
            <div class="col-sm-3" style="padding-top:40px">
                    <div class="form-line">
                        <label class="form-label" style="padding-left:5px">Tahun</label>
                        <input disabled type="text"  class="form-control form-visus" value="{{ isset($result['glasses']->tahun)? $result['glasses']->tahun : '' }}">
                    </div>
            </div>
            
            <div class="col-sm-3 " style="padding-top:50px">
                <div>
                    <input disabled class="filled-in chk-col-teal"  type="checkbox" {{ (isset($result['glasses']->is_billed)? ($result['glasses']->is_billed == 'Y')?  " checked "  : "" : " checked ") }}>
                    <label for="tagihan">Tagihan</label>
                </div>
            </div>
            <div class="col-sm-3" style="padding-top:50px">
                <div>
                    <input disabled class="filled-in chk-col-teal" type="checkbox" {{ (isset($result['glasses']->is_done)? ($result['glasses']->is_done == 'Y')?  " checked "  : "" :  "") }}>
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

<script>
    if($(location).attr('href').split("/").splice(3, 5).join("/") != 'konsultasi'){
        $('.button-edit-bypass').remove();
    }
</script>
@else
<div class="col-sm-12" style="text-align:center;padding-top:20px"><i>Data kacamata pada pasien dan tanggal booking ini tidak tersedia</i></div>
@endif
