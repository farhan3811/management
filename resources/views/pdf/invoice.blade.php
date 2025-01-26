<html>
<style>
    body{
        font-family:Helvetica;
    }
</style>
<body>
    <div style="width:100%">
        <table>
            <tbody>
                <tr>
                    <td style="width:30%;position:relative;height:90px;float:left;border-right:solid 2px"><img src="img/logo-invoice.jpg" width="210px" /></td>
                    <td style="width:70%;position:relative;height:90px;padding:0px 0px 0px 10px;float:left;">
                            <div style="line-height:18px;font-family:Helvetica !important;font-size:10px"><b>Klinik Mata Utama - Tangerang Selatan</b><br />
                            Jl. Legoso Raya, Pisangan, Ciputat Tim.,<br>
                            Kota Tangerang Selatan, Banten 15419<br>
                            Telp : 021-22741793, 0857-1003-3353, 0823-1192-6697<br>
                            Website : https://klinikmatautamatangsel.com/<br>
                            IG : @kmutangsel
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="width:100%">
            <hr style="border:1px solid" />
        </div>
        <div style="padding-right:20px;padding-left:20px">
            <table style="width:100%">
                <tbody>
                    <tr>
                        <td style="width:100%;position:relative;text-align:center"><h2>KWITANSI</h2></td>
                    </tr>
                </tbody>
            </table>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <td style="width:30%">Terima Dari</td>
                        <td style="width:70%">: {{ $customer->nama_pasien }}</td>
                    </tr>
                    <tr>
                        <td style="width:30%">No Rekam Medis</td>
                        <td style="width:70%">: {{ $customer->id_rekam_medis }}</td>
                    </tr>
                    <tr>
                        <td style="width:30%">Nama Pasien</td>
                        <td style="width:70%">: {{ $customer->nama_pasien }}</td>
                    </tr>
                    <tr>
                        <td style="width:30%">No Transaksi</td>
                        {{-- <td style="width:70%">: KMU/{{ $payment_date->format('Y') }}/{{ $payment_date->format('m') }}/{{ $payment_date->format('d') }}/{{ $payment_date->format('Hi') }}/000{{ $customer->id }}</td> --}}
                        <td style="width: 70%;">: {{$customer->payment_no}}</td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top:20px">
            @php $sum = 0; @endphp
                <table style="width:100%" class="table">
                <thead style="">
                    <tr>
                        <th colspan="2" class="th" style="text-align:center;padding:7px">Kegiatan</th>
                        <th class="th" style="text-align:center">Biaya</th>
                    </tr>
                </thead>
                    <tbody>
                        @if($result_service)
                            <tr style="border:solid 1px;padding:10px">
                                <td class="td" colspan="3" style="padding:10px"><b>Pelayanan</b></td>
                            </tr>
                            @foreach($result_service as $no => $res)
                                @if($res->status_selesai == 'SELESAI')
                                    @php $sum += $res->total; @endphp

                                    <tr style="border:solid 1px;">
                                        <td class="td" style="width:5%;text-align:center">{{ $no + 1 }}</td>
                                        <td class="td" style="width:65%;padding-left:10px;padding-right:10px">{{ strtoupper($res->service_name) }} {{ $res->quantity > 1? '('.$res->quantity.')' : '' }}</td>
                                        <td class="td" style="width:30%;text-align:right;padding-left:10px;padding-right:10px"> {{ number_format($res->total,0,',','.') }},-</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif

                       
                       @if($get_normal_med[0]->id != null)
                            <tr style="border:solid 1px;padding:10px">
                                <td class="td" colspan="3" style="padding:10px"><b>Resep Obat</b></td>
                            </tr>
                            @foreach($get_normal_med as $no => $med)

                                @php $sum += $med->price; @endphp

                                <tr style="border:solid 1px;">
                                    <td class="td" style="width:5%;text-align:center">{{ $no + 1 }}</td>
                                    <td class="td" style="width:65%;padding-left:10px;padding-right:10px">{{ $med->nama_obat }} {{ $med->total > 1? '('.$med->total.' '.$med->satuan.')' : '' }}</td>
                                    <td class="td" style="width:30%;text-align:right;padding-left:10px;padding-right:10px"> {{ number_format($med->price,0,',','.') }},-</td>
                                </tr>

                            @endforeach
                        @endif
                        
                        @if($get_ex_med)
                            <tr style="border:solid 1px;padding:10px">
                                <td class="td" colspan="3" style="padding:10px"><b>Tambahan Obat</b></td>
                            </tr>
                            @foreach($get_ex_med as $no => $exmed)

                                @php $sum += $exmed->price; @endphp

                                <tr style="border:solid 1px;">
                                    <td class="td" style="width:5%;text-align:center">{{ $no + 1 }}</td>
                                    <td class="td" style="width:65%;padding-left:10px;padding-right:10px">{{ $exmed->nama_obat }}{{ $exmed->total > 1? '('.$exmed->total.')' : '' }}</td>
                                    <td class="td" style="width:30%;text-align:right;padding-left:10px;padding-right:10px"> {{ number_format($exmed->price,0,',','.') }},-</td>
                                </tr>

                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
    
    <footer style="width:100%"> 
    <table style="width:100%">
            <tbody>
                <tr>
                    <td style="width:30%">Total Biaya</td>
                    <td style="width:40%">:</td>
                    <td style="width:5%">Rp.</td>
                    <td style="width:15%;text-align:right">{{ number_format($sum,0,',','.') }}-</td>
                </tr>
                <tr>
                    <td style="width:30%">Total Uang Diterima</td>
                    <td style="width:40%">:</td>
                    <td style="width:5%">Rp.</td>
                    <td style="width:15%;text-align:right">{{ number_format($customer->payment_received,0,',','.') }},-</td>
                </tr>
                {{-- <tr>
                    <td style="width:30%">Total Ditanggung</td>
                    <td style="width:40%">:</td>
                    <td style="width:5%">Rp.</td>
                    <td style="width:15%;text-align:right">{{ number_format($sum ,0,',','.') }},-</td>
                </tr> --}}
                {{-- <tr>
                    <td style="width:30%">Jumlah Harus Bayar</td>
                    <td style="width:40%">:</td>
                    <td style="width:5%">Rp.</td>
                    <td style="width:15%;text-align:right">{{ number_format($sum ,0,',','.') }},-</td>
                </tr> --}}
                <tr>
                    @php $return = (int)$customer->payment_received - (int)$sum @endphp
                    <td style="width:30%">Total Kembalian</td>
                    <td style="width:40%">:</td>
                    <td style="width:5%">Rp.</td>
                    <td style="width:15%;text-align:right">{{ number_format($return ,0,',','.') }},-</td>
                </tr>
                <tr>
                    <td style="width:20%">Cara Pembayaran</td>
                    <td style="width:40%">:</td>
                    <td style="width:5%"></td>
                    <td style="width:15%;text-align:right">{{ $customer->payment_method }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <p>
            Tangerang, {{ date ('d M Y') }}
            <br />
            <br />
            <br />
            <br />
            <br />
            Admin Klinik Mata Utama Tangerang Selatan
        </p>
    </footer>
</body>
<style>
footer {
    position: fixed; 
    bottom: 0cm; 
    left: 0cm; 
    right: 0cm;
    height: 300px;
    padding-right:20px;
    padding-left:20px;
}
.space{
    height: 300px;
    padding-right:20px;
    padding-left:20px;
}
.table{

    border-left: 0.01em solid #4f4f4f ;
    border-right: 0;
    border-top: 0.01em solid #4f4f4f ;
    border-bottom: 0;
    border-collapse: collapse;
}
.th{

    border-left: 0;
    border-right: 0.01em solid #4f4f4f ;
    border-top: 0;
    border-bottom: 0.01em solid #4f4f4f ;
}
.td{

    border-left: 0;
    border-right: 0.01em solid #4f4f4f ;
    border-top: 0;
    border-bottom: 0.01em solid #4f4f4f ;
}
</style>
</html>