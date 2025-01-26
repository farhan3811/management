<div class="row clearfix">
<div id="entry-obat">
    <div class="col-sm-12" style="padding-left:5px;padding-right:5px">
        <label class="form-label" style="color:#4b4949 !important;padding-left:5px;">Daftar Obat</label>
        <div class="col-sm-12" style="padding:15px;border:5px solid !important;background-color:#EDF1FF !important">
            @php $x = 1 @endphp
            @foreach($allmed as $data)
                @if(($x - 1) % 2 == 0 or $x == 1)
                    <div class="col-sm-12">
                @endif
                
                @php
                    $statemed = 0;
                    if(isset($med)){
                        if(!empty($med)){
                            if(in_array($data->code_medicine, $med['code'])){
                                $checked = ' checked ';
                                $getkey = array_search($data->code_medicine, $med['code']);
                                $statemed = 1;
                            }
                        }
                    }
                    
                    $checked = $statemed == 1? $checked : '';
                    $getkey  = $statemed == 1? $getkey : '';
                    
                @endphp
                
                <div class="col-sm-6">
                    <input {{ $checked }} {{ $disabled }} id="md_checkbox_{{$data->id}}" name="med[{{$data->code_medicine}}][{{$data->code_detail_medicine}}]" class="form-entry-med chk-col-blue medicine-check" type="checkbox">
                    <label for="md_checkbox_{{$data->id}}" style="color:black">{{ $data->nama_obat}} <span style="color:red;">({{ isset($data->stock)? $data->stock : 0}}{{ ' '.$data->satuan }})</span></label>
                    
                    <input {{ $disabled }} name="tot[{{$data->code_medicine}}]" style="float:right;color:black;width:50px;display:{{ $checked != ''? ' block ' : ' none '}};" data-toggle="tooltip" class="form-entry-med-tot" data-placement="top" title="Jumlah Obat" type="number" value="{{ $checked != ''? $med['jumlah'][$getkey] : ' none '}}" />
                </div>
                @if($x % 2 == 0 or $allmedcount == $x)
                    </div>
                @endif
                @php $x++ @endphp
            @endforeach
        </div>
    </div>
    
        @if(isset($result->is_operation))
            @if($result->is_operation != 'Y' or $result->is_medicine == 'N')
                <script>
                    setTimeout(function () { 
                        $.AdminBSB.browser.activate();
                        $.AdminBSB.leftSideBar.activate();
                        $.AdminBSB.rightSideBar.activate();
                        $.AdminBSB.navbar.activate();
                        $.AdminBSB.dropdownMenu.activate();
                        $.AdminBSB.input.activate();
                        $.AdminBSB.select.activate();
                        $.AdminBSB.search.activate();
                        $('.page-loader-wrapper').fadeOut(); 
                    }, 100);
                </script>
            @endif
        @endif
    <script src="{{ asset('adminbsb/js/pages/ui/tooltips-popovers.js') }}"></script>
</div>
</div>