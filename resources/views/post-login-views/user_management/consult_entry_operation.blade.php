<link href="{{ asset('adminbsb/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
<div id="entry-operasi">
    <div class="col-sm-12" style="padding-top:20px;padding-left:32px;padding-right:32px">
        <label class="form-label">Persetujuan Operasi</label>
        <div class="col-sm-12" style="padding:15px;border:5px solid !important;background-color:#7ED5CC !important">
            <form id="wizard_with_validation">
                    <h3>Information</h3>
                    <fieldset>
                        <div class="col-sm-12" style="padding-top:20px">

                            <div class="form-group form-float">
                            <label class="form-label">Jenis Operasi</label>
                                <select {{ $disabled }} id="jenis_operasi" name="jenis_operasi" style="background-color:#45c3d8" required class="form-control show-tick" data-live-search="true" style="background-color:aliceblue;color:white" >
                                    <option></option>
                                    @foreach($operation_type as $data)
                                        <option value="{{ $data->code_operation_step }}" {{ isset($agree->code_operation_step)? ($data->code_operation_step == $agree->code_operation_step)? ' selected ' : '' : '' }} >{{ $data->name_operation_step }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                
                        <div class="col-sm-12" {{ isset($selected_operation_type)? '' : 'style="display:none"' }} id="operation-section">
                            <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingOne_1">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#1_diagnosis_kerja" aria-expanded="true" aria-controls="1_diagnosis_kerja">
                                                #1 Diagnosis Kerja 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="1_diagnosis_kerja" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->diagnosis_kerja)? $selected_operation_type->diagnosis_kerja : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingTwo_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#2_diagnosis_banding" aria-expanded="false"
                                                aria-controls="2_diagnosis_banding">
                                                #2 Diagnosis Banding
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="2_diagnosis_banding" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_1">
                                        <div class="panel-body">
                                        <i>{{ isset($selected_operation_type->diagnosis_banding)? $selected_operation_type->diagnosis_banding : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingThree_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#3_tindakan_kedokteran" aria-expanded="false"
                                                aria-controls="3_tindakan_kedokteran">
                                                #3 Tindakan Kedokteran
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="3_tindakan_kedokteran" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->tindakan_kedokteran)? $selected_operation_type->tindakan_kedokteran : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingFour_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#4_indikasi_tindakan" aria-expanded="false"
                                                aria-controls="4_indikasi_tindakan">
                                                #4 Indikasi Tindakan
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="4_indikasi_tindakan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour_1">
                                        <div class="panel-body">
                                        <i>{{ isset($selected_operation_type->indikasi_tindakan)? $selected_operation_type->indikasi_tindakan : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingFive_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#5_tata_cara" aria-expanded="false"
                                                aria-controls="5_tata_cara">
                                                #5 Tata Cara
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="5_tata_cara" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->tata_cara)? $selected_operation_type->tata_cara : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingSix_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#6_tujuan" aria-expanded="false"
                                                aria-controls="6_tujuan">
                                                #6 Tujuan
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="6_tujuan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->tujuan)? $selected_operation_type->tujuan : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingSeven_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#7_resiko_tindakan" aria-expanded="false"
                                                aria-controls="7_resiko_tindakan">
                                                #7 Resiko Tindakan
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="7_resiko_tindakan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->resiko_tindakan)? $selected_operation_type->resiko_tindakan : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingEight_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#8_komplikasi" aria-expanded="false"
                                                aria-controls="8_komplikasi">
                                                #8 Komplikasi
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="8_komplikasi" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->komplikasi)? $selected_operation_type->komplikasi : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingNine_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#9_prognosis" aria-expanded="false"
                                                aria-controls="9_prognosis">
                                                #9 Prognosis
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="9_prognosis" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->prognosis)? $selected_operation_type->prognosis : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingTen_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#10_alternatif_dan_resiko" aria-expanded="false"
                                                aria-controls="10_alternatif_dan_resiko">
                                                #10 Alternatif Dan Resiko
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="10_alternatif_dan_resiko" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->alternatif_dan_resiko)? $selected_operation_type->alternatif_dan_resiko : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingEleven_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#11_lain" aria-expanded="false"
                                                aria-controls="11_lain">
                                                #11 Lain-lain
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="11_lain" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEleven_1">
                                        <div class="panel-body">
                                            <i>{{ isset($selected_operation_type->lain_lain)? $selected_operation_type->lain_lain : 'Nothing Selected' }}</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding-top:30px">
                            <div class="form-group form-float" style="text-align:center">
                                <input {{ $disabled }} id="agreement_check" name="agreement_check" required class="chk-col-black"  {{ isset($agree->isAgree)? ' checked ' : ''}} type="checkbox">
                              
                                <label for="agreement_check" style="color:black;font-size:15px"> <b>Bersedia menjalani tindakan operasi </b></label>
                                </div>  
                                <div style="text-align:center;color:#026565;"><i>Pasien wajib menyetujui tindakan operasi terlebih dahulu bersama wali/saksi setelah diberikan informasi tentang tindakan bedah</i></div>
                            
                        </div>
                    </fieldset>

                    <h3>Agreement</h3>

                    <fieldset>

                        <div class="col-sm-12" style="padding-top:20px">
                            <div class="form-group form-float">
                                
                                <label class="form-label" style="color:#2a844e;padding-left:5px">Dokter Pelaksana Tindakan</label>

                                <select {{ $disabled }} id="docter_code_of_operation" name ="docter_code_of_operation" style="background-color:#45c3d8" required class="form-control show-tick" data-live-search="true" style="background-color:aliceblue;color:white" required>
                                    <option></option>
                                    @foreach($dokter as $data)
                                        <option value="{{ $data->code_docter }}"  {{ isset($agree->docter_code_of_operation)? ($data->code_docter == $agree->docter_code_of_operation)? ' selected ' : '' : '' }} >{{ $data->nama_dokter }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br/>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" {{ $disabled }} name="informers" required class="form-control form-normal" id="informers" value=" {{ isset($agree->informers)?  $agree->informers :  '' }}" />
                                    <label class="form-label" style="color:#2a844e;padding-left:5px">Pemberi Informasi (Jabatan)</label>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input {{ $disabled }} type="text" name="recipient_of_information" class=" required form-control form-normal" id="recipient_of_information" value="{{ isset($agree->recipient_of_information)? $agree->recipient_of_information : ''  }}" />
                                    <label class="form-label" style="color:#2a844e;padding-left:5px">Penerima Informasi / Pemberi Persetujuan (Hubungan dengan pasien)</label>
                                </div>
                            </div>

                            <div  class="col-sm-6">
                                <label class="form-label">TTD Dokter</label>
                                <div id="sig"></div>
                                <button id="clear1" type="button">Clear</button>
                            </div>
                            <div  class="col-sm-6">
                                <label class="form-label">TTD Pasien/Wali</label>
                                <div id="sig2"></div>
                                <button id="clear2" type="button">Clear</button>
                            </div>
                        </div>

                    </fieldset>

                    <h3>Laboratorium</h3>
                    <fieldset>
                        <label class="form-label" style="color:#203cb6">Daftar Pemeriksaan Lab</label>
                        <div class="col-sm-12" style="padding-left:0px;padding-right:0px;padding-top:20px;padding-bottom:20px;background-color:aliceblue">

                            @php $x = 1 @endphp
                            @foreach($allLab as $data)
                                @if(($x - 1) % 3 == 0 or $x == 1)
                                    <div class="col-sm-12" style="margin-bottom:0px">
                                @endif
                                <div class="col-sm-4" style="margin-bottom:0px">
                                    <input {{ $disabled }} id="lab_{{$data->id}}" name="lab[{{$data->code_lab}}]" class="form-entry-lab chk-col-red lab-check" type="checkbox" {{ isset($lab['code'])? in_array($data->code_lab, $lab['code'])? ' checked ' : '' : ''}}>
                                    <label for="lab_{{$data->id}}" style="color:black">{{ $data->detail_lab}} </label>
                                </div>
                                @if($x % 3 == 0 or $allLabcount == $x)
                                    </div>
                                @endif
                                @php $x++ @endphp
                            @endforeach
                        </div>
                        <div class="col-sm-12" style="padding-left:0px;padding-right:0px">
                            <br/>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea {{ $disabled }} rows="1"  id="ket_lab" class="form-control no-resize auto-growth" style="color:black;overflow: hidden; overflow-wrap: break-word; height: 32px;">{{ isset($lab['ket'])? $lab['ket'] : '' }}</textarea>
                                    <label class="form-label" style="color:#2a844e;padding-left:5px;">Keterangan</label>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                    <h3>Message</h3>
                    <fieldset>
                        
                    <div class="info-box bg-green" style="height:110px">
                        <div class="icon" style="padding-top:10px">
                            <i class="material-icons">done</i>
                        </div>
                        <div class="content"><div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20" style="margin-top:5px">KLIK FINISH UNTUK SIMPAN</div>
                            <div class="text" style="margin-top:0px">Anda telah melakukan pengisian pasien untuk tindakan bedah/operasi. Silahkan review kembali isian anda sebelum di simpan dan data masuk dan di proses pada bagian laboratorium & operasi.</div>
                            
                        </div>
                    </div>
                        
                    </fieldset>
                </div>
            
        </div>
    </div>
    <div class="col-sm-12" style="padding-left:30px;padding-right:30px">
        <hr style="border-color:#80b7ff" />
    </div>
</div>

<input id="sig_json"  value="{{ isset($agree->docter_signature_JSON)? $agree->docter_signature_JSON : '' }}" type="hidden" />
<input id="sig_json2" value="{{ isset($agree->patient_signature_JSON)? $agree->patient_signature_JSON : '' }}" type="hidden" />


<script src="{{ asset('adminbsb/js/pages/ui/tooltips-popovers.js') }}"></script>
<div id="tag-scripts"></div>


        <script>
        var steps = "<?php echo asset('adminbsb/plugins/jquery-steps/jquery.steps.js') ?>";
        var wizard = "<?php echo asset('adminbsb/js/pages/forms/form-wizard.js') ?>";

            setTimeout(function () { 
                $('#tag-scripts').empty();


        
                if(new_op != "Z"){
                    var form = $('#wizard_with_validation').show();
                    form.steps({
                        headerTag: 'h3',
                        bodyTag: 'fieldset',
                        transitionEffect: 'slideLeft',
                        onInit: function (event, currentIndex) {
                            $.AdminBSB.input.activate();


                            var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
                            var tabCount = $tab.length;
                            $tab.css('width', (100 / tabCount) + '%');


                            setButtonWavesEffect(event);
                        },
                        onStepChanging: function (event, currentIndex, newIndex) {
                            if (currentIndex > newIndex) { return true; }

                            if (currentIndex < newIndex) {
                                form.find('.body:eq(' + newIndex + ') label.error').remove();
                                form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                            }

                            form.validate().settings.ignore = ':disabled,:hidden';
                            return form.valid();
                        },
                        onStepChanged: function (event, currentIndex, priorIndex) {
                            setButtonWavesEffect(event);
                        },
                        onFinishing: function (event, currentIndex) {
                            form.validate().settings.ignore = ':disabled';
                            return form.valid();
                        },
                        onFinished: function (event, currentIndex) {

                            if(!$('.modal-body').find('#disabled_state').length){
                            $.ajax({
                                url: $('.mainurl').val() +'/konsultasi/store_operasi',
                                type: "POST",
                                data:{
                                    _token              : $('meta[name="csrf-token"]').attr('content'),
                                    cd_bkd              : $('#queue').val(),


                                    jenis_operasi               : $('#jenis_operasi').val(),
                                    agreement_check             : (typeof($('#agreement_check:checked').val()) != "undefined" && $('#agreement_check:checked').val() !== null)? 1 : 0,


                                    docter_code_of_operation    : $('#docter_code_of_operation').val(),
                                    informers                   : $('#informers').val(),
                                    recipient_of_information    : $('#recipient_of_information').val(),

                                    docter_signature_JSON       : sig.signature('toJSON'),
                                    docter_signature_JPEG      : sig.signature("toDataURL", 'image/jpeg'),
                                    patient_signature_JSON       : sig2.signature('toJSON'),
                                    patient_signature_JPEG      : sig2.signature("toDataURL", 'image/jpeg'),


                                    lab                 : $( ".form-entry-lab" ).serializeArray(),
                                    ket_lab             : $('#ket_lab').val(),
                                    
                                },
                                cache: false,
                                success:function(data)
                                {
                                    var data = $.parseJSON(data);
                                    
                                    if(data[0] == 0){
                    
                                        var tipe = 'danger';
                                        var timer = 1000;
                    
                                    }else{
                    
                                        swal("Good job!", "Submitted!", "success");
                                        
                                        var tipe = 'success';
                                        var timer = 4000;
                    
                                    }
                    
                                    $.notify({
                                        message: data[1]
                                    },
                                        {
                                            type:tipe,
                                            allow_dismiss: true,
                                            newest_on_top: true,
                                            z_index: 9999,
                                            timer: 4000,
                                            placement: {
                                                from: 'top',
                                                align: 'center'
                                            },
                                        });
                                }
                            });
                        }else{
                            alert('Data tidak dapat dirubah! data sudah masuk ke dalam form laboratorium.');
                        }
                        }
                    });
                }
                $.AdminBSB.browser.activate();
                $.AdminBSB.leftSideBar.activate();
                $.AdminBSB.rightSideBar.activate();
                $.AdminBSB.navbar.activate();
                $.AdminBSB.dropdownMenu.activate();
                $.AdminBSB.input.activate();
                $.AdminBSB.select.activate();
                $.AdminBSB.search.activate();
                $('.page-loader-wrapper').fadeOut(); 


                var sig = $('#sig').signature();
                var sig2 = $('#sig2').signature();

                $(function () {

                    sig.signature('enable').signature('draw', $('#sig_json').val());
                    sig2.signature('enable').signature('draw', $('#sig_json2').val());

                    $('#clear1').click(function() {
                        sig.signature('clear');
                    });

                    $('#clear2').click(function() {
                        sig2.signature('clear');
                    });

                });
            }, 100);
        </script>

<!-- Sweet Alert Plugin Js -->
<script src="{{ asset('adminbsb/plugins/sweetalert/sweetalert.min.js') }}"></script>
<style>
    .kbw-signature { width: 320px; height: 200px; }
</style>
<script>
    
    
</script>

@if(isset($agree)) 
    <script>
        $(function () {

            $('#wizard_with_validation').find('.disabled').addClass('done');
            $('#wizard_with_validation').find('.disabled').removeClass('disabled');

        });
    </script>
@endif