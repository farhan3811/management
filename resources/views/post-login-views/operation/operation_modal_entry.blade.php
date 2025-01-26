<div id="entry_medicine">
    <style>
    .form-normal{
        background-color:#fff7d4;
        color:#6f6f6f;
        text-transform: capitalize;
        padding-left:7px !important;
        border-radius: 3px !important;
        border:solid 1px #d2d2d2 !important;
    }
    .modal-body  .form-label{
        color:#109e1b !important; 
        padding-left:5px;
    }
    </style>

    <div class="row clearfix">
        <input id="cd_agree" type="hidden" value="{{ $cd_bkp }}" />
        @if($result->count())
        @php $result = $result->get()->first() @endphp
            <input id="cd_op" type="hidden" value="{{ $result->code_operation }}" />
            <div class="col-sm-12" style="text-align:center">
                <label class="form-label"><h3>Lembar Laporan Operasi</h3></label>
            </div>
            <div class="col-sm-12" style="padding-top:40px">

                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input id ="nama_pasien" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->nama_pasien)? $result->nama_pasien : '' }}">
                                <label class="form-label" style="color:white">Nama Pasien</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input id ="kelamin" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                    isset($result->jenis_kelamin)? 
                                        ($result->jenis_kelamin == 'L')? 
                                            'Laki-laki' 
                                        : ($result->jenis_kelamin == 'P')? 
                                            'Perempuan' 
                                        : 'Tidak Diketahui' 
                                    : '' }}">
                                <label class="form-label" style="color:white">Kelamin</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input id ="umur" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                    isset($result->tanggal_lahir)? 
                                    date_diff(date_create($result->tanggal_lahir), date_create($result->created_at))->y
                                    : '' }}">
                                <label class="form-label" style="color:white">Umur</label>
                            </div>
                        </div>
                    </div>
                    
            </div>


            <div class="col-sm-12" style="padding-top:40px">

                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="diagnosa_pra_bedah" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->name_operation_step)? $result->name_operation_step : '' }}">
                            <label class="form-label" style="color:white">Diagnosa Pra Bedah</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="diagnosa_pasca_bedah" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->diagnosa_pasca_bedah)? $result->diagnosa_pasca_bedah : '' }}">
                            <label class="form-label" style="color:white">Diagnosa Pasca Bedah</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input style="font-size:18px" id ="kelamin" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->tanggal_operasi)? 
                                date('d-M-Y', strtotime( $result->tanggal_operasi))
                                : '' }}">
                            <label class="form-label" style="color:white">Tanggal Operasi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="mulai_jam_operasi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->mulai_jam_operasi)? 
                                $result->mulai_jam_operasi
                                : '' }}">
                            <label class="form-label" style="color:white">Mulai Jam</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="berhenti_jam_operasi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->berhenti_jam_operasi)? 
                                $result->berhenti_jam_operasi
                                : '' }}">
                            <label class="form-label" style="color:white">Berhenti Jam</label>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-sm-12" style="padding-top:40px">

                    <div class="col-sm-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input id ="jenis_operasi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->jenis_operasi)? $result->jenis_operasi : '' }}">
                                <label class="form-label" style="color:white">Jenis Operasi</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input id ="tanggal_lahir" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->tanggal_lahir)? $result->tanggal_lahir : '' }}">
                                <label class="form-label" style="color:white">Tanggal Lahir</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                            <input id ="nama_operator" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->nama_operator)? $result->nama_operator : '' }}">
                                <label class="form-label" style="color:white">Nama Operator</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                            <input id ="kualifikasi_operator" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->kualifikasi_operator)? $result->kualifikasi_operator : '' }}">
                                <label class="form-label" style="color:white">Kualifikasi</label>
                            </div>
                        </div>
                    </div>
                    
            </div>

            <div class="col-sm-12" style="padding-top:40px">

                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="asisten" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->asisten)? $result->asisten : '' }}">
                            <label class="form-label" style="color:white">Asisten</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="scrub_nurse_I" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->scrub_nurse_I)? $result->scrub_nurse_I : '' }}">
                            <label class="form-label" style="color:white">Scrub Nurse I</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input style="font-size:18px" id ="scrub_nurse_II" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->scrub_nurse_II)? 
                                date('d-M-Y', strtotime( $result->scrub_nurse_II))
                                : '' }}">
                            <label class="form-label" style="color:white">Scrub Nurse II</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="circulated_nurse" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->circulated_nurse)? 
                                $result->circulated_nurse
                                : '' }}">
                            <label class="form-label" style="color:white">Circulated Nurse</label>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-sm-12" style="padding-top:40px">

                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="jenis_anestesi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->jenis_anestesi)? $result->jenis_anestesi : '' }}">
                            <label class="form-label" style="color:white">Jenis Anestesi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="mulai_jam_anestesi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->mulai_jam_anestesi)? $result->mulai_jam_anestesi : '' }}">
                            <label class="form-label" style="color:white">Mulai Jam</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input style="font-size:18px" id ="berhenti_jam_anestesi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->berhenti_jam_anestesi)? 
                                date('d-M-Y', strtotime( $result->berhenti_jam_anestesi))
                                : '' }}">
                            <label class="form-label" style="color:white">Berhenti Jam</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="bahan_anesteticum" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->bahan_anesteticum)? 
                                $result->bahan_anesteticum
                                : '' }}">
                            <label class="form-label" style="color:white;font-size:11px">Bahan Anesteticum</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="nama_anestesist" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->nama_anestesist)? 
                                $result->nama_anestesist
                                : '' }}">
                            <label class="form-label" style="color:white;font-size:11px">Nama Anestesist</label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="kualifikasi_anestesist" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->kualifikasi_anestesist)? 
                                $result->kualifikasi_anestesist
                                : '' }}">
                            <label class="form-label" style="color:white">Kualifikasi</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12" style="padding-top:40px">

                <div class="col-sm-4">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="golongan_operasi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ isset($result->golongan_operasi)? $result->golongan_operasi : '' }}">
                            <label class="form-label" style="color:white;font-size:13px">Golongan Operasi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="macam_operasi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->macam_operasi)? $result->macam_operasi : '' }}">
                            <label class="form-label" style="color:white">Macam Operasi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id ="urgensi_operasi" type="text" {{ $disabled }} class="form-control form-normal" value="{{ 
                                isset($result->urgensi_operasi)? 
                                date('d-M-Y', strtotime( $result->urgensi_operasi))
                                : '' }}">
                            <label class="form-label" style="color:white">Urgensi Operasi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                        <textarea rows="10" id="catatan_operator" {{ $disabled }} class="form-control form-normal">{{isset($result->catatan_operator) ? $result->catatan_operator : ''}}</textarea>
                           <label class="form-label" style="color:white">Catatan Operator</label>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- <div class="col-sm-12" style="padding-top:40px">

                <div class="col-sm-3">
                    <label class="form-label" style="color:white"><h4>No. Isi Laporan</h4></label>
                </div>
                <div class="col-sm-9">
                    <label class="form-label" style="color:white"><h4>Penjelasan Teknik Operasi Secara Kronologis</h4></label>
                </div>
                
            </div> -->

            <!-- <div class="col-sm-12" style="padding-top:40px">

                <table class="table">
                    <tbody>
                        <tr>
                            <td width="25%">Persiapan Operasi</td>
                            <td> <input name ="circulated_nurse" type="text" {{ $disabled }} class="form-control " value="{{ 
                                isset($result->circulated_nurse)? 
                                $result->circulated_nurse
                                : '' }}"></td>
                        </tr>
                        <tr>
                            <td width="25%">Posisi Pasien</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
            </div> -->

            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-6 ">
                    <div style="padding-left:180px">
                    <input {{ (isset($billed)? ($billed > 0)?  " checked "  : "" : "") }} disabled id="tagihan" class="filled-in chk-col-teal"  type="checkbox" />
                    <label for="tagihan" id="tagihan-label" style="color:black">Masukkan ke tagihan <b>({{ $billed }})</b> </label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style="padding-left:100px">
                        <input {{ $disabled }} id="selesai" class="filled-in chk-col-teal" type="checkbox" {{ (isset($result->is_done)? ($result->is_done == 'Y')?  " checked "  : "" :  "") }}>
                        <label for="selesai" style="color:black">Sudah Selesai</label>
                    </div>
                </div>
            </div>
        @else

            <div class="col-sm-12" style="padding-top:20px;text-align:center">
                <label class="form-label" style="color:#757575">Klik tombol di bawah untuk memulai operasi</label>
                <div class="col-sm-12" style="padding-top:20px">
                    <button id="start-operation" class="btn btn-success btn-flat"> Mulai Operasi</button>
                    
                </div>
            </div>
        @endif
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));var disabled = '{{ $disabled }}';
        $("#tagihan-label").popover({
            placement: 'top',
            container: '#largeModal',
            html: true,
            content: function () {
                $.ajax({
                    url: $('.mainurl').val() +'/getListPrice/OPERATION/'+$('#cd_agree').val()+'/'+ disabled ,
                    type: "get",
                    cache: false,
                    async: false,
                    success:function(data)
                    {
                        asd = data;
               
                    },
                });
                return asd;
                
            }
        }).on("show.bs.popover", function(){ $(this).data("bs.popover").tip().css("max-width", "600px"); });   


        $(".modal").on("hide.bs.modal", function(event) {
            $('.popover').popover('destroy');
        });
    });
</script>
<style>
    #entry_medicine .bootstrap-select{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .dropdown-toggle{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .filter-option{
        color:white;
        padding-top:5px
    }
</style>