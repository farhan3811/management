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

    .js-exportable-ajax tbody tr[class="odd"]:hover{
        background-color: #e7f1fe;   
    }    

    .js-exportable-ajax tbody tr[class="even"]:hover{
        background-color: #f2f8ff;   
    }    

    tr[tipe-original="kacamata"]{
        background-color: #b3ffb1;
    }

    tr[tipe-original="visus"]{
        background-color: #d5e5fb;
    }

    .selected-booking{
        background-color: #ff689d;
    }


</style>

<section class="content">
    <div class="container-fluid">
            <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-deep-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL PASIEN</div>
                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">done</i>
                    </div>
                    <div class="content">
                        <div class="text">PASIEN TERTANGANI</div>
                        <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-amber hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">forum</i>
                    </div>
                    <div class="content">
                        <div class="text">PASIEN MENUNGGU</div>
                        <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">person_add</i>
                    </div>
                    <div class="content">
                        <div class="text">NEW VISITORS</div>
                        <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Widgets -->
        <!-- CPU Usage -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-3">
                                <div id="select-antrian">
                                    <select class="form-control show-tick" id="select-antrian-dt" autocomplete="off">
                                        <b>
                                            <option selected value="visus">PEMERIKSAAN</option>
                                            <option value="kacamata">ANTRIAN KACAMATA</option>
                                            <option value="all">SEMUA ANTRIAN</option>
                                        </b>
                                    </select>
                                </div>
                                
                            </div>
                                        <!-- Large Size -->

                            <div class="modal fade" id="largeModal" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content modal-col-green">
                                        <div class="modal-header" style="padding-bottom:25px">
                                            <h4 class="modal-title" style="font-size:25px" id="largeModalLabel"></h4>
                                        </div>
                                        {{csrf_field()}} {{method_field('post')}}
                                        <div class="modal-body" style="background-color:#cfffdc;padding:40px"></div>
                                        <div class="modal-footer">
                                            <button type="button" id="save" class="btn btn-link waves-effect save">SIMPAN PERUBAHAN</button>
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-2" style="padding-right:0px">
                                <div class="input-group" style="margin-bottom:0px">
                                    <div class="form-line">
                                        <input type="text" id="date_from" name="date_from" class="datepicker form-control additional-filter" placeholder="Date from" style="padding:0">
                                    </div>
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-2" style="width:14%;padding-right:0px">
                                <div class="input-group" style="margin-bottom:0px">
                                    <div class="form-line">
                                        <input type="text" id="date_to" name="date_to" class="datepicker form-control additional-filter" placeholder="Date to" style="padding:0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-1" style="padding-top:5px">
                                <input type="checkbox" id="current" name="current" class="filled-in additional-filter" checked />
                                <label for="current"><b>CURRENT</b></label>
                            </div>
                        </div>

                        <ul class="header-dropdown m-r--5">
                            <button id="refresh" class="dropdown-toggle" type="button">
                                <i class="material-icons" style="padding-top:4px">refresh</i>
                            </button>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive" style="overflow-x: visible; ">
                            <table class="table table-hover js-exportable-ajax" data-original-tb="queue-visus" selected-row="1" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style=""></th>
                                        <th width="20px">Jenis</th>
                                        <th width="10px">Urutan</th>
                                        <th width="20px">RM</th>
                                        <th width="20px">Pasien</th>
                                        <th width="20px">Dokter</th>
                                        <th width="120px">Hari</th>
                                        <th width="120px">Waktu</th>
                                        {{-- <th width="80px">Mulai Antri</th> --}}
                                        <th width="70px">Action</th>
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
