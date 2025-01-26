@extends('beautymail::templates.ark')

@section('content')

    @include('beautymail::templates.ark.heading', [
    'heading' => 'Notifikasi System, Booking Patient!',
    'level' => 'h2'
  ])

    @include('beautymail::templates.ark.contentStart')

        <h4 class="secondary"><strong>Hai ( {{$nama_dokter}} ) Terdapat Notifikasi</strong></h4>
        <p></p>

    @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
    'heading' => 'Selanjutnya Silahkan Konfirmasi Kedatangan Pasien Kepada Bagian Operator..',
    'level' => 'h2'
  ])

    @include('beautymail::templates.ark.contentStart')

        <h2>Berikut Informasi Booking Pasien : </h2>
        <p>No Rekam Medis : {{$id_generate_pasien}}</p>
        <p>Nama Pasien : {{$nama_pasien}}</p>
        <p>No NIK    : {{$nik_pasien}}</p>
        <p>Email Pasien     : {{$email_pasien}}</p>

        <p>Nama Poliklinik : {{$nama_poliklinik}}</p>
        <p>Nama Dokter : {{$nama_dokter}}</p>
        <p>Email Dokter : {{$email_dokter}}</p>
        <p>Nama Spesialisasi : {{$nama_spesialisasi}}</p>
        <p>Deskripsi Spesialisasi : {{$deskripsi_spesialisasi}}</p>
        <p>Hari Praktik : {{$hari_praktik}}</p>
        <p>Jam Praktik : {{$jam_praktik}}</p>

        <br>
        <h4 class="secondary"><strong>Info Hub : customers@klinikmatautamatangsel.com</strong></h4>
    @include('beautymail::templates.ark.contentEnd')

@stop