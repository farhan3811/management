<div id="entry_medicine">
    <style>
    .form-normal{
        background-color:#35a0ff;
        color:white;
        font-size:20px;
    }
    </style>

    <div class="row clearfix">
        <div class="col-sm-12" style="padding-top:20px">
            <!-- ============ hidden =========== -->
            <div class="col-sm-12 hidden" >
                <div class="form-group form-float">
                    <div class="form-line">
                        <input readonly type="text" {{ $disabled }} class="form-control form-normal" id="cd" value="{{ isset($cd)? $cd : '' }}">
                    </div>
                </div>
            </div>
            <!-- ============ hidden =========== -->


            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="" style="border-bottom:1px solid #ddd">
                        <label class="form-label" style="color:white">Nama Grup Pemeriksaan</label>
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="group_lab_data" value="{{ isset($result->group_lab)? $result->group_lab : '' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="detail_lab_data" value="{{ isset($result->detail_lab)? $result->detail_lab : '' }}">
                        <label class="form-label" style="color:white">Nama Pemeriksaan</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="nilai_normal_data" value="{{ isset($result->nilai_normal)? $result->nilai_normal : '' }}">
                        <label class="form-label" style="color:white">Nilai Normal</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12" style="padding-top:20px">
            <div class="col-sm-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" {{ $disabled }} class="form-control form-normal" id="satuan_data" value="{{ isset($result->satuan)? $result->satuan : '' }}">
                        <label class="form-label" style="color:white">Satuan</label>
                    </div>
                </div>
            </div>
        </div>

        @if($type == 'dt')
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="created_at_data" value="{{ isset($result->created_at)? $result->created_at : ' ' }}">
                            <label class="form-label" style="color:white">Dibuat Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="created_by_data" value="{{ isset($result->created_by)? $result->created_by : ' ' }}">
                            <label class="form-label" style="color:white">Dibuat Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="updated_at_data" value="{{ isset($result->updated_at)? $result->updated_at : ' ' }}">
                            <label class="form-label" style="color:white">Diubah Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="updated_by_data" value="{{ isset($result->updated_by)? $result->updated_by : ' ' }}">
                            <label class="form-label" style="color:white">Diubah Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="deleted_at_data" value="{{ isset($result->deleted_at)? $result->deleted_at : ' ' }}">
                            <label class="form-label" style="color:white">Dihapus Pada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:20px">
                <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" {{ $disabled }} class="form-control form-normal" id="deleted_by_data" value="{{ isset($result->deleted_by)? $result->deleted_by : ' ' }}">
                            <label class="form-label" style="color:white">Dihapus Oleh</label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<script src="{{ asset('adminbsb/js/admin.js') }}"></script>
<script>
    $(function () {
        autosize($('textarea.auto-growth'));
        
        var options = {
            url: $('.mainurl').val() +'/master/lab/group/',
            getValue: "value",
            list: {
                
                match: {
                    enabled: true
                },
                
                onLoadEvent: function() {
                    $("#eac-container-group_lab_data").css('background-color', '#6ec0e1');
                    $("#eac-container-group_lab_data").find( "li" ).css('padding', '2px 0px 2px 0px');
                    $("#eac-container-group_lab_data").find( "ul" ).css('padding-top', '5px');
                    $("#eac-container-group_lab_data").find( "ul" ).css('padding-bottom', '5px');

                    $("#eac-container-group_lab_data").find( "li" ).hover(function (){
                        $(this).css("text-decoration", "underline");
                        $(this).css("cursor", "pointer");         
                    },function(){
                        $(this).css("text-decoration", "none");
                    });
                },	

                maxNumberOfElements: 6,
                showAnimation: {
                    type: "slide",
                    time: 300
                },
                hideAnimation: {
                    type: "slide",
                    time: 300
                }
            },
            theme: "square"
        };
        


        $("#group_lab_data").easyAutocomplete(options);
    });
</script>
<style>
    #entry_medicine .bootstrap-select{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .dropdown-toggle{
        background-color:#45c3d8 !important;    
    }
    #entry_medicine .filter-option{
        color:white;
        padding-top:5px
    }
</style>