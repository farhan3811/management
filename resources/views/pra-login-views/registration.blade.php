
<fieldset>
<style>
label{
    color:#504d4d !important;
}
</style>
    <legend>Informasi Data Pasien</legend>
    @include('_partial.flash_message')
    <input id="type" type="hidden" name="type" class="form-control" value="registration" {{ $disabled }} /> 
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group {{ $errors->has('nama_pasien') ? ' has-error' : '' }}">
                <label for="nama_pasien" style="display: block;">Nama Pasien</label>
                <select name="gelar" id="gelar" class="form-control select2" style="width: 20%; display: inline;">
                    <option selected="selected" disabled>Pilih Gelar {{old('gelar') }}</option>
                    <option value=""></option>
                    <option value="Tn/Mr" @if(old('gelar') == 'Tn/Mr') {{ ' selected '}} @endif >Tn/Mr</option>
                    <option value="Ny/Mrs" @if(old('gelar') == 'Ny/Mrs') {{ ' selected '}} @endif >Ny/Mrs</option>
                    <option value="An" @if(old('gelar') == 'An') {{ ' selected '}} @endif >An</option>
                </select>
                <input id="nama_pasien" type="text" name="nama_pasien" class="form-control" style="width: 79%; display: inline;" value="{{ old('nama_pasien') }}" placeholder="Masukkan nama lengkap anda" autofocus {{ $disabled }} /> @if($errors->has('nama_pasien'))
                <span class="help-block">
                    <strong>{{$errors->first('gelar')}}</strong><br>
                    <strong>{{ $errors->first('nama_pasien') }}</strong>
                </span> @endif
            </div>
            <div class="col-lg-12" style="padding:0">
                <div class="col-lg-6" style="padding-left:0px;padding-right:10px">
                    <div class="form-group {{ $errors->has('jenis_kelamin') ? ' has-error' : '' }}">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        @if(!$disabled)
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2"  {{ $disabled }}>
                                <option selected="selected" disabled>Pilih Jenis Kelamin {{old('jenis_kelamin') }}</option>
                                <option value=""></option>
                                <option value="L" @if(old('jenis_kelamin') == 'L') {{ ' selected '}} @endif >Laki-Laki</option>
                                <option value="P" @if(old('jenis_kelamin') == 'P') {{ ' selected '}} @endif >Perempuan</option>
                            </select> 
                        @else
                            <input id="jenis_kelamin" type="text" name="jenis_kelamin" class="form-control" value="{{ old('jenis_kelamin') }}" value="@if(old('jenis_kelamin') == 'L') {{ ' Laki-laki '}} @elseif(old('jenis_kelamin') == 'P') {{ ' Perempuan '}} @endif " placeholder="Masukkan jenis kelamin anda.." autofocus {{ $disabled }} /> 

                        @endif
                        
                        @if ($errors->has('jenis_kelamin'))
                            <span class="help-block">
                                <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                            </span> 
                        @endif
                    </div>
                </div>
                <div class="col-lg-6" style="padding:0px;">
                    <div class="form-group {{ $errors->has('gol_darah') ? ' has-error' : '' }}">
                        <label for="gol_darah">Golongan Darah</label>
                        @if(!$disabled)
                            <select id="gol_darah" name="gol_darah" class="form-control select2"  {{ $disabled }}>
                                <option selected="selected" disabled>Pilih Golongan Darah</option>
                                <option value="A"  @if(old('gol_darah') == 'A') {{ ' selected '}} @endif >A</option>
                                <option value="B" @if(old('gol_darah') == 'B') {{ ' selected '}} @endif>B</option>
                                <option value="AB" @if(old('gol_darah') == 'AB') {{ ' selected '}} @endif>AB</option>
                                <option value="O" @if(old('gol_darah') == 'O') {{ ' selected '}} @endif>O</option>
                                <option value="Lainnya" @if(old('gol_darah') == 'Lainnya') {{ ' selected '}} @endif>Lainnya</option>
                            </select> 
                        
                        @else
                            <input id="gol_darah" type="text" name="gol_darah" class="form-control" value="{{ old('gol_darah') }}" value="old('gol_darah')" placeholder="Masukkan golongan darah anda.." autofocus {{ $disabled }} /> 

                        @endif

                        @if ($errors->has('gol_darah'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gol_darah') }}</strong>
                        </span> @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding:0">
                <div class="col-lg-6" style="padding-left:0px;padding-right:10px">
                    <div class="form-group {{ $errors->has('provinsi_pasien') ? ' has-error' : '' }}">
                        <label for="provinsi_pasien">Provinsi Tinggal</label>
                        @if(!$disabled)
                            <select id="provinsi_pasien" name="provinsi_pasien" class="form-control select2"  {{ $disabled }}>
                                <option disabled selected>Pilih Provinsi</option>
                                @foreach ($provinsi as $key => $value)
                                    <option value="{{ $key }}"  @if(old('provinsi_pasien') ==  $key ) {{ ' selected '}} @endif>{{ $value }}</option>
                                @endforeach
                            </select> 
                        
                        @else
                            <input id="provinsi_pasien" type="text" name="provinsi_pasien" class="form-control" value="{{ old('provinsi_pasien_name') }}" placeholder="Masukkan golongan darah anda.." autofocus {{ $disabled }} /> 

                        @endif

                        @if ($errors->has('provinsi_pasien'))
                        <span class="help-block">
                            <strong>{{ $errors->first('provinsi_pasien') }}</strong>
                        </span> @endif
                    </div>
                </div>
                <div class="col-lg-6" style="padding:0">
                    <div class="form-group {{ $errors->has('kota_pasien') ? ' has-error' : '' }}">
                        <label for="kota_pasien">Kabupaten Tinggal</label>

                        @if(!$disabled)

                            <select id="kota_pasien" name="kota_pasien" class="form-control select2" {{ $disabled }}>
                                <option disabled selected>Pilih Kabupaten</option>
                                @if($kabupaten)
                                    @foreach($kabupaten as $key => $value)
                                        <option value="{{ $key }}"  @if(old('kota_pasien') ==  $key ) {{ ' selected '}} @endif>{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select> 

                        @else
                            <input id="kota_pasien" type="text" name="kota_pasien" class="form-control" value="{{ old('kota_pasien_name') }}" placeholder="Masukkan kota anda.." autofocus {{ $disabled }} /> 
                        @endif

                        @if ($errors->has('kota_pasien'))
                            <span class="help-block">
                                <strong>{{ $errors->first('kota_pasien') }}</strong>
                            </span> 
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('alamat') ? ' has-error' : '' }}">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" placeholder="Masukkan alamat anda"></textarea>
                <span class="help-block">
                    <strong>{{ $errors->first('alamat') }}</strong>
                </span>
            </div>
        </div>

        <div class="col-lg-6">

            <div class="form-group {{ $errors->has('nik') ? ' has-error' : '' }}">
                <label for="nik">Nomor Identitas (KTP)</label>
                <input id="nik" type="text" class="form-control" value="{{ old('nik') }}" maxlength="16"
                    minlength="16" name="nik" placeholder="Masukkan nomor identitas anda" autofocus {{ $disabled }} /> 
                    @if($errors->has('nik'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nik') }}</strong>
                        </span> 
                    @endif
            </div>
            <div class="col-lg-12" style="padding:0">
                <div class="col-lg-6" style="padding-left:0px;padding-right:10px">
                    <div class="form-group {{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <div class="datepicker input-group date" data-date-format="yyyy-mm-dd">
                            <input  {{ ($disabled == false)? ' style=background-color:white;cursor:pointer ' : '' }} 
                                class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" type="text" readonly class="form-control" placeholder="Contoh : 1994/12/20" data-error="Anda Belum MeMasukkan Tanggal Lahir.." required  {{ $disabled }} />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div> 
                        @if($errors->has('tanggal_lahir'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6" style="padding:0px;">
                    <div class="form-group {{ $errors->has('telepon') ? ' has-error' : '' }}">
                        <label for="telepon">Telepon</label>
                        <input id="telepon" type="number" name="telepon" value="{{ old('telepon') }}"
                            class="form-control" placeholder="Masukkan No.Telp anda" autofocus  {{ $disabled }} /> 
                        @if($errors->has('telepon'))
                            <span class="help-block">
                                <strong>{{ $errors->first('telepon') }}</strong>
                            </span> 
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding:0">
                <div class="col-lg-6" style="padding-left:0px;padding-right:10px">
                    <div class="form-group {{ $errors->has('kecamatan_pasien') ? ' has-error' : '' }}">
                        <label for="kecamatan_pasien">Kecamatan Tinggal</label>
                        @if(!$disabled)

                            <select id="kecamatan_pasien" name="kecamatan_pasien" class="form-control select2"  {{ $disabled }}>
                                <option disabled selected>Pilih Kecamatan</option>
                                @if($kecamatan)
                                    @foreach($kecamatan as $key => $value)
                                        <option value="{{ $key }}"  @if(old('kecamatan_pasien') ==  $key ) {{ ' selected '}} @endif>{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select> 

                        @else

                            <input id="kecamatan_pasien" type="text" name="kecamatan_pasien" class="form-control" value="{{ old('kecamatan_pasien_name') }}" vplaceholder="Masukkan kecamatan anda.." autofocus {{ $disabled }} /> 

                        @endif

                        @if ($errors->has('kecamatan_pasien'))
                            <span class="help-block">
                                <strong>{{ $errors->first('kecamatan_pasien') }}</strong>
                            </span> 
                        @endif
                    </div>
                </div>
                <div class="col-lg-6" style="padding:0">
                    <div class="form-group {{ $errors->has('kelurahan_pasien') ? ' has-error' : '' }}">
                        <label for="kelurahan_pasien"> Kelurahan Tinggal</label>
                        @if(!$disabled)

                            <select id="kelurahan_pasien" name="kelurahan_pasien" class="form-control select2"  {{ $disabled }}>
                                <option disabled selected>Pilih Kelurahan</option>
                                @if($kelurahan)
                                    @foreach($kelurahan as $key => $value)
                                        <option value="{{ $key }}"  @if(old('kelurahan_pasien') ==  $key ) {{ ' selected '}} @endif>{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select> 
                        
                        @else

                            <input id="kecamatan_pasien" type="text" name="kecamatan_pasien" class="form-control" value="{{ old('kecamatan_pasien_name') }}" placeholder="Masukkan kecamatan anda.." autofocus {{ $disabled }} /> 

                        @endif

                        @if ($errors->has('kelurahan_pasien'))
                            <span class="help-block">
                                <strong>{{ $errors->first('kelurahan_pasien') }}</strong>
                            </span> 
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan Email anda" autofocus  {{ $disabled }} /> 
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span> 
                @endif
            </div>
            <div class="form-group {{ $errors->has('riwayat_penyakit') ? ' has-error' : '' }}">
                <label for="riwayat_penyakit">Riwayat Penyakit</label>
                <textarea name="riwayat_penyakit" id="riwayat_penyakit" cols="30" rows="5" class="form-control" placeholder="Masukkan riwayat penyakit anda"></textarea>
                <span class="help-block">
                    <strong>{{ $errors->first('riwayat_penyakit') }}</strong>
                </span>
            </div>
        </div>
    </div>
</fieldset>



<fieldset>
    <legend>Data Lainnya</legend>
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group {{ $errors->has('no_asuransi') ? ' has-error' : '' }}">
                <label for="no_asuransi">Nomor Asuransi</label>
                <input id="no_asuransi" type="text" name="no_asuransi" class="form-control" value="{{ old('no_asuransi') }}"   placeholder="Masukkan no Asuransi anda.." autofocus {{ $disabled }} /> 
                @if ($errors->has('no_asuransi'))
                    <span class="help-block">
                        <strong>{{ $errors->first('no_asuransi') }}</strong>
                    </span> 
                @endif
            </div>

            <div class="form-group {{ $errors->has('nama_wali') ? ' has-error' : '' }}">
                <label for="nama_wali">Nama Wali</label> <i>(sesorang yang akan dihubungi apabila terjadi sesuatu)</i>
                <input id="nama_wali" type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}" placeholder="Masukkan nama wali anda.." autofocus {{ $disabled }} /> @if ($errors->has('nama_wali'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nama_wali') }}</strong>
                    </span> 
                @endif
            </div>


            <div class="form-group {{ $errors->has('nomor_telepon_wali') ? ' has-error' : '' }}">
                <label for="nomor_telepon_wali">Nomor Telepon</label>
                <input id="nomor_telepon_wali" type="text" name="nomor_telepon_wali" class="form-control" value="{{ old('nomor_telepon_wali') }}" placeholder="Masukkan nomor telepon wali anda.." autofocus {{ $disabled }} />
                @if ($errors->has('nomor_telepon_wali'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nomor_telepon_wali') }}</strong>
                    </span> 
                @endif
            </div>


        </div>
        <div class="col-lg-6">

            <div class="form-group {{ $errors->has('nama_ibu') ? ' has-error' : '' }}">
                <label for="nama_ibu">Nama Ibu Kandung</label>
                <input id="nama_ibu" type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}"  placeholder="Masukkan nama ibu anda.." autofocus {{ $disabled }} />
                @if ($errors->has('nama_ibu'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nama_ibu') }}</strong>
                    </span> 
                @endif
            </div>

            <div class="form-group {{ $errors->has('email_wali') ? ' has-error' : '' }}">
                <label for="email_wali">Email</label>
                <input id="email_wali" type="text" name="email_wali" class="form-control" value="{{ old('email_wali') }}" placeholder="Masukkan email wali anda.." autofocus {{ $disabled }} />
                @if ($errors->has('email_wali'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email_wali') }}</strong>
                    </span> 
                @endif
            </div>

            <div class="form-group {{ $errors->has('hubungan_wali') ? ' has-error' : '' }}">
                <label for="hubungan_wali">Hubungan</label>
                <input id="hubungan_wali" type="text" name="hubungan_wali" class="form-control" value="{{ old('hubungan_wali') }}" placeholder="Masukkan hubungan wali dengan anda.." autofocus {{ $disabled }} /> 
                @if($errors->has('hubungan_wali'))
                    <span class="help-block">
                        <strong>{{ $errors->first('hubungan_wali') }}</strong>
                    </span> 
                @endif
            </div>
            @if(!$disabled)
                <div class="row">
                    <div class="col-lg-12">
                        <p>
                            Dengan ini kami menyatakan bahwa data yang anda Masukkan adalah benar.
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="radio disable">
                                    <label>
                                        <input type="radio" name="optionsRadios2" value="option3" checked>
                                        Ya
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios2" value="option4">
                                        Tidak
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <noscript>
                        <input class="nocsript-finish-btn sf-right nocsript-sf-btn" type="submit" name="no-js-clicked"
                            value="finish" />
                    </noscript>
                </div>
            @endif
        </div>
        @if(!$disabled)
        <div class="col-lg-12">
            Note : Pastikan data yang anda isi benar dan sesuai prosedur.
        </div>
        @endif
    </div>
</fieldset>