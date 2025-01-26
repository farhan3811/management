

<div style="background-color:#398f34;padding:15px;border:2px solid;">
<div id="entry_medicine">
    <style>
    .form-normal{
        background-color:#fff7d4;
        color:#7d5214;
        text-transform: capitalize;
        padding-left:7px !important;
        border-radius: 3px !important;
        border:solid 1px #d2d2d2 !important;
    }
    .disable{
        opacity:0.2;
        background-color:black;
    }
    .disable-med{
        opacity:0.2;
    }
    </style>

    <div class="row clearfix">
            @php $sum = 0; $k = 0; @endphp
            @if($cd_bkp != 'new' and substr($cd_bkp, 0, 3) != 'XPM')
            <div class="col-sm-12">
                <label class="form-label"><h4 style="color:#fff">Data obat resep dokter</h4></label>
                <hr style="margin-top:0px"></hr>
            </div>

                @foreach($result as $data)
                    @if ($k == 0) 
                        @php $paidmed = $data->is_paid; @endphp
                        @php $takenmed = $data->is_taken; @endphp
                        @php $billedmed = $data->is_billed; @endphp
                    
                    @endif
                    <div class="col-sm-12" >
                        @php 
                            if(isset($data->total)){
                                if($data->total != ''){
                                    $val = $data->total;
                                    $income = 1;
                                }else{
                                    if($data->jumlah <= $data->stock_sisa){
                                        $val =  $data->jumlah;
                                    }else{
                                        $val = 0;
                                    }
                                    $income = 0;
                                }
                            }else{
                                if($data->jumlah <= $data->stock_sisa){
                                    $val = $data->jumlah;
                                }else{
                                    $val = 0;
                                }
                                $income = 0;
                            }
                            if($check_income > 0 and $income == 0){
                                $state_income = 'disable';
                            }else{
                                $state_income = 'enable';
                            }
                        @endphp
                        {{-- <div class="col-sm-1" style="padding-top:10px;padding-bottom:10px">
                            @php 
                                if($data->is_paid == 'Y'){
                                    if($data->is_taken == 'Y'){
                                        $colorbut = 'green';
                                        $but = 'done_all';
                                    }else{
                                        $colorbut = 'green';
                                        $but = 'done';
                                    }
                                }else{
                                    if(($state_income == 'disable')){
                                        $colorbut = 'rgb(183, 183, 0)';
                                        $but = 'reply';
                                    }else{
                                        $colorbut = 'red';
                                        $but = 'clear';
                                    }
                                }
                            @endphp --}}
                            {{-- <div id="button_{{ substr($data->code_afct_medicine_details, 4) }}" class="button-notassign" 
                                style="border-radius:50%;width:25px;height:25px;background-color:{{ $colorbut }};font-size:1px;text-align:center;top:5px"> --}}
                            {{-- <i class="material-icons" style="margin-top:3px; font-size:19px;cursor:pointer">{{ $but }}</i></div>
                            </label>
                        </div> --}}
                        <input id="button_{{ substr($data->code_afct_medicine_details, 4) }}" class="button-notassign" type="hidden">
                        <div class="col-sm-5 {{ $state_income }}" style="padding-top:10px;padding-bottom:10px">
                            <label class="form-label" style="color:white">{{ $data->nama_obat }}<span style="color:black">{{ ' ('.$data->jumlah.')' }} </span></label>
                        </div>
                        <div class="col-sm-2 {{ $state_income }}" style="padding-top:10px;padding-bottom:10px;text-align:right">
                            <label class="form-label"><span id="STOCK_{{ substr($data->code_afct_medicine_details, 4) }}">
                            @php
                                if(isset($data->total)){
                                    if($data->total != ''){
                                        $getTotal = $data->total;
                                    }else{
                                        if($data->jumlah <= $data->stock_sisa){
                                            $getTotal = $data->jumlah;
                                        }else{
                                            $getTotal = 0; 
                                        }
                                    }
                                }else{
                                    if($data->jumlah <= $data->stock_sisa){
                                        $getTotal = $data->jumlah;
                                    }else{
                                        $getTotal = 0;
                                    }
                                }
                            @endphp
                            {{ $data->stock_sisa - $getTotal }}</span>/{{ $data->stock_sisa }}</label>
                        </div>
                        <div class="col-sm-2 {{ $state_income }}" style="padding-top:10px;padding-bottom:10px">
                            <label class="form-label" style="color:white">{{ number_format($data->harga_jual,0,',','.') }} / {{ $data->satuan }}</label>
                        </div>
                        <div class="col-sm-1 {{ $state_income }} afct_div" style="padding-left:1px">
                            <div class="form-group" style="margin-bottom:0px">

                                <input name="{{ str_replace('-', '_', $data->code_afct_medicine_details) }}" style="padding-left:10px;padding-left:5px;padding-right:5px;height:45px;{{ ($data->is_paid == 'Y' or $data->is_taken) == 'Y' ? 'background-color:#6acf57' : '' }}" max="{{ $data->stock_sisa }}" id ="DET_{{ substr($data->code_afct_medicine_details, 4) }}"  {{ ($data->is_paid == 'Y' or $data->is_taken) == 'Y' ? 'readonly' : '' }} class="form-control keypress afct_med" 
                                value="{{ ($state_income == 'disable')? 0 : $val }}">

                            </div>
                        </div>
                        <div class="col-sm-2 {{ $state_income }}" style="background-color:#e3e3e3;color:black;padding-top:10px;padding-bottom:10px;">
                            <div class="form-label" style="height:25px">: Rp. <div style="text-align:right;float:right"><span id="TOTAL_{{ substr($data->code_afct_medicine_details, 4) }}"   class="TOTAL_RECIPT_DOCTER">

                            @php 
                            if($state_income == 'disable'){
                                $get_total = 0;
                            }else{
                                if($data->price){
                                    $get_total = $data->price;
                                }else{
                                    if(isset($data->total)){
                                        if($data->total != ''){
                                            $get_total = $data->total;
                                        }else{
                                            if($data->jumlah <= $data->stock_sisa){
                                                $get_total = $data->jumlah;
                                            }else{
                                                $get_total = 0;
                                            }
                                        }
                                    }else{
                                        if($data->jumlah <= $data->stock_sisa){
                                            $get_total = $data->jumlah ;
                                        }else{
                                            $get_total = 0;
                                        }
                                    }
                                    $get_total = $get_total * $data->harga_jual; 
                                }
                            }
                            
                            @endphp

                            {{  number_format($get_total ,0,',','.') }}</span> ,-</div></div>
                        </div>
                            
                    </div>

                    <div class="col-sm-12"> 
                            <hr style="margin:0px;"></hr>
                        <div class="col-sm-12"> 
                            
                        </div>
                    </div>
                    @php  $sum = $sum + $get_total; @endphp

                    @php $cd_type = $data->code_afct_medicine; @endphp

                @endforeach

                <div class="col-sm-12" style="margin-top:20px;background-color: #81382c;"> 

                    <div class="col-sm-10" style="margin-top:15px"> 
                        <span style="font-size:14px;color:#fff;"><b>TOTAL HARGA OBAT RESEP DOKTER YANG DIAMBIL :</b></span>
                    </div>
                    <div class="col-sm-2 enable" style="background-color:#e3e3e3;color:black;padding-top:10px;padding-bottom:10px;">
                        <div class="form-label" style="height:25px">: Rp. <div style="text-align:right;float:right"><span id="SUMMARY_RECEIPT">{{ number_format($sum ,0,',','.') }}</span> ,-</div></div>
                    </div>
                </div>
                
            @endif

            @php
                if($cd_bkp == 'new'){
                    $cd_type = 'new';
                }elseif(substr($cd_bkp, 0, 3) == 'XPM'){
                    $cd_type = $cd_bkp;
                }
            @endphp
            
            @php $cd_afct_con = $cd_type; @endphp

            <input  {{ $disabled }} id="cd_afct_con" type="hidden" value="{{ isset($cd_afct_con)? $cd_afct_con : 'new' }}">

            <div class="col-sm-12" id="section-new-med" style="margin-top:25px;padding:0">
            @php 
                $custnm = $result_ex;
            @endphp
                <div class="col-sm-12">
                    <input placeholder="Nama Pembeli" type="{{ ($cd_bkp == 'new' or substr($cd_bkp, 0, 3) == 'XPM')? '' : 'hidden' }}" style="color:black;width:40%;margin-bottom:10px" {{ $disabled }} id="name_cust_ex" value="{{ isset($custnm->get()->first()->customer_name)? $custnm->get()->first()->customer_name : '' }}">
                </div>

                @php $total_ex = 0; @endphp
                @if($result_ex->count())
                        <div class="col-sm-12 title-new-med">
                            <label class="form-label">
                                <h4 style="color:#fff">Data obat tambahan</h4>
                            </label>
                            <hr style="margin-top:0px">
                        </div>
                        @foreach($result_ex->get() as $data)
                            @if(!isset($paidmed))
                                @php $paidmed = $data->is_paid; @endphp
                                @php $takenmed = $data->is_taken; @endphp
                                @php $billedmed = $data->is_billed; @endphp
                            @endif

                            
                            <div class="col-sm-12">
                                <div class="col-sm-1" style="padding-top:10px;padding-bottom:10px">
                                    <div id="delete_{{ $data->code_medicine }}" class="delete-notassign" style="border-radius:50%;width:25px;height:25px;background-color:red;font-size:1px;text-align:center;top:5px;background-color:{{ $colorbut }}">
                                        <i class="material-icons" style="margin-top:3px; font-size:19px;cursor:pointer">{{ $but }}</i>
                                    </div>
                                </div>
                                <div class="col-sm-4 enable" style="padding-top:10px;padding-bottom:10px">
                                    <label class="form-label" style="color:white">{{ $data->nama_obat }} </label>
                                </div>
                                <div class="col-sm-2 enable" style="padding-top:10px;padding-bottom:10px;text-align:right">
                                    <label class="form-label">
                                        <span id="STOCK_{{ $data->code_medicine }}">{{ $data->stock_sisa - $data->total }}</span>/{{ $data->stock_sisa }} </label>
                                </div>
                                <div class="col-sm-2 enable" style="padding-top:10px;padding-bottom:10px">
                                    <label class="form-label" style="color:white">{{ $data->harga_jual }} / BOTOL</label>
                                </div>
                                <div class="col-sm-1 enable ex_div" style="padding-left:1px">
                                    <div class="form-group" style="margin-bottom:0px">
                                        <input name="{{ str_replace('-', '_', $data->code_medicine) }}" id="MDC_{{ substr($data->code_medicine, 4) }}" style="padding-left:10px;padding-left:5px;padding-right:5px;height:45px;{{ ($data->is_paid == 'Y' or $data->is_taken) == 'Y' ? 'background-color:#6acf57' : '' }}"
                                            max="1020" class="form-control keypress ex_med" {{ ($data->is_paid == 'Y' or $data->is_taken) == 'Y' ? 'readonly' : '' }} value="{{ $data->total }}"> </div>
                                </div>
                                <div class="col-sm-2 enable" style="background-color:#e3e3e3;color:black;padding-top:10px;padding-bottom:10px;">
                                    <div class="form-label" style="height:25px">: Rp.
                                        <div style="text-align:right;float:right">
                                            <span id="TOTAL_{{ substr($data->code_medicine, 4) }}" class="TOTAL_ADDITIONAL">{{ number_format($data->price ,0,',','.') }}</span> ,-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <hr style="margin:0px;">
                                <div class="col-sm-12">
                                     
                                </div>
                            </div>
                            @php $total_ex = $data->price + $total_ex; @endphp
                        @endforeach
                        
                        <div class="col-sm-12 footer-new-med" style="padding-top:15px;background-color:#81382c;margin-bottom:25px;">
                            <div class="col-sm-10" style="margin-top:15px">
                                <span style="font-size:14px;color:#fff">
                                    <b>TOTAL HARGA OBAT TAMBAHAN :</b>
                                </span>
                            </div>
                            <div class="col-sm-2 enable" style="background-color:#e3e3e3;color:black;padding-top:10px;padding-bottom:10px;">
                                <div class="form-label" style="height:25px">: Rp.
                                    <div style="text-align:right;float:right">
                                        <span id="SUMMARY_ADDITIONAL">{{ number_format($total_ex ,0,',','.') }}</span> ,-</div>
                                </div>
                            </div>
                        </div>
                @endif
            </div>

            <div class="col-sm-12" style="background-color:#81382c">
                <div class="col-sm-10" style="margin-top:10px">
                    <span style="font-size:14px;color:#fff"><b> TOTAL YANG HARUS DIBAYAR :</b></span>
                </div>
                <div class="col-sm-2" style="background-color:white;color:black;padding-top:10px;padding-bottom:10px;">
                    <div class="form-label" style="height:25px">: Rp. <div style="text-align:right;float:right"><span id="SUMMARY">{{ number_format($sum + $total_ex,0,',','.') }}</span> ,-</div></div>
                </div>
            </div>

            {{-- <div class="col-sm-5" STYLE="margin-top:25px">
                <button class="col-sm-12 btn btn-lg btn-primary" id="btn-add">TAMBAH OBAT</button>
            </div> --}}

            <div class="col-sm-12" id="new-medicine" style=""></div>

            <div class="col-sm-12" style="padding-top:40px">
                <div class="col-sm-4 ">
                    <div style="padding-left:100px">
                        <input  {{ $disabled }} id="tagihan" class="filled-in chk-col-teal"  type="checkbox" {{ (isset($billedmed)? ($billedmed== 'Y')?  " checked "  : "" : " checked ") }}>
                        <label for="tagihan" style="color:black">Masukkan ke tagihan</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div style="padding-left:100px">
                        <input id="bayar" class="filled-in chk-col-teal" type="checkbox" {{ (isset($paidmed)? ($paidmed == 'Y')?  " checked "  : "" :  "") }}>
                        <label for="bayar" style="color:black">Sudah dibayar </label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div style="padding-left:100px">
                        <input {{ $taken }} id="ambil" class="filled-in chk-col-teal" type="checkbox" {{ (isset($takenmed)? ($takenmed == 'Y')?  " checked "  : "" :  "") }}>
                        <label for="ambil" style="color:black">Sudah diambil</label>
                    </div>
                </div>
            </div>

    </div>
</div></div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));
    });
</script>
<style>
    #entry_medicine .bootstrap-select{
        background-color:#398f34 !important;    
    }
    #entry_medicine .dropdown-toggle{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .filter-option{
        color:white;
        padding-top:5px
    }
</style>