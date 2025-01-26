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
        <div class="col-sm-4" style="display:none" id="form-tambah">
            <div class="form-group form-float" style="margin-bottom:0px">
                <div class="form-line">
                    <input id="cd_price" class="form-control" style="" type="hidden" value="" />
                    <input id="harga_jual_terbaru" class="form-control" style="overflow: hidden; overflow-wrap: break-word; height: 32px;background-color:#45c3d8 !important;color:white;padding:5px" />
                    <label class="form-label" style="color:#bfd3f6;padding-left:10px">Input Harga Jual Terbaru</label>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-flat btn-success submit-price" id="tambah-price">Tambah</button>
            <button class="btn btn-flat btn-danger" style="display:none;float:right;padding-top:3px;padding-bottom:3px;" id="button-hidden-price"><i class="material-icons">indeterminate_check_box</i></button>
            <button class="btn btn-flat btn-warning submit-price hidden" id="ubah-price">Ubah</button>
        </div>
        <div class="col-sm-6  pull-right">
            <label class="form-label pull-right">Harga Yang aktif : <span id="lastprice"></span></label>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="table-responsive" style="overflow-x: visible; ">
                <input class="additional-filter" name="cd_med" id="cd_med" value="" type="hidden"/>
                <table id="table-medicine-price" class="table table-hover table-condensed table-striped js-exportable-ajax" data-original-tb="medicine-price"  width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th style=""></th>
                            <th>No</th>
                            <th>Harga Jual</th>
                            <th width="140px">Diinput Pada</th>
                            <th>Diinput Oleh</th>
                            <th>Status</th>
                            <th width="90px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
table[data-original-tb="medicine-price"] > tbody > tr[class="odd"]{
    background-color: ##fffcbf;
    color: black;
}

table[data-original-tb="medicine-price"] > tbody > tr[class="even"]{
    background-color: #ffffe1;
    color: black;
}
</style>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>