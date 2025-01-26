<fieldset>
    <legend>Status Pengguna</legend>
    <div class="row">
        <div class="col-lg-12">

            <div class="form-group">
                <div class="col-lg-3">
                    <label class="form-label">Status Pasien</label>
                </div>
                <div class="col-lg-9">
                    <span>: {{ $patient->status_pasien == 0 ? 'Sudah Aktif' : 'Belum Aktif' }}</span>
                </div>
            </div>
            <div class="col-lg-12"><hr></hr></div>

            <div class="form-group">
                <div class="col-lg-3">
                    <label class="form-label">Status User</label>
                </div>
                <div class="col-lg-9">
                    <span>: {{ $patient->state_row == 'Y' ? 'Aktif' : 'Sudah Dihapus' }}</span>
                </div>
            </div>
            <div class="col-lg-12"><hr></hr></div>

            <div class="form-group">
                <div class="col-lg-3">
                    <label class="form-label">Dibuat pada tanggal</label>
                </div>
                <div class="col-lg-3">
                    <span>: {{ date('d F Y', strtotime($patient->created_at)) }}  {{ date('h:i A', strtotime($patient->created_at)) }}</span>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Dibuat oleh</label>
                </div>
                <div class="col-lg-3">
                    <span>: {{ $patient->created_by }}</span>
                </div>
            </div>
            <div class="col-lg-12"><hr></hr></div>

            <div class="form-group">
                <div class="col-lg-3">
                    <label class="form-label">Diedit pada tanggal</label>
                </div>
                <div class="col-lg-3">
                    <span>: {{ date('d F Y', strtotime($patient->updated_at)) }} {{ date('h:i A', strtotime($patient->updated_at)) }}</span>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Diedit oleh</label>
                </div>
                <div class="col-lg-3">
                    <span>: {{ $patient->updated_by }}</span>
                </div>
            </div>
            <div class="col-lg-12"><hr></hr></div>



            <div class="form-group">
                <div class="col-lg-3">
                    <label class="form-label">Dihapus pada tanggal</label>
                </div>
                <div class="col-lg-3">
                    <span>: {{ date('d F Y', strtotime($patient->deleted_at)) }} {{ date('h:i A', strtotime($patient->deleted_at)) }}</span>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Dihapus oleh</label>
                </div>
                <div class="col-lg-3">
                    <span>: {{ $patient->deleted_by }}</span>
                </div>
            </div>
            <div class="col-lg-12"><hr></hr></div>


        </div>
        <div class="col-lg-12" style="padding:20px;background-color:#d8d8d8;border:1px">
            <div class="form-group">
                <div class="col-lg-4">
                    <label class="form-label">Total berobat</label>
                </div>
                <div class="col-lg-8">
                    <span>: {{ $booking_data->count() }} kali</span>
                </div>
                <div class="col-lg-12"><hr></hr></div>
            </div>
        </div>

    </div>
