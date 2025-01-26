$(function () {

    /* --------------------------- TABLE QUEUE ---------------------------*/
    table_queue_cashier = $('.js-cashier-queue').DataTable({
        select: {
            style:    'multiple',
            selector: 'tr>td:nth-child(7)'
        },
        ajax: {
            "url" : "/route/api",
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            "type": "POST",
            "data": {
                source : $('#queue-cashier').attr('data-original-tb'),
                additional_filter : $('#queue-cashier').parent().parent().find('.additional-filter').serializeArray()
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
        columnDefs: [
        {
            "targets": [ 0 , 2],
            "visible": false,
            "searchable": false
        }],
        drawCallback: function( settings ) {
            
            $('#container-detail').empty();
        

            $("#select-antrian > .bootstrap-select").css("width", "250px");
            $("#select-antrian > .bootstrap-select").css("float", "left");

            $("#select-antrian > .bootstrap-select > .btn > .filter-option").css("cssText", "font-weight:bold !important;font-size:20px !important");

            $("#"+$('#queue-cashier').attr('id')+"_filter").css("text-align", "center");
            $("#"+$('#queue-cashier').attr('id')+"_filter").find( "input" ).css( "background-color", "#0063B1" );
            $("#"+$('#queue-cashier').attr('id')+"_filter").find( "input" ).css( "color", "white" );
            $("#"+$(this).attr('id')+"_filter").find("label").css("width", "100%");
            $("#"+$(this).attr('id')+"_filter").find("input").css("width", "100%");
            $("#"+$('#queue-cashier').attr('id')+" td").css("text-align", "left");
            $("#"+$('#queue-cashier').attr('id')+" th").css("text-align", "center");

            $("div[class*='dt-buttons']").css("padding", "5px 20px 20px 0px");
            $("td[class*='padding-sm']").css("padding", "5px 10px 5px 10px");
            
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });
            
            if($('#queue-cashier').attr('selected-row') == 1){

                $("#"+$('#queue-cashier').attr('id')+" td").css("padding", "5px");
                $("#"+$('#queue-cashier').attr('id')+" td").css("padding-top", "10px");
                $("#"+$('#queue-cashier').attr('id')+" th").css("border-bottom", "1px solid #5b68ff");
                $("#"+$('#queue-cashier').attr('id')+" td").css("border-bottom", "1px solid #5b68ff");
                $("#"+$('#queue-cashier').attr('id')+" tbody").css("cursor", "pointer");
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
                $(row).attr('data-original-title', 'Obat sudah dibayar');
            }
            if( data[2] ==  'havenottaken'){
                $(row).addClass('havenottaken');
            }
        }
    });    


    /* --------------------------- DATA MODAL LAB ------------------------- */
    $('.js-apotek-queue, .card ').on('click', '.entry-cashier', function () {

        if(this.id == 'cr-0'){
            var code_afctmed = 'new';
        }else{
            var code_afctmed = $(this).find('.getcdmed').val();
        }

        $.ajax({
            url: $('.mainurl').val() +'/kasir/getmodalentry/'+code_afctmed,
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('.modal-body').empty();
                $('.save').show();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text(data[1]);
                $('.save').attr('id', data[2]);
                $('#cd_agree').val(data['code_agree']);

            }
        });
    });
    /* !--------------------------- DATA MODAL LAB ------------------------! */

    /* -------------------------------- SAVE  ------------------------------- */
    $('#largeModal').on('click', '#save-phar', function () {

        $.ajax({
            url: $('.mainurl').val() +'/kasir/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                afct_med            : $(".enable.afct_div").find('.afct_med').serializeArray(),
                ex_med              : $(".enable.ex_div").find('.ex_med').serializeArray(),
                cd_afct_con         : $("#cd_afct_con").val(),
                cust_name           : $("#name_cust_ex").val(),
                tagihan             : (typeof($('#tagihan:checked').val()) != "undefined" 
                                        && $('#tagihan:checked').val() !== null)? 1 : 0,
                bayar               : (typeof($('#bayar:checked').val()) != "undefined" 
                                        && $('#bayar:checked').val() !== null)? 1 : 0,
                ambil               : (typeof($('#ambil:checked').val()) != "undefined" 
                                        && $('#ambil:checked').val() !== null)? 1 : 0,

            },
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);
                
                if(data[0] == 0){

                    var tipe = 'danger';
                    var timer = 1000;

                }else{

                    var tipe = 'success';
                    var timer = 4000;

                    table_queue_cashier.ajax.reload();

                    setTimeout(function(){ 
                        $('#largeModal').modal('toggle');
                    }, 1000);

                }

                $.notify({
                    message: data[1]
                },
                    {
                        type:tipe,
                        allow_dismiss: true,
                        newest_on_top: true,
			            z_index: 9999,
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                    });
            }
        });
    });
    /* !---------------------------- SAVE  -----------------------------! */

