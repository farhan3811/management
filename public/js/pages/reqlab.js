$(function () {

    /* --------------------------- DATA MODAL LAB ------------------------- */
    $('.js-exportable-ajax').on('click', '.entry-lab', function () {
                
        var code_tab = table.row( $(this).parent().parent() ).data()[0].substr(0, 3);

        $.ajax({
            url: $('.mainurl').val() +'/req_lab/getmodalentry/'+table.row( $(this).parent().parent() ).data()[0],
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('.modal-body').empty();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text(data[1]);
                $('.save').attr('id', data[2]);
            }
        });
    });
    /* !--------------------------- DATA MODAL LAB ------------------------! */


    $("#current").change(function () {

        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });
    $("#refresh").click(function () {

        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });

//--------------------------

    /* -------------------------------- SAVE VISUS ------------------------------- */
    $('#largeModal').on('click', '#save-lab', function () {

        $.ajax({
            url: $('.mainurl').val() +'/req_lab/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),

                val                 : $( ".value-reqlab" ).serializeArray(),
                stat                 : $( ".state-reqlab" ).serializeArray(),
                selesai                 : (typeof($('#selesai:checked').val()) != "undefined" 
                && $('#selesai:checked').val() !== null)? 1 : 0,
                tagihan                 : (typeof($('#tagihan:checked').val()) != "undefined" 
                && $('#tagihan:checked').val() !== null)? 1 : 0,
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
    
    $('#largeModal').on('click', '.medicine-check', function () {
        if( $(this).is(':checked') ) {
           $(this).next().next().css('display', 'block');
        }else{
            $(this).next().next().css('display', 'none');
        }
    });

    /* -------------------------------- SAVE KACAMATA ------------------------------- */
    $('#largeModal').on('click', '#save-price', function () {
            
        var checkedPrice = $( ".getcheckedserv" ).serializeArray();
        var values = {};
        var x = 0;
        jQuery.each( checkedPrice, function( i, val ) {
            values[x] = {};
            values[x]['cd'] = val.value;
            values[x]['tot'] = $('#qtyprice-'+val.value).val();
            x = x + 1;
        });
        
        if(values){

            $.ajax({
                url: $('.mainurl').val() +'/save/service',
                type: "POST",
                data:{
                    _token              : $('meta[name="csrf-token"]').attr('content'),
                    cd                  : $('#cd_con').val(),
                    values              : values,
                    type                : 'REQLAB'
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
                        var timer = 1000;

                        $('.popover').remove();
                        $('#tagihan').attr('checked', true);
                        $('#tagihan-label').text('Masukkan ke tagihan ('+data[2]+')');
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
                message: "Harus diisi minimal 1 harga. Apabila tidak ada yang diinput/gratis silahkan tutup daftar harga ini."
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

    $('#largeModal').on('click', '#delete-price', function () {

        $.ajax({
            url: $('.mainurl').val() +'/delete/service',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd                  : $('#cd_con').val()
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
                    var timer = 1000;

                    $('.popover').remove();
                    $('#tagihan').attr('checked', true);
                    $('#tagihan-label').text('Masukkan ke tagihan ('+data[2]+')');
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

});