</fieldset>
<fieldset>
    <legend>Data Antrian</legend>
    <div class="row">
        <div class="col-lg-12" style="padding: 0 200px 0 200px">

            <input id="type" type="hidden" name="type" class="form-control" value="booking"  /> 
            <input id="code_patient_val" type="hidden" name="code_patient_val" class="form-control" value="{{ $patient->code_patient }}"  />


            <div class="form-group {{ $errors->has('id_rekam_medis') ? ' has-error' : '' }}">
                <label for="id_rekam_medis">ID Rekam Medis</label>
                <input id="id_rekam_medis" type="text" name="id_rekam_medis" class="form-control" value="{{ old('id_rekam_medis') }}" disabled /> 
                @if ($errors->has('id_rekam_medis'))
                    <span class="help-block">
                        <strong>{{ $errors->first('id_rekam_medis') }}</strong>
                    </span> 
                @endif
            </div>

            <div class="form-group {{ $errors->has('booking_tanggal') ? ' has-error' : '' }}">
                <label for="booking_tanggal">Tanggal Pemeriksaan</label>
                <div id="booking_tanggal" class="datepicker input-group date" data-date-format="yyyy-mm-dd">
                    <input type="text" name="booking_tanggal" class="form-control" placeholder="Pilih tanggal pemeriksaan" 
                        style="background-color:white; cursor:pointer;">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>

                @if ($errors->has('booking_tanggal'))
                    <span class="help-block">
                        <strong>{{ $errors->first('booking_tanggal') }}</strong>
                    </span> 
                @endif
            </div>

            <div class="form-group {{ $errors->has('booking_dokter') ? ' has-error' : '' }}">
                <label for="booking_dokter">Booking Dokter</label>
                <select id="booking_dokter" name="booking_dokter" class="form-control select2" required disabled>
                    <option selected="selected" disabled>Pilih Dokter</option>
                    <option value=""></option>
                    @foreach($getDokter as $dokter)
                        <option value="{{ $dokter->code_docter }}">{{ $dokter->nama_dokter }}</option>
                    @endforeach
                </select>                         
                @if ($errors->has('booking_dokter'))
                    <span class="help-block">
                        <strong>{{ $errors->first('booking_dokter') }}</strong>
                    </span> 
                @endif
            </div>

            <div class="form-group {{ $errors->has('booking_jam') ? ' has-error' : '' }}">
                <label for="booking_jam">Booking Jam</label>

                <select id="booking_jam" name="booking_jam" class="form-control select2" required disabled>
                    <option selected="selected" disabled>Booking Jam</option>
                    <option value=""></option>
                </select>                                  
                @if ($errors->has('booking_jam'))
                    <span class="help-block">
                        <strong>{{ $errors->first('booking_jam') }}</strong>
                    </span> 
                @endif
            </div>


            <div class="form-group {{ $errors->has('keluhan') ? ' has-error' : '' }}">
                <label for="keluhan">Keluhan / Tujuan Pemeriksaan</label>
                <textarea id="keluhan" type="text" name="keluhan" class="form-control" placeholder="Masukan keluhan/tujuan pemeriksaan . . ." disabled></textarea>                              
                @if ($errors->has('keluhan'))
                    <span class="help-block">
                        <strong>{{ $errors->first('keluhan') }}</strong>
                    </span> 
                @endif
            </div>

        </div>
        
        <div class="col-lg-12 " style="margin-top:50px">
            <span class="pull-right">Note : Pastikan data yang anda isi benar dan sesuai prosedur. </span>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend>Selesai</legend>
    <div class="row">
        <div class="col-lg-12" style="padding: 0 100px 0 100px">
        
            <p> Anda akan mendaftar untuk melakukan pemeriksaan dengan data sebagai berikut : </p>
            <div class="col-sm-12" style="padding:20px;border:1px solid;background-color: #c6d7e7;">
                <div class="form-group col-sm-12">
                    <span class="col-sm-5">
                        <label for="keluhan">ID Rekam Medis</label>
                    </span>
                    <span class="col-sm-7">
                    : <span>{{ $patient->id_rekam_medis }}</span>
                    </span>
                </div>
                <div class="form-group col-sm-12">
                    <span class="col-sm-5">
                        <label for="keluhan">Atas Nama</label>
                    </span>
                    <span class="col-sm-7">
                    : <span>{{ $patient->gelar.' '.$patient->nama_pasien }} <i>{{ '('.$patient->nik.') ' }}</i></span>
                    </span>
                </div>
                <div class="form-group col-sm-12">
                    <span class="col-sm-5">
                        <label for="keluhan">Melakukan pendaftaran pada tanggal</label>
                    </span>
                    <span class="col-sm-7">
                    : <span>{{ date('d F Y') }}</span>
                    </span>
                </div>
                <div class="form-group col-sm-12">
                    <span class="col-sm-5">
                        <label for="keluhan">Dengan dokter</label>
                    </span>
                    <span class="col-sm-7">
                    : <span id="sum-dok" style="color:red">Belum diinput</span>
                    </span>
                </div>
                <div class="form-group col-sm-12">
                    <span class="col-sm-5">
                        <label for="keluhan">Untuk Jam</label>
                    </span>
                    <span class="col-sm-7">
                    : <span id="sum-jam" style="color:red">Belum diinput</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-12 " style="margin-top:50px">
            <span class="pull-right">Note : Pastikan data benar dan sesuai prosedur. Klik tombol selesai apabila data sudah sesuai. </span>
        </div>
        
    </div>
</fieldset>
<style>
hr{
    border-top:1px solid #a7a7a7;
}

</style>

<script>
$(document).ready(function(){
    setTimeout(function(){ $('.sf-nav-subtext:contains("Kesimpulan")').parent().css('margin-right', 0); }, 1000);

    var booking_dokter = $('#booking_dokter')
    var booking_jam = $('#booking_jam')
    var keluhan = $('#keluhan')
    var sum_dok = $('#sum-dok')

    $("#booking_tanggal").on("changeDate", function() {
        $.ajax({
            url: '/docters',
            type: 'GET',
            data: {
                date: $(this).find('input').val()
            }
        })
        .done(function(data) {
            booking_dokter.prop('disabled', false)

            booking_dokter.find('option').remove()
            booking_dokter.append('<option disabled selected>Pilih Dokter</option>')
            $.each(data, function(index, item){
                booking_dokter.append($("<option />").val(item.code_docter).text(item.nama_dokter))
            })
        })
        .fail(function(jqXHR, textStatus, errorThrown) { console.error(jqXHR) })
    })

    booking_dokter.on('change', function(){
        $.ajax({
            url: '/docters/schedule',
            type: 'GET',
            data: {
                code_docter: booking_dokter.val(),
                date: $("#booking_tanggal").find('input').val()
            }
        })
        .done(function(data) {
            sum_dok.text($('#booking_dokter option:selected').text())
            sum_dok.css("color", "#333")

            booking_jam.prop('disabled', false)
            keluhan.prop('disabled', false)
            
            booking_jam.find('option').remove()
            booking_jam.append('<option disabled selected>Pilih Jam Dokter</option>')
            $.each(data, function(index, item){
                booking_jam.append($("<option />").val(item.code_us_docter_schedule_time).text(`${item.time_start} - ${item.time_end}`))
            })
        })
        .fail(function(jqXHR, textStatus, errorThrown) { console.error(jqXHR) })
    })
})
</script>