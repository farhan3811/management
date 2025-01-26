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

    table[data-original-tb="price"] > tbody > tr[class="odd"]{
        background-color: #d5e5fb;
    }

    table[data-original-tb="price"] > tbody > tr[class="even"]{
        background-color: #e6effc;
    }

    .js-exportable-ajax tbody tr[class="odd"]:hover{
        background-color: #e7f1fe;   
    }    

    .js-exportable-ajax tbody tr[class="even"]:hover{
        background-color: #f2f8ff;   
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
                                
                                <h2 style="float:left;padding-right:15px"><b>Harga Pelayanan</b></h2>
                                <h2 style="float:left"><b></b></h2>
                            </div>
                                        <!-- Large Size -->

                            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content modal-col-green">
                                        <div class="modal-header" style="padding-bottom:25px">
                                            <h4 class="modal-title" style="font-size:25px" id="largeModalLabel"></h4>
                                        </div>
                                        {{csrf_field()}} {{method_field('post')}}
                                        <div class="modal-body" style="background-color:#cfffdc;padding:40px"></div>
                                        <div class="modal-footer">
                                            <button type="button" id="save" class="btn btn-link waves-effect save">SAVE CHANGES</button>
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-1" style="padding-right:0px">
                               
                            </div>
                            <div class="col-xs-12 col-sm-1" style="padding-top:7px">
                            </div>
                            <div class="col-xs-12 col-sm-1" style="padding-top:7px">
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <select class="filled-in form-control show-tick additional-filter" name="select_type" id="select_type" autocomplete="off">
                                    <option selected value="">All</option>
                                    <option value="VISUS">PEMERIKSAAN</option>
                                    <option value="CONSULT">KONSULTASI</option>
                                    <option value="GLASSES">KACAMATA</option>
                                    <option value="REQLAB">LAB</option>
                                    <option value="OPERATION">OPERASI</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-1" style="padding-top:7px">
                                <input type="checkbox" id="state_active" name="state_active" class="filled-in additional-filter" checked />
                                    <label for="state_active"><b>AKTIF</b></label>
                            </div>
                            <div class="col-xs-12 col-sm-2 align-right">
                                <button id="cr-0" class="btn btn-success form-service" data-toggle="modal" data-target="#largeModal">
                                    <i class="material-icons">queue</i>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>

                        <ul class="header-dropdown m-r--5" style="right:30px">
                            <button id="refresh" class="dropdown-toggle btn-info btn btn-sm" role="button" aria-haspopup="true">
                                <i class="material-icons" style="padding-top:4px;padding-bottom:4px;color:white">refresh</i>
                            </button>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive" style="overflow-x: visible; ">
                            <table class="table table-hover js-exportable-ajax" data-original-tb="price" selected-row="1" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style=""></th>
                                        <th width="200px">Nama Pelayanan</th>
                                        <th width="30px">Kategori</th>
                                        <th width="120px">Sub-Kategori</th>
                                        <th width="70px">Harga</th>
                                        <th width="20px">Dibuat</th>
                                        <th width="40px">Status</th>
                                        <th width="80px">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
   .bs-caret{
        right:-20px;
    }
</style>
@endsection
