
var table_pharmacy_queue;

$(function () {

    table_pharmacy_queue = $('.js-apotek-queue').DataTable({
        select: {
            style:    'multiple',
            selector: 'tr>td:nth-child(7)'
        },
        ajax: {
            "url" : "/route/api",
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            "type": "POST",
            "data": {
                source : $('#queue-pharmacy').attr('data-original-tb'),
                additional_filter : $('#queue-pharmacy').parent().parent().find('.additional-filter').serializeArray()
            },
        },
        bPaginate: true,
        processing: true,
        serverSide: true,
        responsive: true,
        "bLengthChange": false,
        oLanguage: {
            "loadingRecords": "&nbsp;",
            "processing": "Loading...",
            "sLengthMenu": "&nbsp; _MENU_ &nbsp;",
            "sSearch": "",
            "sSearchPlaceholder": "Search records",
            "oPaginate": false
        },
        dom: 'frtip',
        drawCallback: function( settings ) {
            
            $('#container-detail').empty();
        

            $("#select-antrian > .bootstrap-select").css("width", "250px");
            $("#select-antrian > .bootstrap-select").css("float", "left");

            $("#select-antrian > .bootstrap-select > .btn > .filter-option").css("cssText", "font-weight:bold !important;font-size:20px !important");

            $("#"+$('#queue-pharmacy').attr('id')+"_filter").css("text-align", "center");
            $("#"+$('#queue-pharmacy').attr('id')+"_filter").find( "input" ).css( "background-color", "#0063B1" );
            $("#"+$('#queue-pharmacy').attr('id')+"_filter").find( "input" ).css( "color", "white" );
            $("#"+$(this).attr('id')+"_filter").find("label").css("width", "100%");
            $("#"+$(this).attr('id')+"_filter").find("input").css("width", "100%");
            $("#"+$('#queue-pharmacy').attr('id')+" td").css("text-align", "left");
            $("#"+$('#queue-pharmacy').attr('id')+" th").css("text-align", "center");

            $("div[class*='dt-buttons']").css("padding", "5px 20px 20px 0px");
            $("td[class*='padding-sm']").css("padding", "5px 10px 5px 10px");
            
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });
            
            if($('#queue-pharmacy').attr('selected-row') == 1){

                $("#"+$('#queue-pharmacy').attr('id')+" td").css("padding", "5px");
                $("#"+$('#queue-pharmacy').attr('id')+" td").css("padding-top", "10px");
                $("#"+$('#queue-pharmacy').attr('id')+" th").css("border-bottom", "1px solid #5b68ff");
                $("#"+$('#queue-pharmacy').attr('id')+" td").css("border-bottom", "1px solid #5b68ff");
                $("#"+$('#queue-pharmacy').attr('id')+" tbody").css("cursor", "pointer");
            }

            // $('td:nth-child(1)').css("background-color", "#009688");
            $('td:nth-child(1)').css("color", "black");
        },
        "createdRow": function( row, data, dataIndex){

            if( data[2] ==  'taken'){
                $(row).addClass('taken');
                $(row).css('background-color', 'green');
                $(row).attr('data-toggle', 'tooltip');
                $(row).attr('data-placement', 'top');
                $(row).attr('data-original-title', 'Obat sudah diambil');
            }
            if( data[2] ==  'income-in'){
                $(row).addClass('taken');
                $(row).css('background-color', '#d5bc00');
                $(row).attr('data-toggle', 'tooltip');
                $(row).attr('data-placement', 'top');
                $(row).attr('data-original-title', 'Obat sudah diambil');
            }
            if( data[2] ==  'havenottaken'){
                $(row).addClass('havenottaken');
            }
        }
    });

});
