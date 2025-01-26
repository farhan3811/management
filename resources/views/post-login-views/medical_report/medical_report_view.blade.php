@extends('layouts.app')

@section('content')

<style>

.cursorTab {
    cursor: pointer;
    padding: 8px !important;
}

dt{
    width:130px !important;
    padding-bottom:10px !important;padding-top:10px !important;
}

dd{
    margin-left:140px !important;padding-top:10px !important;
}

.cursorTab:hover {
    background-color: #f89294;
}

table[data-original-tb="queue-kacamata"] > tbody > tr[class="odd"]{
    background-color: #b3ffb1;
}

table[data-original-tb="queue-kacamata"] > tbody > tr[class="even"]{
    background-color: #cbffca;
}

table[data-original-tb="queue-visus"] > tbody > tr[class="odd"]{
    background-color: #d5e5fb;
}

table[data-original-tb="queue-visus"] > tbody > tr[class="even"]{
    background-color: #e6effc;
}

table[data-original-tb="queue-dokter"] > tbody > tr[class="odd"]{
    background-color: #fbd7a2;
}

table[data-original-tb="queue-dokter"] > tbody > tr[class="even"]{
    background-color: #fbebb5;
}

table[data-original-tb="queue-lab"] > tbody > tr[class="odd"]{
    background-color: #ffb9f9;
}

table[data-original-tb="queue-lab"] > tbody > tr[class="even"]{
    background-color: #fccffc;
}

.js-exportable-ajax tbody tr[class="odd"]:hover{
    background-color: #fef7e7;   
}    

.js-exportable-ajax tbody tr[class="even"]:hover{
    background-color: #fffbf2;   
}    

tr[tipe-original="kacamata"]{
    background-color: #b3ffb1;
}

tr[tipe-original="visus"]{
    background-color: #d5e5fb;
}

tr[tipe-original="consult"]{
    background-color: #d5e5fb;
}

tr[tipe-original="lab"]{
    background-color: #f7fbd5;
}

.selected-booking{
    background-color: #ff689d;
}

</style>
<section class="content">
    <div class="container-fluid">
        <!-- #END# Widgets -->
        <!-- CPU Usage -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-4">
                                <h2 style="float:left;padding-right:15px"><b>Laporan Rekam Medis Pasien</b></h2>
                                <h2 style="float:left"><b></b></h2>
                            </div>
                                        <!-- Large Size -->

                            <!-- <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content modal-col-light-blue">
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="font-size:25px" id="largeModalLabel"></h4>
                                        </div>
                                        {{csrf_field()}} {{method_field('post')}}
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <button type="button" id="save" class="btn btn-link waves-effect save">SAVE CHANGES</button>
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-xs-12 col-sm-2">
                            </div>
                            <div class="col-xs-12 col-sm-3">
                            </div>
                            <div class="col-xs-12 col-sm-3 align-right ">
                                <!-- <button id="cr-0" class="btn btn-success form-price-medicine" data-toggle="modal" data-target="#largeModal">
                                    <i class="material-icons">queue</i>
                                    <span>Tambah</span>
                                </button>
                                 -->
                            </div>
                        </div>

                        
                    </div>
                    <div class="body">
                        <div class="table-responsive" style="overflow-x: visible; ">
                            <table class="table table-hover table-condensed table-striped js-exportable-ajax" selected-row="1"  data-original-tb="medical-reports"  width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style=""></th>
                                        <th>Nomor</th>
                                        <th width="200px">Nama Lengkap</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Kota</th>
                                        <th>Dibuat Pada</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="container-detail"></div>
    </div>
</section>
@endsection
