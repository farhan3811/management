@foreach($results as $data)
    <div class="body table-responsive col-sm-12">
    <div class="col-sm-3"><b>Dokter</b></div>
    <div class="col-sm-1">:</div>
    <div class="col-sm-8">{{ $data->nama_dokter}}</div>
        <table class="table table-hover table-bordered">
                    <tr>
                        <th style="width:25%;text-align:center" class="bg-light-blue"><b>Kacamata</span></b></th>
                        <th style="width:25%;text-align:center" class="bg-light-blue"><b>Obat</span></b></th>
                        <th style="width:25%;text-align:center" class="bg-light-blue"><b>Rujukan</span></b></th>
                        <th style="width:25%;text-align:center" class="bg-light-blue"><b>Operasi</span></b></th>
                    </tr>
            <tbody>
                    <tr>
                        <td style="width:25%;text-align:center" >{{ $data->is_glasses == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                        <td style="width:25%;text-align:center" >{{ $data->is_medicine == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                        <td style="width:25%;text-align:center" >{{ $data->refer == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                        <td style="width:25%;text-align:center" >{{ $data->is_operation == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                    </tr>
            </tbody>
        </table>
    <div class="col-sm-3"><b>Keterangan Dokter</b></div>
    <div class="col-sm-9">:</div>
    <div class="col-sm-12">{{ $data->desc}}</div>
        <table class="table table-hover table-condensed table-striped-new">
            <tbody>
                <tr>
                    <td style="width:45%"><span  class="pull-right" ><b>Tanggal Dibuat</span></b></td>
                    <td>{{ date('l, d M Y', strtotime(substr($data->created_at, 0, 10))) }}</td>
                </tr>
                <tr>
                    <td style="width:45%"><span  class="pull-right" ><b>Waktu Dibuat</span></b></td>
                    <td>{{ date("g:i a", strtotime(substr($data->created_at, 10, 10)))}}</td>
                </tr>
                    <tr>
                        <td style="width:45%"><span  class="pull-right" ><b>Tanggal Dibuat</span></b></td>
                        <td>{{ date('l, d M Y', strtotime(substr($data->updated_at, 0, 10))) }}</td>
                    </tr>
                    <tr>
                        <td style="width:45%"><span  class="pull-right" ><b>Waktu Dibuat</span></b></td>
                        <td>{{ date("g:i a", strtotime(substr($data->updated_at, 10, 10)))}}</td>
                    </tr>
            </tbody>
        </table>
    </div>

    <div class="col-sm-12" style="border:solid 1px #d7d7d7;background-color:#d5ffe1;padding:5px">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
            <dl class="dl-horizontal dl-small m-b-0">
                <dt style="width:200px !important">Mulai Menggantri: </dt>
                <dd> &nbsp; {{ isset($data->mulai_antri)? date("g:i a", strtotime(substr($data->mulai_antri, 10, 10))) : '-' }}</dd>
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
    </div>

@endforeach