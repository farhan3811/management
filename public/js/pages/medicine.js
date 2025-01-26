$(function () {

    $('.js-exportable-ajax, .header').on('click', '.form-price-medicine', function () {

        if(this.id.substr(0,2) == 'cr'){
            var cd = 0;
        }else if(this.id.substr(0,2) == 'up'){
            var cd = table.row( $(this).parent().parent() ).data()[0];
        }else if(this.id.substr(0,2) == 'dt'){
            var cd = table.row( $(this).parent().parent() ).data()[0];
        }

        $.ajax({
            url: $('.mainurl').val() +'/master/obat/entry/'+cd+'/'+this.id.substr(0,2),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('.modal-body').empty();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text(data[1]);
                $('.save').attr('id', data[2]);
                $('.save').show();
            }
        });
    });

    /* ------------------------------ EDIT  ----------------------------- */
    // $('.js-exportable-ajax').on('click', '.entry-medicine', function () {                

    //     $.ajax({
    //         url: $('.mainurl').val() +'/master/obat/entry/'+table.row( $(this).parent().parent() ).data()[0],
    //         type: "GET",
    //         cache: false,
    //         success:function(data)
    //         {
    //             var data = $.parseJSON(data);

    //             $('.modal-body').empty();
    //             $('.modal-body').append(data[0]);
    //             $('#largeModalLabel').text(data[1]);
    //             $('.save').attr('id', data[2]);
    //             $('.save').show();
    //         }
    //     });
    // });
    /* !------------------------------ ENTRY  ----------------------------! */

    /* ------------------------------ DETAIL  ----------------------------- */
    // $('.js-exportable-ajax').on('click', '.detail-medicine', function () {                

    //     $.ajax({
    //         url: $('.mainurl').val() +'/master/obat/entry/'+table.row( $(this).parent().parent() ).data()[0],
    //         type: "GET",
    //         cache: false,
    //         success:function(data)
    //         {
    //             var data = $.parseJSON(data);

    //             $('.modal-body').empty();
    //             $('.modal-body').append(data[0]);
    //             // $('.modal-body  input').attr('readonly', true);
    //             $('#largeModalLabel').text('Data Detail Obat');
    //             $('.save').attr('id', 'save');
    //             $('.save').hide();
    //         }
    //     });
    // });
    /* !------------------------------ DETAIL  ----------------------------! */

    /* ------------------------------ DELETE  ----------------------------- */
    $('.js-exportable-ajax').on('click', '.delete-medicine', function () {                

        
        $('.modal-body').empty();
        $('.modal-body').append('<input id="cd_delete" value="'+table.row( $(this).parent().parent() ).data()[0]+'" type="hidden" /><p style="text-align:center"><i>Anda yakin ingin menghapus data ini?</i></p>');
        $('#largeModalLabel').text('Data Detail Obat');
        $('.save').attr('id', 'save-medicine');
        $('.save').show();

    });
    /* !------------------------------ DETAIL  ----------------------------! */

    /* -------------------------------- SAVE  ------------------------------- */
    $('#largeModal').on('click', '#save-medicine', function () {

        $.ajax({
            url: $('.mainurl').val() +'/master/obat/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd                  : $('#cd').val(),
                cd_delete           : $('#cd_delete').val(),
                nama_obat_data      : $('#nama_obat_data').val(),
                satuan_jenis_data   : $('#satuan_jenis_data').val(),
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

                    table.ajax.reload();

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


    

    /* ------------------------------ STOCK  ----------------------------- */
    $('.js-exportable-ajax').on('click', '.stock-medicine', function () {                

        var cd_med = table.row( $(this).parent().parent() ).data()[0];
        
        $.ajax({
            url: $('.mainurl').val() +'/master/obat/stock/'+table.row( $(this).parent().parent() ).data()[0],
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);
                $('.modal-body').empty();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text('Data Stock & Harga Beli Obat : '+data[3]);
                $('#cd_med').val(cd_med);
                $('.save').attr('id', 'save');
                $('.save').hide();
                autosize($('textarea.auto-growth'));

                $('#table-medicine-stock').DataTable().destroy();
                $.tables_js_exportable_ajax('table-medicine-stock');

            }
        });
    });
    /* !------------------------------ STOCK  ----------------------------! */

    /* ------------------------------ PRICE  ----------------------------- */
    $('.js-exportable-ajax').on('click', '.price-medicine', function () {   
        
        var cd_med = table.row( $(this).parent().parent() ).data()[0];

        $.ajax({
            url: $('.mainurl').val() +'/master/obat/price/'+table.row( $(this).parent().parent().parent() ).data()[0],
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);
                $('.modal-body').empty();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text('Data History Harga Jual Obat : '+data[3]);
                $('#cd_med').val(cd_med);
                $('.save').attr('id', 'save');
                $('.save').hide();
                autosize($('textarea.auto-growth'));
                $('#table-medicine-price').DataTable().destroy();
                $.tables_js_exportable_ajax('table-medicine-price');
            }
        });
    });

    $("#largeModal").on("hidden.bs.modal", function () {
        $('.js-exportable-ajax').DataTable().destroy();
        $.tables_js_exportable_ajax();
    });
    /* !------------------------------ PRICE  ----------------------------! */


    /* ------------------------ SHOW HIDDEN FORM PRICE--------------------- */
    $('#largeModal').on('click', '#tambah-price', function () {   

        if($('#form-tambah').css('display') == 'none'){
            $('#form-tambah').css('display', 'block');
            $('#button-hidden-price').css('display', 'block');

        }else{
            $('#form-tambah').css('display', 'none');

                $('#button-hidden-price').css('display', 'none');
                /* ------------------------------ TAMBAH PRICE  ----------------------------- */                
                var id = this.id;
                if($('#harga_jual_terbaru').val() != ''){
                    $.ajax({
                        url: $('.mainurl').val() +'/master/price/store',
                        type: "POST",
                        data:{
                            _token              : $('meta[name="csrf-token"]').attr('content'),
                            cd                  : $('#cd_med').val(),
                            harga_jual          : $('#harga_jual_terbaru').val(),
                            id                  : id,
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

                                $('.js-exportable-ajax').DataTable().destroy();
                                $.tables_js_exportable_ajax();

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
                }else{
                    $.notify({
                            message: 'Data Harga Jual Baru Harus Diisi'
                        },
                            {
                                type:'danger',
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
            /* !------------------------------ PRICE  ----------------------------! */
        }
    });
    /* !------------------------------ PRICE  ----------------------------! */
    
    $('#largeModal').on('click', '#button-hidden-price', function () {   
        $('#form-tambah').css('display', 'none');
        $('#button-hidden-price').css('display', 'none'); 
    });

    /* ------------------------ SHOW HIDDEN FORM STOCK--------------------- */
    $('#largeModal').on('click', '#tambah-stock', function () {   

        if($('#form-stock-med').css('display') == 'none'){
            $('#form-stock-med').css('display', 'block');
            $('#form-unit-med').css('display', 'block');
            $('#form-total-med').css('display', 'block');
            $('#button-hidden-stock').css('display', 'block');

        }else{
            $('#form-stock-med').css('display', 'none');
            $('#form-unit-med').css('display', 'none');
            $('#form-total-med').css('display', 'none');

                $('#button-hidden-stock').css('display', 'none');
                /* ------------------------------ TAMBAH STOCK  ----------------------------- */                
                var id = this.id;
                if($('#stock_terbaru').val() != '' && $('#harga_beli_unit').val() != '' && $('#harga_beli_total').val() != ''){

                    $.ajax({
                        url: $('.mainurl').val() +'/master/stock/store',
                        type: "POST",
                        data:{
                            _token              : $('meta[name="csrf-token"]').attr('content'),
                            cd                  : $('#cd_med').val(),
                            stock_terbaru       : $('#stock_terbaru').val(),
                            harga_beli_unit     : $('#harga_beli_unit').val(),
                            harga_beli_total    : $('#harga_beli_total').val(),
                            id                  : id,
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

                                $('.js-exportable-ajax').DataTable().destroy();
                                $.tables_js_exportable_ajax();

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
                }else{
                    $.notify({
                            message: 'Semua Kolom Inputan Harus Diisi'
                        },
                            {
                                type:'danger',
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
            /* !------------------------------ STOCK  ----------------------------! */
        }
    });
        
    $('#largeModal').on('click', '#button-hidden-stock', function () {   

        $('#form-stock-med').css('display', 'none');
        $('#form-unit-med').css('display', 'none');
        $('#form-total-med').css('display', 'none');
        $('#button-hidden-stock').css('display', 'none'); 
    });

    $('#largeModal').on('click', '.delete-price-medicine', function () {   
        // alert(table.row( $(this).parent().parent().parent() ).data()[0]);
        if (confirm('Anda yakin ingin menghapus baris ini?')) {

            $.ajax({
                url: $('.mainurl').val() +'/master/price/store',
                type: "POST",
                data:{
                    _token              : $('meta[name="csrf-token"]').attr('content'),
                    cd_delete           : table.row( $(this).parent().parent().parent() ).data()[0],
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

                        $('#table-medicine-price').DataTable().destroy();
                        $.tables_js_exportable_ajax('table-medicine-price');

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

        } 
    });

    $('#largeModal').on('click', '.delete-stock-medicine', function () {   
        // alert(table.row( $(this).parent().parent().parent() ).data()[0]);
        if (confirm('Anda yakin ingin menghapus baris ini?')) {

            $.ajax({
                url: $('.mainurl').val() +'/master/stock/store',
                type: "POST",
                data:{
                    _token              : $('meta[name="csrf-token"]').attr('content'),
                    cd_delete           : table.row( $(this).parent().parent().parent() ).data()[0],
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

                        $('#table-medicine-stock').DataTable().destroy();
                        $.tables_js_exportable_ajax('table-medicine-stock');

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

        } 
    });
});

