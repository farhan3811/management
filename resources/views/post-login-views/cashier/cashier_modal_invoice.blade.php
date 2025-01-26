<div style="background-color:#398f34;padding:15px;border:2px solid;">
    <div id="entry_medicine">

        <div class="row clearfix">
            @php $sum = 0; $k = 0; @endphp
            @if($result_service)
                @if($result_service->count())
                    <div class="col-sm-12">
                        <label class="form-label"><h4 style="color:#fff">Biaya Service/Pelayanan</h4></label>
                        <table class="table table-condensed">
                            <tbody style="background-color:#476e3f">
                                    @foreach($result_service as $no => $serv)
                                        @if($serv->status_selesai == 'SELESAI')
                                            @php $sum += $serv->total;  @endphp
                                            <tr>
                                                <td width="5%">{{ $no + 1 }}</td>
                                                <td width="10%">{{$serv->service_category}}</td>
                                                <td width="40%">{{$serv->service_name}}</td>
                                                <td width="20%" style="text-align:right">Rp. {{number_format($serv->price,0,',','.')}},-</td>
                                                <td width="5%" style="text-align:center">{{$serv->quantity == 0? 1 : $serv->quantity}}</td>
                                                <td width="20%" style="text-align:right">Rp. {{ number_format($serv->total,0,',','.')}},-</td>
                                            </tr>
                                        @endif
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
            @if($get_normal_med)
                @if($get_normal_med->count() and $get_normal_med->first()->id != null)
                    <div class="col-sm-12">
                        <label class="form-label"><h4 style="color:#fff">Biaya Obat Resep</h4></label>
                        <table class="table table-condensed">
                            <tbody style="background-color:#476e3f">
                                    @foreach($get_normal_med as $no => $med)
                                        @php $sum += $med->price;  @endphp
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{$med->service_category}}</td>
                                            <td>{{$med->nama_obat}}</td>
                                            <td style="text-align:right">Rp. {{number_format($med->harga_jual,0,',','.')}},-</td>
                                            <td style="text-align:center">{{$med->total}}</td>
                                            <td style="text-align:right">Rp. {{number_format($med->price,0,',','.')}},-</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
            
            @if($get_ex_med)
                @if($get_ex_med->count())
                    <div class="col-sm-12">
                        <label class="form-label"><h4 style="color:#91e4ff">Biaya Obat Di Luar Resep</h4></label>
                        <table class="table table-condensed">
                            <tbody style="background-color:#476e3f">
                                    @foreach($get_ex_med as $no => $ex)
                                        @if($ex->status_selesai == 'SELESAI')
                                            @php $sum += $ex->price;  @endphp
                                            <tr>
                                                <td>{{ $no + 1 }}</td>
                                                <td>{{$ex->service_category}}</td>
                                                <td>{{$ex->nama_obat}}</td>
                                                <td style="text-align:right">Rp. {{number_format($ex->harga_jual,0,',','.')}},-</td>
                                                <td style="text-align:center">{{$ex->total}}</td>
                                                <td style="text-align:right">Rp. {{number_format($ex->price,0,',','.')}},-</td>
                                            </tr>
                                        @endif
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif

            <div class="col-sm-12">
                <table class="table table-condensed">
                    <tbody style="background-color:#81382c">
                        <tr>
                            <td width="200px"><b>TOTAL</b></td>
                            <td style="text-align:right">Rp. {{number_format($sum,0,',','.')}},-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Tambahkan filter sudah bayar -->
<div class="row" style="padding:15px;">
    <div class="col-sm-12" style="padding-top:40px">
        <div class="col-sm-6">
            <div class="form-group form-float" style="top:-25px;position:relative;height:16px">
            <label class="form-label" style="color:#7d800d">Metode Pembayaran</label>
                <select required {{ $disabled }} id="jenis_operasi" name="method" style="background-color:#45c3d8" required class="form-control show-tick form-payment-cashier" style="background-color:aliceblue;color:white" >
                    <option {{ isset($check_payment->payment_method)? ($check_payment->payment_method == 'CASH'? ' selected ' : '') : '' }} value="CASH" >CASH</option>
                    <option {{ isset($check_payment->payment_method)? ($check_payment->payment_method == 'DEBIT'? ' selected ' : '') : '' }} value="DEBIT" >DEBIT</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    <input value="{{ isset($check_payment->payment_received)? $check_payment->payment_received : '' }}" {{ $disabled }} type="text" class="form-control form-payment-cashier" name="total" value="{{ $sum }}" />
                    <label class="form-label" style="color:#7d800d;padding-left:5px">Total pembayaran</label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 text-center">
            @if(!$check_payment)
                <input name="cd" id="cd" class="form-payment-cashier" type="hidden" value="{{ $cd_bkp }}" />
                <button id="pay_now" class="btn btn-primary" type="button"> Bayar Sekarang</button>
            @endif
            @if($check_payment)
                {{-- <form method="POST" action="kasir/invoice">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <input id="cd" name="cd" type="hidden" value="{{ $cd_bkp }}" />
                    <button class="btn btn-primary" type="submit"> Print Invoice</button>
                </form> --}}
                <a href="/kasir/invoice?cd={{$cd_bkp}}" class="btn btn-primary" target="_blank">Print Invoice</a>
            @endif
        </div>
        {{-- <div class="col-sm-6 ">
            <div class="form-group form-float">
                <div class="form-line">
                    <input {{ $disabled }} value="{{ isset($check_payment->payment_no)? $check_payment->payment_no : '' }}" type="text" class="form-control form-payment-cashier" name="trx_no" {{ $disabled }} >
                    <label class="form-label" style="color:#7d800d;padding-left:5px">Nomor transaksi (kosongkan apabila tidak ada)</label>
                </div>
            </div>
        </div> --}}
    </div>
    {{-- <div class="col-sm-12" style="padding-top:40px">
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    <input value="{{ isset($check_payment->payment_received)? $check_payment->payment_received : '' }}" {{ $disabled }} type="text" class="form-control form-payment-cashier" name="total" value="{{ $sum }}" />
                    <label class="form-label" style="color:#7d800d;padding-left:5px">Total pembayaran</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-float">
                <div class="form-line">
                    <input value="{{ isset($check_payment->payment_timestamp)? $check_payment->payment_timestamp : '' }}" {{ $disabled }} {{ $disabled }} type="text" class="form-control form-payment-cashier" name="payment_at" value="{{ date('Y-m-d H:i:s') }}" />
                    <label class="form-label" style="color:#7d800d;padding-left:5px">Waktu pembayaran (cth : 2019-05-18 16:11:00)</label>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            @if(!$check_payment)
                <input name="cd" id="cd" class="form-payment-cashier" type="hidden" value="{{ $cd_bkp }}" />
                <button id="pay_now" class="pull-right btn btn-primary" type="button"> Bayar Sekarang</button>
            @endif
            @if($check_payment)
                <form method="POST" action="kasir/invoice">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <input id="cd" name="cd" type="hidden" value="{{ $cd_bkp }}" />
                    <button class="pull-right btn btn-primary" type="submit"> Print Invoice</button>
                </form>
            @endif
        </div>
    </div> --}}

</div> 

<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));
    });
</script>
<style>
    .form-payment-cashier{
        padding-left:5px !important;
        padding-right:5px !important;
    }
    #entry_medicine .bootstrap-select{
        background-color:#398f34 !important;    
    }
    #entry_medicine .dropdown-toggle{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .filter-option{
        color:white;
        padding-top:5px;
    }
</style>