/* STUFF ON MODAL */
    // $('#largeModal').on('click', '.button-notassign',  function() {

    //     if($(this).find('.material-icons').html() == 'clear'){
    //         $(this).find('.material-icons').html('reply');
    //         $(this).css('background-color', '#b7b700');
    //         $(this).parent().parent().find('.enable').removeClass('enable').addClass('disable');

    //     }else{
    //         $(this).find('.material-icons').html('clear');
    //         $(this).css('background-color', 'red');
    //         $(this).parent().parent().find('.disable').removeClass('disable').addClass('enable');
    //     }

    //     var sum = 0;
    //     $('.TOTAL_RECIPT_DOCTER').each(function(){

    //         if($(this).parent().parent().parent().hasClass('enable')){
    //             sum += parseFloat($(this).text().replace(/\./g,''));
    //         }

    //     });

    //     $('#SUMMARY_RECEIPT').empty();
    //     $('#SUMMARY_RECEIPT').html(sum.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

        
    //     $('#SUMMARY').empty();

    //     if (typeof $('#SUMMARY_ADDITIONAL').html() === "undefined") {
    //         var additional = '0';
    //     }else{
    //         var additional = $('#SUMMARY_ADDITIONAL').html();
    //     }
    //     if (typeof $('#SUMMARY_RECEIPT').html() === "undefined") {
    //         var receipt = '0';
    //     }else{
    //         var receipt = $('#SUMMARY_RECEIPT').html();
    //     }

    //     $('#SUMMARY').html( 
    //         (parseFloat(additional.replace(/\./g,'')) +  parseFloat(receipt.replace(/\./g,''))).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    //     );

    // });

    $('#largeModal').on('click', '.delete-notassign',  function() {

        $(this).parent().parent().next().remove();
        $(this).parent().parent().remove();

        $(this).removeClass('disable-med').addClass('enable-med');
        $('#MED_'+this.id.substr(7)).removeClass('disable-med').addClass('enable-med');

        if($("#section-new-med .col-sm-12").length == 2 && $('#section-new-med').has('.title-new-med').length  && $('#section-new-med').has('.footer-new-med').length){
            $('#section-new-med').empty();
        }
                        
        var sum2 = 0;
        $('.TOTAL_ADDITIONAL').each(function(){
            sum2 += parseFloat($(this).text().replace(/\./g,''));
        });

        $('#SUMMARY_ADDITIONAL').empty();
        $('#SUMMARY_ADDITIONAL').html(sum2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
        
        $('#SUMMARY').empty();

        if (typeof $('#SUMMARY_ADDITIONAL').html() === "undefined") {
            var additional = '0';
        }else{
            var additional = $('#SUMMARY_ADDITIONAL').html();
        }
        if (typeof $('#SUMMARY_RECEIPT').html() === "undefined") {
            var receipt = '0';
        }else{
            var receipt = $('#SUMMARY_RECEIPT').html();
        }

        $('#SUMMARY').html( 
            (parseFloat(additional.replace(/\./g,'')) +  parseFloat(receipt.replace(/\./g,''))).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
        );

    });


    // $('#DataTables_Table_0').on('click', '.btn-taken',  function() {
    //     if($(this).parent().prev().children().first().hasClass('btn-success') == false){
    //         alert('Obat belum dibayar');
    //     }else{
    //         var cd = table.row( $(this).parent().parent() ).data()[0];
    //         $.ajax({
    //             url: $('.mainurl').val() +'/kasir/paidCheck/'+cd,
    //             type: "GET",
    //             cache: false,
    //             success:function(data)
    //             {
    //                 var data = $.parseJSON(data);

    //                 if(data[0]['total']){
    //                     alert('data berhasil dirubah');
    //                 }else{
    //                     alert(data[0]['state']);
    //                 }
                    
    
    //             }
    //         });
    //     }
    // });


    /* --------------------------- DATA MODAL Invoice ------------------------- */
    $('#DataTables_Table_0').on('click', '.btn-taken',  function() {

        var cd = table.row( $(this).parent().parent() ).data()[0];
        $.ajax({
            url: $('.mainurl').val() +'/kasir/getmodalinvoice',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd                  : cd,
            },
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('.modal-body').empty();
                $('.save').hide();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text(data[1]);
                $('.save').attr('id', data[2]);
                $('#cd_agree').val(data['code_agree']);

            }
        });
    });
    /* !--------------------------- DATA MODAL LAB ------------------------! */


    $('#largeModal').on('click', '.assign_med',  function() {

        if($(this).hasClass('enable-med')){

            $.ajax({
                url: $('.mainurl').val() +'/kasir/getnewmed/'+this.id,
                type: "GET",
                cache: false,
                success:function(data)
                {
                    var data = $.parseJSON(data);

                    if(!$('#section-new-med').has('.title-new-med').length){
                        $('#section-new-med').append('<div class="col-sm-12 title-new-med"><label class="form-label"><h4 style="color:#fff">Data obat tambahan</h4></label><hr style="margin-top:0px"></hr></div>');
                    }

                    if(!$('#section-new-med').has('.footer-new-med').length){
                        $('#section-new-med').append(data[0]);
                    }else{
                        $( data[0] ).insertBefore( ".footer-new-med" );
                    }

                    if(!$('#section-new-med').has('.footer-new-med').length){
                        $('#section-new-med').append('<div class="col-sm-12 footer-new-med" style="margin-top:15px;background-color:#81382c;margin-bottom:25px;"><div class="col-sm-10" style="margin-top:15px"><span style="font-size:14px;color:#fff"><b>TOTAL HARGA OBAT TAMBAHAN :</b></span>                    </div>                    <div class="col-sm-2 enable" style="background-color:#e3e3e3;color:black;padding-top:10px;padding-bottom:10px;">                        <div class="form-label" style="height:25px">: Rp. <div style="text-align:right;float:right"><span id="SUMMARY_ADDITIONAL"></span> ,-</div></div>                    </div>                </div>');
                    }
    
                }
            });

            $(this).removeClass('enable-med').addClass('disable-med');
        }else{

            $('#delete_'+this.id.substr(4)).parent().parent().next().remove();
            $('#delete_'+this.id.substr(4)).parent().parent().remove();

            if($("#section-new-med .col-sm-12").length == 2 && $('#section-new-med').has('.title-new-med').length  && $('#section-new-med').has('.footer-new-med').length){
                $('#section-new-med').empty();
            }

            $(this).removeClass('disable-med').addClass('enable-med');
            
            var sum2 = 0;
            $('.TOTAL_ADDITIONAL').each(function(){
                sum2 += parseFloat($(this).text().replace(/\./g,''));
            });

            $('#SUMMARY_ADDITIONAL').empty();
            $('#SUMMARY_ADDITIONAL').html(sum2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
            
            $('#SUMMARY').empty();

            if (typeof $('#SUMMARY_ADDITIONAL').html() === "undefined") {
                var additional = '0';
            }else{
                var additional = $('#SUMMARY_ADDITIONAL').html();
            }
            if (typeof $('#SUMMARY_RECEIPT').html() === "undefined") {
                var receipt = '0';
            }else{
                var receipt = $('#SUMMARY_RECEIPT').html();
            }

            $('#SUMMARY').html( 
                (parseFloat(additional.replace(/\./g,'')) +  parseFloat(receipt.replace(/\./g,''))).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
            );
        }

    });

    $('#largeModal').on('click', '#btn-add',  function() {

        var idArray = [];
        $('.button-notassign').each(function () {
            idArray.push(this.id);
        });

        if($(this).hasClass('btn-success')){


            $.ajax({

                url: $('.mainurl').val() +'/kasir/gettablemedicine',
                type: "POST",
                data:{
                    _token              : $('meta[name="csrf-token"]').attr('content'),
                    except: JSON.stringify(idArray)
                },
                cache: false,
                success:function(data)
                {
                    var data = $.parseJSON(data);
                    
                    $('#new-medicine').empty();
                    $('#new-medicine').append(data[0]);
                    
                    $('#table-cashier-add').DataTable().destroy();
                    $('#table-cashier-add').DataTable({
                        responsive: true
                    });

                    $('.notdefined').removeClass('even odd');
                }
            });

            $(this).removeClass('btn-success').addClass('btn-danger');
            $(this).html('TUTUP TABEL OBAT');
        }else{

            $('#new-medicine').empty();

            $(this).removeClass('btn-danger').addClass('btn-success');
            $(this).html('TAMBAH OBAT');
        }

    });

    $('#largeModal').on('input', '.keypress',  function() {

        if($.isNumeric( this.value )){
            if(this.value != ''){
                var nilai = this.value;
                var aidi = this.id.substr(4);
                if($(this).hasClass('afct_med')){
                    var receipt_tot = 1;
                }else{
                    var receipt_tot = 0;
                }

                $.ajax({
                    url: $('.mainurl').val() +'/kasir/cek_nilai/'+this.id+'/'+nilai,
                    type: "GET",
                    cache: false,
                    success:function(data)
                    {
                        var data = $.parseJSON(data);

                        if(Number(nilai) <= Number(data[0])){
                            //true
                            $('#STOCK_'+aidi).html(data[0] - nilai);
                            
                            $('#TOTAL_'+aidi).html(data[1]);

                        }else{
                            //false
                            $('.alert').remove();

                            var tipe = 'danger';
                            var timer = 10;
                            $.notify({
                                message: 'Jumlah melebihi stok obat di apotek'
                            },
                            {
                                type:tipe,
                                allow_dismiss: true,
                                newest_on_top: true,
                                z_index: 9999,
                                timer: 5,
                                placement: {
                                    from: 'top',
                                    align: 'center'
                                },
                            });

                            $('#STOCK_'+aidi).html(data[0] - data[0]);
                            $('#TOTAL_'+aidi).html(data[1]);
                            $('#DET_'+aidi).val(data[0]);
                            $('#MDC_'+aidi).val(data[0]);
                            SUMMARY_RECEIPT
                        }
                        
                        var sum = 0;
                        $('.TOTAL_RECIPT_DOCTER').each(function(){
                            sum += parseFloat($(this).text().replace(/\./g,''));

                        });
                        
                        if(receipt_tot == 1){
                            $('#SUMMARY_RECEIPT').empty();
                            $('#SUMMARY_RECEIPT').html(sum.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
                        }
                        
                        var sum2 = 0;
                        $('.TOTAL_ADDITIONAL').each(function(){
                            sum2 += parseFloat($(this).text().replace(/\./g,''));
                        });

                        $('#SUMMARY_ADDITIONAL').empty();
                        $('#SUMMARY_ADDITIONAL').html(sum2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

                        var sum2 = 0;
                        $('.TOTAL_ADDITIONAL').each(function(){
                            sum2 += parseFloat($(this).text().replace(/\./g,''));
                        });

                        $('#SUMMARY').empty();

                        if (typeof $('#SUMMARY_ADDITIONAL').html() === "undefined") {
                            var additional = '0';
                        }else{
                            var additional = $('#SUMMARY_ADDITIONAL').html();
                        }
                        if (typeof $('#SUMMARY_RECEIPT').html() === "undefined") {
                            var receipt = '0';
                        }else{
                            var receipt = $('#SUMMARY_RECEIPT').html();
                        }

                        $('#SUMMARY').html( 
                            (parseFloat(additional.replace(/\./g,'')) +  parseFloat(receipt.replace(/\./g,''))).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
                        );
                    }
                });
            }else{
                alert('Terjadi kesalahan');
            }

        }else{

            if(this.value != ''){
                $('.alert').remove();
                var tipe = 'danger';
                var timer = 100;
                $.notify({
                    message: 'Anda hanya bisa menginput nomor'
                },
                {
                    type:tipe,
                    allow_dismiss: true,
                    newest_on_top: true,
                    z_index: 9999,
                    timer: 10,
                    placement: {
                        from: 'top',
                        align: 'center'
                    },
                });
            }
        }
    });

    
    /* -------------------------------- SAVE  ------------------------------- */
    $('#largeModal').on('click', '#pay_now', function () {

        $.ajax({
            url: $('.mainurl').val() +'/kasir/store_pay_now',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                payment             : $(".form-payment-cashier").serializeArray(),
                cd                  : $("#cd").val()
            },
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);
                
                if(data[0] == 0){

                    var tipe = 'danger';
                    var timer = 1000;

                }else{

                    var tipe = 'success';
                    var timer = 4000;

                    table_queue_cashier.ajax.reload();

                    setTimeout(function(){ 
                        $('#largeModal').modal('toggle');
                    }, 1000);

                }

                $.notify({
                    message: data[1]
                },
                    {
                        type:tipe,
                        allow_dismiss: true,
                        newest_on_top: true,
			            z_index: 9999,
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                    });
            }
        });
    });
    /* !---------------------------- SAVE  -----------------------------! */

});

