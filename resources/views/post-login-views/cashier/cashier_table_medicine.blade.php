<div  style="margin-top:30px;background-color:#ecedc6;padding:20px;color:black">

    <table id="table-cashier-add" class="table table-condensed table-hover js-basic-example">
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Stok</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach($med as $data)
                <tr @if($data->code_afct_medicine_details == '')
                        style="cursor:pointer" class="enable-med assign_med" id="MED_{{ substr($data->code_medicine, 4) }}"
                    @else
                        class="notdefined"  style="color:#fff;background-color:red"
                    @endif">
                    <td>{{ $data->nama_obat }}</td>
                    <td>{{ $data->stock_sisa }}</td>
                    <td>Rp. {{ number_format($data->harga_jual,0,',','.').',- /'.$data->satuan }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>