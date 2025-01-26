@extends('beautymail::templates.ark')

@section('content')

    @include('beautymail::templates.ark.heading', [
    'heading' => 'Selamat Anda Berhasil Mendaftar Di Klinik KMU!',
    'level' => 'h2',
  ])

    @include('beautymail::templates.ark.contentStart')

        <h4 class="secondary" style="text-align:left;"><strong>Hai ( {{$nama}} ) Kamu Sudah Berhasil Mendaftar</strong></h4>

    @include('beautymail::templates.ark.contentEnd')


    @include('beautymail::templates.ark.contentStart')

        <p style="text-align:center;"><h2 style="text-align:center;"><span style="color:red">ID REKAM MEDIS Anda : {{$id_rekam_medis}} </span>(Belum Aktif) </h2></p></br></br>
        <p style="text-align:center;">Nama Anda : {{$nama}}</p>
        <p style="text-align:center;">No NIK    : {{$nik}}</p>
        <p style="text-align:center;">Email     : {{$email}}</p>

    @include('beautymail::templates.ark.contentEnd')

    @include('beautymail::templates.ark.heading', [
    'heading' => 'Selanjutnya Gunakan ID Rekam Medis Anda Untuk Melakukan Booking/Pemesanan Jadwal Dokter Secara Online. Ketika Pada Hari Pemeriksaan, Anda Diharuskan Datang Ke Bagian Pelayanan Klinik Mata Utama Tangerang Selatan Dan Menunjukan Identitas KTP Fisik Anda Untuk Aktivasi Akun Rekam Medis Anda.',
    'level' => 'h2'
  ])

    @include('beautymail::templates.ark.contentStart')

        <br>
        <h4 class="secondary"><strong>Info Hub : customers@klinikmatautamatangsel.com</strong></h4>
    @include('beautymail::templates.ark.contentEnd')

@stop