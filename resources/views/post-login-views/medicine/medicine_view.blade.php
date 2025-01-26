@extends('layouts.app')

@section('content')

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
                                <h2 style="float:left;padding-right:15px"><b>Data Master Obat</b></h2>
                                <h2 style="float:left"><b></b></h2>
                            </div>
                                        <!-- Large Size -->

                            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
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
                            </div>

                            <div class="col-xs-12 col-sm-2">
                            </div>
                            <div class="col-xs-12 col-sm-3">
                            </div>
                            <div class="col-xs-12 col-sm-3 align-right ">
                                <button id="cr-0" class="btn btn-success form-price-medicine" data-toggle="modal" data-target="#largeModal">
                                    <i class="material-icons">queue</i>
                                    <span>Tambah</span>
                                </button>
                                
                            </div>
                        </div>

                        
                    </div>
                    <div class="body">
                        <div class="table-responsive" style="overflow-x: visible; ">
                            <table class="table table-hover table-condensed table-striped js-exportable-ajax" data-original-tb="medicine"  width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style=""></th>
                                        <th>No</th>
                                        <th width="150px">Nama Obat</th>
                                        <th>Satuan</th>
                                        <th>Stock</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <!--<th>Dibuat Pada</th>-->
                                        <th>Action</th>
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
