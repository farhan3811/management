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

    .odd:hover {
        background-color: #6CB1E7 !important;
    }
    .even:hover {
        background-color: #6CB1E7 !important;
    }


    .js-apotek-queue tbody tr[class="odd"]:hover{
        background-color: #b7cfff;   
    }    

    .js-apotek-queue tr[class="even"]:hover{
        background-color: #f2f8ff;   
    }    

    #queue-cashier tbody tr[class="odd"]{
        background-color: #b7cfff;   
    }    

    #queue-cashier tbody tr[class="even"]{
        background-color: #91b5fc;   
    }    

    .selected-booking{
        background-color: #ff689d;
    }
    .stateTake{
        background-color: green;
    }
    table.dataTable tbody tr.selected {
        background-color:#69c4fe !important;
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
                            <div class="col-xs-12 col-sm-6">
                                <h2 style="float:left;padding-right:15px"><b>Kasir & Tambah Obat</b></h2>
                                <h2 style="float:left"><b></b></h2>
                                {{-- <span style="float:left;margin-left:5px"> 
                                    <span class="waves-effect" data-toggle="modal" data-target="#largeModal">
                                        <i class="material-icons" style="vertical-align: middle;font-size:15px">settings</i>
                                    </span>
                                    <span class="waves-effect" data-toggle="modal" data-target="#largeModal">
                                        <i class="material-icons" style="vertical-align: middle;font-size:15px">search</i>
                                    </span>
                                </span> --}}
                            </div>
                                        <!-- Large Size -->

                            <div style="color:#"class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" style="width:1050px" role="document">
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

                            <div class="col-xs-12 col-sm-1">
                            </div>
                            <div class="col-xs-12 col-sm-5 align-right ">
                                {{-- <button id="cr-0" class="btn btn-success entry-cashier" data-toggle="modal" data-target="#largeModal">
                                    <i class="material-icons">queue</i>
                                    <span>Tambah di luar antrian</span>
                                </button> --}}
                                
                            </div>
                        </div>

                        
                    </div>
                    <div class="body">
                        <div class="table-responsive" style="overflow-x: visible; ">
                            <table class="table table-condensed table-striped js-exportable-ajax" data-original-tb="cashier-trx" selected-row="1"  width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="">cd</th>
                                        <th style="width: 10%">Pembeli</th>
                                        <th style="width: 30%">Nama</th>
                                        <th style="width: 40%">Kode Trx Obat</th>
                                        <th style="width: 10%">Tanggal</th>
                                        {{-- <th>Time</th> --}}
                                        <th style="width: 5%">Aksi</th>
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

<!-- <style>
    #DataTables_Table_0_filter .input-sm{
        width:100px !important; 
    }  
    #DataTables_Table_0_length .input-sm{
        width:50px !important; 
    }  
</style> -->