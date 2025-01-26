@foreach($booking as $data)
    <div class="body table-responsive">
        <table class="table table-hover table-condensed table-striped">
            <tbody>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Booking Dari</span></b></td>
                        <td>{{ $data->booking_dari }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Booking Untuk Tanggal</span></b></td>
                        <td>{{ date('l, d M Y', strtotime(substr($data->booking_tanggal, 0, 10))) }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Booking Untuk Poliklinik</span></b></td>
                        <td>{{ isset($data->toBookingTime->toBookingDay->toDocter->toPoliklinik->nama_poliklinik) ? $data->toBookingTime->toBookingDay->toDocter->toPoliklinik->nama_poliklinik : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Booking Untuk Dokter</span></b></td>
                        <td>{{ isset($data->toBookingTime->toBookingDay->toDocter->nama_dokter)? $data->toBookingTime->toBookingDay->toDocter->nama_dokter : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Booking Hari Jadwal Dokter</span></b></td>
                        <td>{{ isset($data->toBookingTime->toBookingDay->day)? date('l', strtotime($data->toBookingTime->toBookingDay->day)) : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Booking Jam Jadwal Dokter</span></b></td>
                        <td>{{ isset($data->toBookingTime->time_start) ? date("g:i a", strtotime($data->toBookingTime->time_start)) .' - '. date("g:i a", strtotime($data->toBookingTime->time_end)) : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Tanggal Booking</span></b></td>
                        <td>{{ date('l, d M Y', strtotime(substr($data->created_at, 0, 10))) }}</td>
                    </tr>
                    <tr>
                        <td style="width:40%"><span  class="pull-right" ><b>Waktu Booking</span></b></td>
                        <td>{{ date("g:i a", strtotime(substr($data->created_at, 10, 10)))}}</td>
                    </tr>
            </tbody>
        </table>
    </div>
    <b>Booking Queue</b>
    <div class="" style="padding-top:10px;padding-left:20px">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
                <dl class="dl-horizontal dl-small m-b-0">
                    <dt>Mulai Menggantri</dt>
                    <dd>{{ isset($data->toQueueVisus->created_at)? date("g:i a", strtotime(substr($data->toQueueVisus->created_at, 10, 10))) : '-' }}</dd>
                </dl>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
                <dl class="dl-horizontal dl-small m-b-0">
                    <dt>Nomor Antrian Ke</dt>
                    <dd>{{ isset($data->toQueueVisus->queue_no) ? $data->toQueueVisus->queue_no : '-'}}</dd>
                </dl>
            </div>
            <br />
            <br />
            <br />
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= isset($data->toQueueVisus->is_called) ? ($data->toQueueVisus->is_skipped == 'Y') ?  ' <span style="color:green"><i class="material-icons" style="top:5px;position:relative">done</i> Sudah Dipanggil </span>' :  '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Belum Dipanggil</span> ' : '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Belum Dipanggil</span> ' ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= isset($data->toQueueVisus->is_skipped) ? ($data->toQueueVisus->is_skipped == 'Y') ?  ' <span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Dilewati</span>' :  ' <span style="color:green"><i class="material-icons" style="top:5px;position:relative">done</i> Tidak Dilewati</span>' : '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Diketahui</span> ' ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= isset($data->toQueueVisus->is_canceled) ? ($data->toQueueVisus->is_canceled == 'Y') ?  '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Dibatalkan</span>' :  '<span style="color:green"><i class="material-icons" style="top:5px;position:relative">done</i> Tidak Dibatalkan</span> ' : '<span style="color:red"><i class="material-icons" style="top:5px;position:relative">clear</i> Tidak Diketahui</span>' ?>
            </div>
        </div>
    </div>
@endforeach