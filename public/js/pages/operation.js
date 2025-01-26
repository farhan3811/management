$(function () {

    /* --------------------------- DATA MODAL LAB ------------------------- */
    $('.js-exportable-ajax').on('click', '.entry-lab', function () {
                
        var code_agree = table.row( $(this).parent().parent() ).data()[0];

        $.ajax({
            url: $('.mainurl').val() +'/operasi/getmodalentry/'+table.row( $(this).parent().parent() ).data()[0],
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('.modal-body').empty();
                $('.modal-body').append(data[0]);
                $('#largeModalLabel').text(data[1]);
                $('.save').attr('id', data[2]);
                $('#cd_agree').val(code_agree);
            }
        });
    });
    /* !--------------------------- DATA MODAL LAB ------------------------! */



//--------------------------

    /* -------------------------------- SAVE VISUS ------------------------------- */
    $('#largeModal').on('click', '#save-operasi', function () {

        $.ajax({
            url: $('.mainurl').val() +'/operation/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),

                cd_op                   : $('#cd_op').val(),
                diagnosa_pasca_bedah    : $('#diagnosa_pasca_bedah').val(),
                berhenti_jam_operasi    : $('#berhenti_jam_operasi').val(),
                jenis_operasi           : $('#jenis_operasi').val(),
                nama_operator           : $('#nama_operator').val(),
                kualifikasi_operator    : $('#kualifikasi_operator').val(),
                asisten                 : $('#asisten').val(),
                scrub_nurse_I           : $('#scrub_nurse_I').val(),
                scrub_nurse_II          : $('#scrub_nurse_II').val(),
                circulated_nurse        : $('#circulated_nurse').val(),
                jenis_anestesi          : $('#jenis_anestesi').val(),
                mulai_jam_anestesi      : $('#mulai_jam_anestesi').val(),
                berhenti_jam_anestesi   : $('#berhenti_jam_anestesi').val(),
                bahan_anesteticum       : $('#bahan_anesteticum').val(),
                nama_anestesist         : $('#nama_anestesist').val(),
                kualifikasi_anestesist  : $('#kualifikasi_anestesist').val(),
                golongan_operasi        : $('#golongan_operasi').val(),
                macam_operasi           : $('#macam_operasi').val(),
                urgensi_operasi         : $('#urgensi_operasi').val(),
                catatan_operator        : $('#catatan_operator').val(),

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

    /* -------------------------------- OPERASI ------------------------------- */
    $('#largeModal').on('click', '#start-operation', function () {
var cd_agree = $('#cd_agree').val();
        $.ajax({
            url: $('.mainurl').val() +'/operasi/insert_operation',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd_agree            : cd_agree
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

                    setTimeout(function(){ 
                        $("#largeModal").modal('show');
                        $.ajax({
                            url: $('.mainurl').val() +'/operasi/getmodalentry/'+$('#cd_agree').val(),
                            type: "GET",
                            cache: false,
                            success:function(data)
                            {
                                var data = $.parseJSON(data);
                
                                $('.modal-body').empty();
                                $('.modal-body').append(data[0]);
                                $('#largeModalLabel').text(data[1]);
                                $('.save').attr('id', data[2]);
                                $('#cd_agree').val(code_agree);
                            }
                        });
                    }, 2000);

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
                    cd                  : $('#cd_agree').val(),
                    values              : values,
                    type                : 'OPERATION'
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
   
   $("#current").change(function () {

        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });
    $("#refresh").click(function () {

        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });

   $('#largeModal').on('click', '#delete-price', function () {
        
        $.ajax({
            url: $('.mainurl').val() +'/delete/service',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd                  : $('#cd_agree').val()
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

