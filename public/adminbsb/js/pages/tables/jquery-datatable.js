
var table;

$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });
    
    var selected = [];

	$.tables_js_exportable_ajax = function(id){

        var x = 0;
        $('.js-exportable-ajax').each(function () {
        
            if(x == 0){
                    
                if(typeof id === "undefined"){
                    var $table = $(this);
                }else{
                    var $table = $('#'+id);
                    x = x + 1;
                }
                

                table = $table.DataTable({
                    dom: 'Bflrtip',
                    select: {
                        style:    'multiple',
                        selector: 'tr>td:nth-child(3)'
                    },
                    bPaginate: true,
                    processing: true,
                    serverSide: true,
                    sPaginationType: 'full_numbers',
                    ajax: {
                        "url" : "/route/api",
                        "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        "type": "POST",
                        "data": {
                            source : $(this).attr('data-original-tb'),
                            additional_filter : $table.parent().parent().parent().find('.additional-filter').serializeArray()
                        },
                    },
                    responsive: true,
                    lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]],
                    oLanguage: {
                        "loadingRecords": "&nbsp;",
                        "processing": "Loading...",
                        "sLengthMenu": "&nbsp; _MENU_ &nbsp;",
                        "sSearch": "",
                        "sSearchPlaceholder": "Search records"
                    },
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    initComplete:
                        function( settings, json){
                            jQuery.each( json, function( i, val ) {
                                if(i != 'aaData' && i != 'iTotalRecords' && i != 'iTotalDisplayRecords'){
                                    $( "#" + i ).empty();
                                    $( "#" + i ).append( val );
                                }
                            });
                    },
                    drawCallback: function( settings ) {
                        $('#container-detail').empty();
                        
                        $("#"+$(this).attr('id')+"_length").css("float", "right");

                        // $("#select-antrian > .bootstrap-select").css("width", "250px");
                        $("#select-antrian > .bootstrap-select").css("float", "left");
                        $("td").css("vertical-align", "middle");

                        $("#select-antrian > .bootstrap-select > .btn > .filter-option").css("cssText", "font-weight:bold !important;font-size:16px !important");

                        $("#"+$(this).attr('id')+"_filter").css("float", "right");
                        $("#"+$(this).attr('id')+" td").css("text-align", "center");
                        $("#"+$(this).attr('id')+" th").css("text-align", "center");

                        $("div[class*='dt-buttons']").css("padding", "5px 20px 20px 0px");
                        $("td[class*='padding-sm']").css("padding", "5px 10px 5px 10px");
                        
                        $('[data-toggle="tooltip"]').tooltip({
                            container: 'body'
                        });
                        
                        if($(this).attr('selected-row') == 1){

                            $("#"+$(this).attr('id')+" td").css("border-top", "2px solid #fff");
                            $("#"+$(this).attr('id')+" tbody").css("cursor", "pointer");
                            // $("#"+$(this).attr('id')+" tbody tr").addClass(" waves-effect ");
                            // $("#"+$(this).attr('id')+" tbody tr").css("display", "table-row");
                        }

                        if($table.attr('data-original-tb') == 'queue-visus'){
                            $('td:nth-child(1)').css("background-color", "blue");
                            $('td:nth-child(1)').css("color", "white");
                        }else if($table.attr('data-original-tb') == 'queue-kacamata'){
                            $('td:nth-child(1)').css("background-color", "green");
                            $('td:nth-child(1)').css("color", "white");
                        }else if($table.attr('data-original-tb') == 'queue-lab'){
                            $('td:nth-child(1)').css("background-color", "#a819a8");
                            $('td:nth-child(1)').css("color", "white");
                        }else if($table.attr('data-original-tb') == 'queue-dokter'){
                            $('td:nth-child(1)').css("background-color", "rgb(222, 0, 0)");
                            $('td:nth-child(1)').css("color", "white");
                        }else if($table.attr('data-original-tb') == 'queue-operation'){
                            $('td:nth-child(1)').css("background-color", "rgb(212, 225, 0)");
                            $('td:nth-child(1)').css("color", "white");
                        }else if($table.attr('data-original-tb') == 'medical-reports'){
                            $('td:nth-child(1)').css("background-color", "rgb(212, 225, 0)");
                            $('td:nth-child(1)').css("color", "white");
                        }

                    },
                    "createdRow": function ( row, data, index ) {
                        if($table.attr('data-original-tb') == 'queue-visus-all'){
                            if ( data[1] == '<b>KACAMATA</b>' ) {
                                $('td', row).eq(0).css('background-color', 'green');
                                $(row).attr('tipe-original', 'kacamata');
                                $('td', row).eq(0).css('color', 'white');
                            }else if(data[1] == '<b>VISUS</b>' ){
                                $('td', row).eq(0).css('background-color', 'blue');
                                $(row).attr('tipe-original', 'visus');
                                $('td', row).eq(0).css('color', 'white');
                            }
                        }
                    },
                    columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }]
                });
            }
        });
	}

    $.tables_js_exportable_ajax();

});
