$(function () {
    
    /* ------------------------------ ENTRY VISUS ----------------------------- */
    $('.js-exportable-ajax, .header').on('click', '.form-service', function () {

        if(this.id.substr(0,2) == 'cr'){
            var cd = 0;
        }else if(this.id.substr(0,2) == 'up'){
            var cd = table.row( $(this).parent().parent() ).data()[0];
        }else if(this.id.substr(0,2) == 'dt'){
            var cd = table.row( $(this).parent().parent() ).data()[0];
        }

        $.ajax({
            url: $('.mainurl').val() +'/master/price/entry/'+cd+'/'+this.id.substr(0,2),
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

    /* !------------------------------ ENTRY VISUS ----------------------------! */

    /* -------------------------------- SAVE VISUS ------------------------------- */
    $('#largeModal').on('click', '#save-service-price', function () {

        $.ajax({
            url: $('.mainurl').val() +'/service/price/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd                  : $('#cd').val(),
                cd_delete           : $('#cd_delete').val(),
                service_name_data   : $('#service_name_data').val(),
                service_category_data: $('#service_category_data').val(),
                service_subcategory_data: $('#service_subcategory_data').val(),
                price_data          : $('#price_data').val(),
                is_multiple_data    : $('#is_multiple_data').val()
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
    /* !---------------------------- SAVE VISUS -----------------------------! */

    /* -------------------------------- SAVE KACAMATA ------------------------------- */
    $('#largeModal').on('click', '#save-kacamata', function () {

        $.ajax({
            url: $('.mainurl').val() +'/visus/store_kacamata',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                queue               : $('#queue').val(),
                tipe1               : (typeof($('#tipe1:checked').val()) != "undefined" 
                                        && $('#tipe1:checked').val() !== null)? 1 : 0,
                tipe2               : (typeof($('#tipe2:checked').val()) != "undefined" 
                                        && $('#tipe2:checked').val() !== null)? 1 : 0,
                pro_data            : $('#pro_data').val(),
                tahun_data          : $('#tahun_data').val(),
                receipt             : $( ".receipt" ).serializeArray(),
                tagihan             : (typeof($('#tagihan:checked').val()) != "undefined" 
                                        && $('#tagihan:checked').val() !== null)? 1 : 0,
                selesai             : (typeof($('#selesai:checked').val()) != "undefined" 
                                        && $('#selesai:checked').val() !== null)? 1 : 0,
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
    /* !---------------------------- SAVE KACAMATA -----------------------------! */

    $("#state_active, #select_type").change(function () {

        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });
    $("#refresh").click(function () {

        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });

    if($('#realtime').prop('checked') === true){

        // setInterval(function(){ 
        //     $('.js-exportable-ajax').DataTable().clear().destroy();
        //     $.tables_js_exportable_ajax();
        // }, 5000);
    }

    $('.js-exportable-ajax').on('click', '.delete-service', function () {                

        
        $('.modal-body').empty();
        $('.modal-body').append('<input id="cd_delete" value="'+table.row( $(this).parent().parent() ).data()[0]+'" type="hidden" /><p style="text-align:center;color:black"><i>Anda yakin ingin menon-aktifkan data ini?</i></p>');
        $('#largeModalLabel').text('Hapus Harga pelayanan (service)');
        $('.save').attr('id', 'save-medicine');
        $('.save').show();

    });

    $('#largeModal').on('click', '#delete-price', function () {
        
        $.ajax({
            url: $('.mainurl').val() +'/delete/service',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd                  : $('#queue').val()
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
