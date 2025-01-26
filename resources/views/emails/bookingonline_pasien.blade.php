@extends('beautymail::templates.ark')

@section('content')

    @include('beautymail::templates.ark.heading', [
    'heading' => 'Selamat Anda Berhasil Booking di Klinik Mata Tangerang Selatan!',
    'level' => 'h2'
  ])

    @include('beautymail::templates.ark.contentStart')

        <h4 class="secondary"><strong>Hai ( {{$nama_pasien}} ) Anda Sudah Berhasil Booking</strong></h4>
        <p></p>

    @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
    'heading' => 'Selanjutnya Anda Datang Ke Klinik KMU Anda Bisa Langsung Daftar Ke Mesin Elektronik Poli dengan menggunakan NO Rekam Medis Anda..',
    'level' => 'h2'
  ])

    @include('beautymail::templates.ark.contentStart')

        <h2>Berikut Informasi Booking Anda : </h2>
        <p>No Rekam Medis : {{$id_generate_pasien}}</p>
        <p>Nama Pasien : {{$nama_pasien}}</p>
        <p>No NIK    : {{$nik_pasien}}</p>
        <p>Email Pasien     : {{$email_pasien}}</p>

        <p>Nama Poliklinik : {{$nama_poliklinik}}</p>
        <p>Nama Dokter : {{$nama_dokter}}</p>
        <p>Email Dokter : {{$email_dokter}}</p>
        <p>Nama Spesialisasi : {{$nama_spesialisasi}}</p>
        <p>Hari Praktik : {{$hari_praktik}}</p>
        <p>Jam Praktik : {{$jam_praktik}}</p>

        <br>
        <h4 class="secondary"><strong>Info Hub : customers@klinikmatautamatangsel.com</strong></h4>
    @include('beautymail::templates.ark.contentEnd')

@stop