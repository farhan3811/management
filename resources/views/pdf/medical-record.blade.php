<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekam Medis Pasien #{{$patient->id_rekam_medis}}</title>

    <style>
        .position-temp{
            width:40% !important;
        }
        .left-position{
            padding-left:20px !important;
        }
        .pull-right {
            float: right !important;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        .table-striped-new > tbody > tr:nth-of-type(odd) {
            background-color: #e9f2ff !important;
        }
        .table-striped-new > tbody > tr:nth-of-type(even) {
            background-color: #f7f7f7 !important;
        }
        .table-striped-new tbody tr td, .table tbody tr th {
            padding: 8px;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }
        .bg-light-blue {
            background-color: #03A9F4 !important;
            color: #fff;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div id="identity">
        <h2>Identitas Pasien</h2>

        <table class="table table-striped-new table-hover table-condensed">
            <tbody>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Nomor Rekam Medis</b></span>
                    </td>
                    <td class="left-position">{{$patient->id_rekam_medis}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Nama Lengkap</b></span>
                    </td>
                    <td class="left-position">{{$patient->nama_pasien}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Tanggal Lahir</b></span>
                    </td>
                    <td class="left-position">{{date('l, d M Y', strtotime($patient->tanggal_lahir)) }}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Jenis Kelamin</b></span>
                    </td>
                    <td class="left-position">{{$patient->jenis_kelamin == 'L'? 'Laki-laki' : $patient->jenis_kelamin == 'P'? 'Perempuan' : 'Tidak Diketahui/Belum Diinput' }}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Alamat Rumah</b></span>
                    </td>
                    <td class="left-position">{{$patient->alamat}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Email Aktif</b></span>
                    </td>
                    <td class="left-position">{{$patient->email == null ? '-' : $patient->email}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Telepon Rumah</b></span>
                    </td>
                    <td class="left-position">{{$patient->telepon}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Handphone</b></span>
                    </td>
                    <td class="left-position">{{$patient->handphone == null ? '-' : $patient->handphone}}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped-new table-hover table-condensed">
            <tbody>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Negara</b></span>
                    </td>
                    <td class="left-position">{{isset($patient->toCountries->name)? $patient->toCountries->name : '-'}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Provinsi</b></span>
                    </td>
                    <td class="left-position">{{isset($patient->toProvinces->name)? $patient->toProvinces->name : '-'}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Kota</b></span>
                    </td>
                    <td class="left-position">{{isset($patient->toRegencies->name)? $patient->toRegencies->name : '-'}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Kecamatan</b></span>
                    </td>
                    <td class="left-position">{{isset($patient->toDistricts->name)? $patient->toDistricts->name : '-'}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Kelurahan</b></span>
                    </td>
                    <td class="left-position">{{isset($patient->toVillages->name)? $patient->toVillages->name : '-'}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Kodepos</b></span>
                    </td>
                    <td class="left-position">{{$patient->kodepos == null ? '-' : $patient->kodepos}}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped-new table-hover table-condensed">
            <tbody>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Golongan Darah</b></span>
                    </td>
                    <td class="left-position">{{$patient->gol_darah}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Riwayat Penyakit</b></span>
                    </td>
                    <td class="left-position">{{$patient->riwayat_penyakit}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Nama Wali</b></span>
                    </td>
                    <td class="left-position">{{$patient->nama_wali}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Hubungan Wali</b></span>
                    </td>
                    <td class="left-position">{{$patient->hubungan_wali}}</td>
                </tr>
                <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>No Telp Wali</b></span>
                    </td>
                    <td class="left-position">{{$patient->nomor_telepon_wali}}</td>
                </tr>
                {{-- <tr>
                    <td class="position-temp">
                        <span class="pull-right"><b>Email Wali</b></span>
                    </td>
                    <td class="left-position">{{$patient->email_wali == null ? '-' : $patient->email_wali}}</td>
                </tr> --}}
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div id="pemeriksaan">
        @php $counter = 0 @endphp
        @foreach($bookings as $booking)
            @if($booking['toQueueVisus']['toVisus'] != null)
                <h2>Pemeriksaan Pada Tanggal {{date('d M Y', strtotime($booking->booking_tanggal))}}, No Rekam Medis {{$patient->id_rekam_medis}}</h2><br>
                
                <h3><u>Pemeriksaan Visus</u></h3>
                <table class="table table-hover table-condensed table-bordered">
                    <tbody>
                        <tr>
                            <td style="width:50%;text-align:center" class="bg-light-blue"><span><b>Visus Mata Kanan</span></b></td>
                            <td style="width:50%;text-align:center" class="bg-light-blue"><span><b>Visus Mata Kiri</span></b></td>
                        </tr>
                        <tr>
                            <td style="width:50%;text-align:center">{{ $booking['toQueueVisus']['toVisus']['visus_mata_kanan'] }}</td>
                            <td style="width:50%;text-align:center">{{ $booking['toQueueVisus']['toVisus']['visus_mata_kiri'] }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-hover table-condensed table-striped-new">
                    <tbody>
                        <tr>
                            <td style="width:50%"><span class="pull-right"><b>Segment Anterior</span></b></td>
                            <td>{{ $booking['toQueueVisus']['toVisus']['segment_anterior'] }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span class="pull-right"><b>Segment Posterior</span></b></td>
                            <td>{{ $booking['toQueueVisus']['toVisus']['segment_posterior'] }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span  class="pull-right" ><b>Penglihatan Warna</span></b></td>
                            <td>{{ $booking['toQueueVisus']['toVisus']['penglihatan_warna'] }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span  class="pull-right" ><b>Keterangan</span></b></td>
                            <td>{{ $booking['toQueueVisus']['toVisus']['keterangan'] }}</td>
                        </tr>
                        <tr>
                            <td style="width:50%"><span  class="pull-right" ><b>Saran</span></b></td>
                            <td>{{ $booking['toQueueVisus']['toVisus']['saran'] }}</td>
                        </tr>
                    </tbody>
                </table><br>

                <h3><u>Pemeriksaan Dokter</u></h3>
                <b>Nama Dokter : </b>{{$booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['user']['docter']->nama_dokter}} <br><br>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="width:25%;text-align:center" class="bg-light-blue"><b>Kacamata</span></b></th>
                            <th style="width:25%;text-align:center" class="bg-light-blue"><b>Obat</span></b></th>
                            <th style="width:25%;text-align:center" class="bg-light-blue"><b>Rujukan</span></b></th>
                            <th style="width:25%;text-align:center" class="bg-light-blue"><b>Operasi</span></b></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td style="width:25%;text-align:center" >{{ $booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']->is_glasses == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                                <td style="width:25%;text-align:center" >{{ $booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']->is_medicine == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                                <td style="width:25%;text-align:center" >{{ $booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']->refer == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                                <td style="width:25%;text-align:center" >{{ $booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']->is_operation == 'Y'? 'Ya' : 'Tidak' }}</span></b></td>
                            </tr>
                    </tbody>
                </table><br>
                <b>Keterangan Dokter :</b><br>
                {!!$booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']->desc!!}

                <br><br>
                <b>Obat Yang Diberikan :</b><br>
                @if($booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toAfctMedicine'] != null)
                    @if(count($booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toAfctMedicine']['toAfctMedicineDetail']) != 0)
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:25%;text-align:center" class="bg-light-blue"><b>Nama Obat</span></b></th>
                                    <th style="width:25%;text-align:center" class="bg-light-blue"><b>Jumlah Obat</span></b></th>
                                    <th style="width:25%;text-align:center" class="bg-light-blue"><b>Unit Obat</span></b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toAfctMedicine']['toAfctMedicineDetail'] as $obat)
                                    <tr>
                                        <td style="width:25%;text-align:center">{{$obat['toDetailMedicine']['toMedicine']->nama_obat}}</td>
                                        <td style="width:25%;text-align:center">{{$obat->jumlah}}</td>
                                        <td style="width:25%;text-align:center">{{$obat['toDetailMedicine']['toMedicine']['toMedicineUnit']->satuan}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><br>
                    @else
                        -
                    @endif
                @else
                    -
                @endif

                <h3><u>Pemeriksaan Laboratorium</u></h3>

                @if($booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab'] != null)
                @if(!is_null($booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab']))
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width:25%;text-align:center" class="bg-light-blue"><b>Periksa Lab</span></b></th>
                                <th style="width:25%;text-align:center" class="bg-light-blue"><b>Hasil</span></b></th>
                                <th style="width:25%;text-align:center" class="bg-light-blue"><b>Positif or Negatif</span></b></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab'] as $lab) --}}
                                <tr>
                                    <td style="width:25%;text-align:center">{{$booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab']['toReqLabDetail']['toLab']->detail_lab}}</td>
                                    <td style="width:25%;text-align:center">{{$booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab']['toReqLabDetail']->value}}</td>
                                    <td style="width:25%;text-align:center">{{$booking['toQueueVisus']['toVisus']['toQueueDokter']['toConsult']['toRequestLab']['toReqLabDetail']->positif_or_negatif}}</td>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table><br>
                @else
                    -
                @endif
                @else
                    -
                @endif

                <h3><u>Tindakan Operasi</u></h3>

                @if($counter != count($bookings) - 1)
                    <div class="page-break"></div>
                @endif
                
                @php $counter++ @endphp

            @endif
        @endforeach
    </div>
</body>
</html>