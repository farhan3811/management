<div class="col-sm-12">
    <div class="col-sm-1" style="padding-top:10px;padding-bottom:10px">

        <div id="delete_{{ substr($data->code_medicine, 4) }}" class="delete-notassign" style="border-radius:50%;width:25px;height:25px;background-color:red;font-size:1px;text-align:center;top:5px">
            <i class="material-icons" style="margin-top:3px; font-size:19px;cursor:pointer">clear</i>
        </div>

        </label>
    </div>
    <div class="col-sm-4 enable" style="padding-top:10px;padding-bottom:10px">
        <label class="form-label" style="color:white">{{ $data->nama_obat }}
        </label>
    </div>
    <div class="col-sm-2 enable" style="padding-top:10px;padding-bottom:10px;text-align:right">
        <label class="form-label">
            <span id="STOCK_{{ substr($data->code_medicine, 4) }}">{{ $data->stock_sisa }}</span>/{{ $data->stock_sisa }}
        </label>
    </div>
    <div class="col-sm-2 enable" style="padding-top:10px;padding-bottom:10px">
        <label class="form-label" style="color:white">{{ number_format($data->harga_jual,0,',','.') }} / {{ $data->satuan }}</label>
    </div>
    <div class="col-sm-1 enable ex_div" style="padding-left:1px">
        <div class="form-group" style="margin-bottom:0px">

            <input name="{{ str_replace('-', '_', $data->code_medicine) }}" id ="MDC_{{ substr($data->code_medicine, 4) }}" style="padding-left:10px;padding-left:5px;padding-right:5px;height:45px;" max="{{ $data->stock_sisa }}" class="form-control keypress ex_med" value="0">

        </div>
    </div>
    <div class="col-sm-2 enable" style="background-color:#e3e3e3;color:black;padding-top:10px;padding-bottom:10px;">
        <div class="form-label" style="height:25px">: Rp.
            <div style="text-align:right;float:right">
                <span id="TOTAL_{{ substr($data->code_medicine, 4) }}" class="TOTAL_ADDITIONAL">0</span> ,-</div>
        </div>
    </div>

</div>

<div class="col-sm-12">
    <div class="col-sm-12">
        <hr style="margin:0px;border-color:#49c0da"></hr>
    </div>
</div>