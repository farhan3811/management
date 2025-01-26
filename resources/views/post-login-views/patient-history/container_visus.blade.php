@if($results->count())
    @foreach($results as $data)
    <div class="row clearfix button-edit-bypass">
        <div class='col-sm-12' style="padding-top:20px">
            <button data-toggle="modal" data-target="#largeModal" style="margin-left:3px" class=" entry-visus btn btn-primary waves-effect untouch-column">Edit Visus</button>
        </div>
    </div>

        <div class="body table-responsive">
            <input id="cd_visus" type="hidden" value="{{ $data->code_queue_visus_normal }}"/>
            <table class="table table-hover table-condensed table-bordered">
                <tbody>
                        <tr>
                            <td style="width:50%;text-align:center" class="bg-light-blue"><span  ><b>Visus Mata Kanan</span></b></td>
                            <td style="width:50%;text-align:center" class="bg-light-blue"><span  ><b>Visus Mata Kiri</span></b></td>
                        </tr>
                        <tr>
                            <td style="width:50%;text-align:center">{{ $data->visus_mata_kanan }}</td>
                            <td style="width:50%;text-align:center">{{ $data->visus_mata_kiri }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-hover table-condensed table-striped-new">
                    <tbody>
                        <tr>
                            <td style="width:50%"><span class="pull-right"><b>Segment Anterior</span></b></td>
                            <td>{{ $data->segment_anterior }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span class="pull-right"><b>Segment Posterior</span></b></td>
                            <td>{{ $data->segment_posterior }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span  class="pull-right" ><b>Penglihatan Warna</span></b></td>
                            <td>{{ $data->penglihatan_warna }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span  class="pull-right" ><b>Keterangan</span></b></td>
                            <td>{{ $data->keterangan }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span  class="pull-right" ><b>Saran</span></b></td>
                            <td>{{ $data->saran }}</td>
                        </tr>
                        
                        
                </tbody>
            </table>
        </div>
        <div style="border:solid 1px #d7d7d7;background-color:#d5ffe1;padding:5px">
            <div class="body table-responsive">

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
                <dl class="dl-horizontal dl-small m-b-0">
                    <dt style="width:200px !important">Mulai Menggantri: </dt>
                    <dd> &nbsp; {{ isset($data->created_at)? date("g:i a", strtotime(substr($data->created_at, 10, 10))) : '-' }}</dd>
                </dl>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
                <dl class="dl-horizontal dl-small m-b-0">
                    <dt style="width:140px !important">Nomor Antrian Ke: </dt>
                    <dd> &nbsp; {{ isset($data->queue_no) ? $data->queue_no : '-'}}</dd>
                </dl>
            </div>
            <br />
            <br />
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= isset($data->is_called) ? ($data->is_called == 'Y') ?  ' <span style="color:green"><i class="material-icons" style="top:5px;position:relative">done</i> Sudah Dipanggil </span>' :  '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Belum Dipanggil</span> ' : '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Belum Dipanggil</span> ' ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= isset($data->is_skipped) ? ($data->is_skipped == 'Y') ?  ' <span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Dilewati</span>' :  ' <span style="color:green"><i class="material-icons" style="top:5px;position:relative">done</i> Tidak Dilewati</span>' : '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Diketahui</span> ' ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= isset($data->is_canceled) ? ($data->is_canceled == 'Y') ?  '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Dibatalkan</span>' :  '<span style="color:green"><i class="material-icons" style="top:5px;position:relative">done</i> Tidak Dibatalkan</span> ' : '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Diketahui</span>' ?>
            </div>

            <!-- -------------------------------------------------------------------------------- -->
            </div>
        </div>
        
    @endforeach
@else
    <div style="text-align:center"><i>Data hasil visus pasien tidak ditemukan/belum dilakukan pengisian.</i></div>
@endif
<script>
    if($(location).attr('href').split("/").splice(3, 5).join("/") != 'konsultasi'){
        $('.button-edit-bypass').remove();
    }
</script>