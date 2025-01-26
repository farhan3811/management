@foreach($patient as $data)
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
<label><h3>Identitas Pasien</h3></label>

</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 0px;">
     <table class="table table-striped-new table-hover table-condensed">
        <tbody>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Nama Lengkap</b></span>
                </td>
                <td class="left-position">{{$data->nama_pasien}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Nomor Induk</b></span>
                </td>
                <td class="left-position">{{$data->id_rekam_medis}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Tanggal Lahir</b></span>
                </td>
                <td class="left-position">{{date('l, d M Y', strtotime($data->tanggal_lahir)) }}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Jenis Kelamin</b></span>
                </td>
                <td class="left-position">{{$data->jenis_kelamin == 'L'? 'Laki-laki' : $data->jenis_kelamin == 'P'? 'Perempuan' : 'Tidak Diketahui/Belum Diinput' }}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Alamat Rumah</b></span>
                </td>
                <td class="left-position">{{$data->alamat}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Email Aktif</b></span>
                </td>
                <td class="left-position">{{$data->email }}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Telepon Rumah</b></span>
                </td>
                <td class="left-position">{{$data->telepon}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Handphone</b></span>
                </td>
                <td class="left-position">{{$data->handphone}}</td>
            </tr>
        </tbody>
    </table>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
     <table class="table table-striped-new table-hover table-condensed">
        <tbody>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Negara</b></span>
                </td>
                <td class="left-position">{{isset($data->toCountries->name)? $data->toCountries->name : ''}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Provinsi</b></span>
                </td>
                <td class="left-position">{{isset($data->toProvinces->name)? $data->toProvinces->name : ''}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Kota</b></span>
                </td>
                <td class="left-position">{{isset($data->toRegencies->name)? $data->toRegencies->name : ''}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Kecamatan</b></span>
                </td>
                <td class="left-position">{{isset($data->toDistricts->name)? $data->toDistricts->name : ''}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Kelurahan</b></span>
                </td>
                <td class="left-position">{{isset($data->toVillages->name)? $data->toVillages->name : ''}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Kodepos</b></span>
                </td>
                <td class="left-position">{{$data->kodepos}}</td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
     <table class="table table-striped-new table-hover table-condensed">
        <tbody>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Golongan Darah</b></span>
                </td>
                <td class="left-position">{{$data->gol_darah}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Riwayat Penyakit</b></span>
                </td>
                <td class="left-position">{{$data->riwayat_penyakit}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Nama Wali</b></span>
                </td>
                <td class="left-position">{{$data->nama_wali}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Hubungan Wali</b></span>
                </td>
                <td class="left-position">{{$data->hubungan_wali}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>No Telp Wali</b></span>
                </td>
                <td class="left-position">{{$data->nomor_telepon_wali}}</td>
            </tr>
            <tr>
                <td class="position-temp">
                    <span class="pull-right"><b>Email Wali</b></span>
                </td>
                <td class="left-position">{{$data->email_wali}}</td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right: 0px; margin-bottom: 0px;">
        <div style="margin-right:18px;text-align:right"><span><i>*Data Akun Sistem Pasien</i></span></div>
        <div style="margin-left:10px;margin-right:15px;border:solid 1px #d7d7d7;background-color:#d5ffe1;padding:5px">
        <div>
            <dl class="dl-horizontal dl-small m-b-0">
                <dt>Tanggal Dibuat</dt>
                <dd class="left-position">{{date('l, d M Y', strtotime($data->created_at)) }}</dd>
                <dt>Terakhir Login</dt>
                
                <dd class="left-position">{{$patientlog }}</dd>
                
                <dt>Status Pasien</dt>
                <dd style="color:{{ $data->status_pasien == 0? 'red' : 'green'}}" class="left-position">{{$data->status_pasien == 0? 'Belum Validasi Akun' : 'Sudah validasi akun'}}</dd>
            </dl>
            </div>
        </div>
    </div>
@endforeach
<style>
.position-temp{
    width:40% !important;
}
.left-position{
    padding-left:20px !important;
}
</style>

