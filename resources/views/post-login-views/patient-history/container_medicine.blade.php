
<div class="body table-responsive">
    <table class="table table-hover table-condensed table-striped">
        <thead>
            <tr class="bg-light-blue">
                <th>Nama Obat</th>
                <th>Total</th>
                <th>Dibeli</th>
                <th>Harga</th>
                <th>Total (Rp.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $data)
            <tr>
                <td>{{ $data->nama_obat .'/'.$data->satuan }}</td>
                <td>{{ $data->jumlah_dokter }}</td>
                <td>{{ $data->jumlah_pasien }}</td>
                <td>{{ $data->harga_jual }}</td>
                <td>{{ $data->harga_obat_dibayar }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
