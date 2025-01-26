<div>
    <style>
    .form-normal{
        background-color:#35a0ff;
        color:white;
        font-size:20px;
    }
    </style>

    <div class="row clearfix"> 
        <br />
        <div class="col-sm-2" style="display:none" id="form-stock-med">
            <div class="form-group form-float" style="margin-bottom:0px">
                <div class="form-line">
                    <input id="cd_stock" class="form-control" style="" type="hidden" value="" />
                    <input type="number" id="stock_terbaru" class="form-control" style="border-radius:7px;overflow: hidden; overflow-wrap: break-word; height: 32px;background-color:#45c3d8 !important;color:white;padding:5px" />
                    <label class="form-label" style="color:#bfd3f6;padding-left:5px">Tambah Stock</label>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="display:none" id="form-unit-med">
            <div class="form-group form-float" style="margin-bottom:0px">
                <div class="form-line">
                    <input id="cd_stock" class="form-control" style="" type="hidden" value="" />
                    <input type="number" id="harga_beli_unit" class="form-control" style="border-radius:7px;overflow: hidden; overflow-wrap: break-word; height: 32px;background-color:#45c3d8 !important;color:white;padding:5px" />
                    <label class="form-label" style="color:#bfd3f6;padding-left:5px">Harga Beli Satuan</label>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="display:none" id="form-total-med">
            <div class="form-group form-float" style="margin-bottom:0px">
                <div class="form-line">
                    <input id="cd_stock" class="form-control" style="" type="hidden" value="" />
                    <input type="number" id="harga_beli_total" class="form-control" style="border-radius:7px;overflow: hidden; overflow-wrap: break-word; height: 32px;background-color:#45c3d8 !important;color:white;padding:5px" />
                    <label class="form-label" style="color:#bfd3f6;padding-left:5px">Harga Beli Total</label>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-flat btn-success submit-stock" id="tambah-stock">Tambah</button>
            <button class="btn btn-flat btn-danger" style="display:none;float:right;padding-top:3px;padding-bottom:3px;" id="button-hidden-stock"><i class="material-icons">indeterminate_check_box</i></button>
            <button class="btn btn-flat btn-warning submit-stock hidden" id="ubah-stock">Ubah</button>
        </div>
        <div class="col-sm-6  pull-right">
            <label class="form-label pull-right">Total Stock : <span id="laststock"></span></label>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="table-responsive" style="overflow-x: visible; ">
                <input class="additional-filter" name="cd_med" id="cd_med" value="" type="hidden"/>
                <table id="table-medicine-stock" class="table table-hover table-condensed table-striped js-exportable-ajax" data-original-tb="medicine-stock"  width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th style=""></th>
                            <th>No</th>
                            <th>Stock</th>
                            <th>Harga Beli Satuan</th>
                            <th>Harga Beli Total</th>
                            <th width="140px">Diinput Pada</th>
                            <th>Diinput Oleh</th>
                            <th width="90px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<style>
table[data-original-tb="medicine-stock"] > tbody > tr[class="odd"]{
    background-color: ##fffcbf;
    color: black;
}

table[data-original-tb="medicine-stock"] > tbody > tr[class="even"]{
    background-color: #ffffe1;
    color: black;
}
</style>