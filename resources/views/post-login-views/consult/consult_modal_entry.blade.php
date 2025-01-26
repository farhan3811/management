<style>
    .form-consult{
        background-color:#fff !important;
        color:#000 !important;
        padding-left:7px !important;
        border-radius: 3px !important;
        border:solid 1px #d2d2d2 !important;
    }
    .modal-body  .form-label{
        color:#7e98bf !important; 
    }
</style>
<style>
    .side-tab{
        width:100%;background-color:#fff;color:#222 !important;padding:8px;margin:2px !important;
    }
    .side-tab.active{
        background-color: #009688;
    }
    .tab-pane.active{
        background-color:#7ED5CC;
    }
    .tab-pane{
        padding:30px 30px;border:solid 5px white;color:#00000080;
    }
    .info-box, .text{
        color:#555555b3;
    }
    .nav-tabs > li > a{
        color:#222 !important;
    }

    .nav-tabs > li.active > a{
        color:#fff !important;
        background-color: #009688;
    }

    .nav-tabs > li > a:before {
        border-bottom: 0px;
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
                        <div class="text" style="margin-top:0px"><b>{{ $today_summary->glasses }}</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"  style="text-align:center">Kacamata</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="info-obat" class="info-box waves-effect {{($result->is_medicine == 'Y')? ' bg-green ' : ''}}" style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_medicine == 'Y')? ' done ' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>{{ $today_summary->medicine }}</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"  style="text-align:center">Obat</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="info-rujukan" class="info-box waves-effect {{($result->is_refer == 'Y')? ' bg-green ' : ''}}" style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_refer == 'Y')? ' done ' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>{{ $today_summary->upload }}</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"  style="text-align:center">Upload Foto</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="info-operasi" class="info-box waves-effect {{($result->is_operation == 'Y')? ' bg-green ' : ''}}" style="cursor:pointer">
                    <div class="icon">
                        <i class="material-icons">{{($result->is_operation == 'Y')? ' event_available ' : ''}}</i>
                    </div>
                    <div class="content">
                        <div class="text" style="margin-top:0px"><b>{{ $today_summary->operation }}</b></div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20" style="text-align:center">Operasi</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12" style="padding:30px">
            <div class="container-entry-consult col-sm-12">

                <div class="row clearfix">
                    <!-- Nav tabs -->
                    <ul role="tablist" style="width:20%;float:left" class="nav nav-tabs">
                        <li id="konsultasi-li" class="side-tab active" role="presentation" style="width:100%" class="active">
                            <a href="#konsultasi" data-toggle="tab" aria-expanded="false" ><b>KONSULTASI</b></a>
                        </li>

                        <li role="presentation" class="side-tab" style="width:100%;display:{{ ($result->is_glasses == 'Y')? 'show' : 'none' }}" id="glasses-li">
                                <a href="#glasses" data-toggle="tab" aria-expanded="false"><b>KACAMATA</b></a>
                        </li>

                        <li role="presentation" class="side-tab " style="width:100%;display:{{ ($result->is_medicine == 'Y')? 'show' : 'none' }}" id="medicine-li">
                            <a href="#medicine" data-toggle="tab" aria-expanded="false"><b>OBAT-OBATAN</b></a>
                        </li>

                        <li class="side-tab" role="presentation" style="width:100%;display:{{ ($result->is_refer == 'Y')? 'show' : 'none' }}" id="upload-li">
                            <a href="#upload" data-toggle="tab" aria-expanded="true"><b>UPLOAD FOTO</b></a>
                        </li>

                        <li class="side-tab" role="presentation" style="width:100%;display:{{ ($result->is_operation == 'Y')? 'show' : 'none' }}" id="operation-li">
                            <a href="#operation" data-toggle="tab" aria-expanded="true"><b>OPERASI</b></a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" style="width:77%;float:right;padding:5px 0">
                        <div role="tabpanel" class="tab-pane fade active in" id="konsultasi">
                            <div >
                                <div class="form-group form-float">
                                    <label class="form-label" style="color:#4b4949 !important;padding-left:5px;">Isi Hasil Konsultasi</label>
                                    <div class="form-line">
                                        <textarea rows="1" {{ $disabled }}  id="keterangan_data" class="form-consult form-control no-resize auto-growth" style="color:white;background-color:#0078ff;overflow: hidden; overflow-wrap: break-word; height: 350px !important;">{{ isset($result->desc)? $result->desc : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane fade" id="glasses">
                            <b>Kacamata</b>
                            <p>
                                Silahkan masuk ke halaman kacamata
                            </p>
                        </div>

                        <div role="tabpanel" class="tab-pane fade in" id="medicine">
                            @if($result->is_medicine == 'Y')
                                @include('post-login-views.consult.consult_entry_medicine')
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="upload">
                            <b>Upload Foto</b>
                            <p>
                                Upload foto belum tersedia
                            </p>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="operation">
                            @if($result->is_operation == 'Y')
                                @include('post-login-views.consult.consult_entry_operation')
                            @endif
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-sm-12" style="padding-top:50px;border-top:solid 2px #00000017;margin-top:50px;">
                <div class="col-sm-6 ">
                    <div style="padding-left:180px">
                        <input {{ (isset($billed)? ($billed > 0)?  " checked "  : "" : "") }} disabled id="tagihan" class="filled-in chk-col-teal"  type="checkbox" ><label for="tagihan" id="tagihan-label" style="color:black">Masukkan ke tagihan <b>({{ $billed }})</b> </label>
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
        var asd = null;
        var disabled = '{{ $disabled }}';
        $("#tagihan-label").popover({
            placement: 'top',
            container: '#largeModal',
            html: true,
            content: function () {
                $.ajax({
                    url: $('.mainurl').val() +'/getListPrice/CONSULT/'+$('#queue').val()+'/'+ disabled ,
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
