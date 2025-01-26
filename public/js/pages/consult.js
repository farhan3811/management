$(function () {
    $( document ).tooltip();

    var desc

    $("#largeModal").on('shown.bs.modal', function(){
        ClassicEditor
                .create(document.querySelector('#keterangan_data'))
                .then(editor => {
                    desc = editor
                })
                .catch(error => {
                    console.error(error)
                })
    })

    /* ------------------------------ INFO CLICK ----------------------------- */
    $('.modal-body').on('click', '.info-box', function () {
  
        if(
            (($(this).find(".material-icons").html() == '' && $(this).hasClass('bg-green') == false) || (this.id == 'info-operasi' && $(this).find(".material-icons").html() == '' && $(this).hasClass('bg-green') == false && $(this).hasClass('bg-amber') == false)) && !$('.modal-body').find('#disabled_state').length
        ){

            if(this.id == 'info-operasi'){
                $(this).addClass('bg-amber');
                $(this).find(".material-icons").html('event_available');
            }else{
                $(this).addClass('bg-green');
                $(this).find(".material-icons").html('done');
            }

            if(this.id == 'info-obat' && $(this).find(".material-icons").html() == 'done' && $(this).hasClass('bg-green')){
                $.ajax({
                    url: $('.mainurl').val() +'/konsultasi/medicine/',
                    type: "GET",
                    cache: false,
                    success:function(data)
                    {
                        var data = $.parseJSON(data);
                        
                        $('#medicine').append(data[0]);
                        $('#medicine-li').show();
                        $( "#entry-obat" ).fadeIn( 500 );
                    }
                });

            }else if(this.id == 'info-operasi' && $(this).find(".material-icons").html() == 'event_available' && $(this).hasClass('bg-amber')){
                
                $.ajax({
                    url: $('.mainurl').val() +'/konsultasi/operation/',
                    type: "GET",
                    cache: false,
                    success:function(data)
                    {
                        var data = $.parseJSON(data);
                        
                        $('#operation').append(data[0]);
                        $('#operation-li').show();
                        $( "#entry-operasi" ).fadeIn( 500 );
                    }
                });
            }

        }else if(this.id == 'info-operasi' && $(this).find(".material-icons").html() == 'done' && $(this).hasClass('bg-green') == true){
            
            alert('Anda tidak bisa merubah jadwal operasi yang telah masuk ke bidang laboratorium');

        } else{
            if(!$('.modal-body').find('#disabled_state').length){
                $(this).find(".material-icons").html('');
                $(this).removeClass('bg-green');
                $(this).removeClass('bg-amber');
                
                if(this.id == 'info-obat' && $(this).find(".material-icons").html() == '' && $(this).hasClass('bg-green') == false){

                $( "#entry-obat" ).fadeOut( 500 );
                $('#entry-obat').remove();
                $( "#medicine-li" ).fadeOut( 500 );
                $('#medicine-li').hide();

                $('#medicine-li').removeClass('active');
                $('#operation-li').removeClass('active');
                $('#medicine').removeClass('active in');
                $('#operation').removeClass('active in');
                $('#konsultasi').addClass('active in');
                $('#konsultasi-li').addClass('active');

                }else if(this.id == 'info-operasi' && $(this).find(".material-icons").html() == '' && $(this).hasClass('bg-green') == false && $(this).hasClass('bg-amber') == false){
                    
                $( "#entry-operasi" ).fadeOut( 500 );
                $('#entry-operasi').remove();
                $( "#operation-li" ).fadeOut( 500 );
                $('#operation-li').hide();
                $('#medicine').removeClass('active in');
                $('#operation').removeClass('active in');
                $('#medicine-li').removeClass('active');
                $('#operation-li').removeClass('active');
                $('#konsultasi').addClass('active in');
                $('#konsultasi-li').addClass('active');

                }
            }   
        }
    });
    /* !------------------------------ INFO CLICK ----------------------------! */

    /* !---------------------------------------------------------------------! */
    /* !---------------------------------------------------------------------! */
    /* !---------------------------------------------------------------------! */
    /* ------------------------------ ENTRY VISUS ----------------------------- */
    $('#container-detail').on('click', '.entry-visus, .entry-kacamata', function () {
                
        if($(this).hasClass('entry-kacamata')){
            var code_tab = $('#cd_kacamata').val().substr(0, 3);
            var val_tab = $('#cd_kacamata').val();
        }else if($(this).hasClass('entry-visus')){
            var code_tab = $('#cd_visus').val().substr(0, 3);
            var val_tab = $('#cd_visus').val();
        }
        if(code_tab == 'QVN' || code_tab == 'QVG'){
            var tab = 'visus';
        }

        $.ajax({
            url: $('.mainurl').val() +'/'+tab+'/getmodalentry/'+val_tab+'/bypass/',
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
    /* !------------------------------ ENTRY VISUS ----------------------------! */

    /* -------------------------------- SAVE VISUS ------------------------------- */
    $('#largeModal').on('click', '#save-visus', function () {

        $.ajax({
            url: $('.mainurl').val() +'/visus/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                queue               : $('#queue').val(),
                bypass               : $('#bypass').val(),
                visus_mata_kanan    : $('#visus_mata_kanan_data').val(),
                visus_mata_kiri     : $('#visus_mata_kiri_data').val(),
                segment_anterior    : $('#segment_anterior_data').val(),
                segment_posterior   : $('#segment_posterior_data').val(),
                penglihatan_warna   : $('#penglihatan_warna_data').val(),
                keterangan          : $('#keterangan_data').val(),
                saran               : $('#saran_data').val(),
                kacamata             : (typeof($('#kacamata:checked').val()) != "undefined" 
                                        && $('#kacamata:checked').val() !== null)? 1 : 0,
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


    /* -------------------------------- SAVE KACAMATA ------------------------------- */
    $('#largeModal').on('click', '#save-kacamata', function () {

        $.ajax({
            url: $('.mainurl').val() +'/visus/store_kacamata',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                queue               : $('#queue').val(),
                bypass               : $('#bypass').val(),
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
    /* !---------------------------- SAVE VISUS -----------------------------! */
    /* !---------------------------------------------------------------------! */
    /* !---------------------------------------------------------------------! */
    /* !---------------------------------------------------------------------! */


    /* --------------------------- DATA MODAL CONSULT ------------------------- */
    $('.js-exportable-ajax').on('click', '.entry-consult', function () {
                
        var code_tab = table.row( $(this).parent().parent() ).data()[0].substr(0, 3);

        $.ajax({
            url: $('.mainurl').val() +'/konsultasi/getmodalentry/'+table.row( $(this).parent().parent() ).data()[0],
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
    /* !--------------------------- DATA MODAL CONSULT ------------------------! */

    /* -------------------------------- SAVE CONSULT ------------------------------- */
    $('#largeModal').on('click', '#save-consult', function () {
        $.ajax({
            url: $('.mainurl').val() +'/konsultasi/store',
            type: "POST",
            data:{
                _token              : $('meta[name="csrf-token"]').attr('content'),
                cd_bkd              : $('#queue').val(),
                kacamata            : ($('#info-kacamata').find(".material-icons").html() == 'done' 
                                        || $('#info-kacamata').hasClass('bg-green'))?  1 : 0,
                obat                : ($('#info-obat').find(".material-icons").html() == 'done' 
                                        || $('#info-obat').hasClass('bg-green'))?  1 : 0,
                rujukan             : ($('#info-rujukan').find(".material-icons").html() == 'done' 
                                        || $('#info-rujukan').hasClass('bg-green'))?  1 : 0,
                operasi             : ($('#info-operasi').find(".material-icons").html() == 'event_available'       || $('#info-operasi').find(".material-icons").html() == 'done'               || $('#info-operasi').hasClass('bg-amber')
                                        || $('#info-operasi').hasClass('bg-green'))?  1 : 0,
                med                 : $( ".form-entry-med" ).serializeArray(),
                tot                 : $( ".form-entry-med-tot" ).serializeArray(),
                // lab                 : $( ".form-entry-lab" ).serializeArray(),
                ket_lab             : $('#ket_lab').val(),
                keterangan          : desc.getData(),
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
    /* !---------------------------- SAVE VISUS -----------------------------! */

    $("#current").change(function () {

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
    
    $('#largeModal').on('click', '.medicine-check', function () {
        if( $(this).is(':checked') ) {
           $(this).next().next().css('display', 'block');
        }else{
            $(this).next().next().css('display', 'none');
        }
    });



    $('#largeModal').on('change', '#jenis_operasi', function() {
  
        if($(this).val() != ''){
            $.ajax({
                url: $('.mainurl').val() +'/konsultasi/operation_step/'+$(this).val(),
                type: "GET",
                cache: false,
                success:function(data)
                {
                    var data = $.parseJSON(data);
                    $('#operation-section').show();
                    $('#1_diagnosis_kerja .panel-body').text(data[0].operation_type.diagnosis_kerja);
                    $('#2_diagnosis_banding .panel-body').text(data[0].operation_type.diagnosis_banding);
                    $('#3_tindakan_kedokteran .panel-body').text(data[0].operation_type.tindakan_kedokteran);
                    $('#4_indikasi_tindakan .panel-body').text(data[0].operation_type.indikasi_tindakan);
                    $('#5_tata_cara .panel-body').text(data[0].operation_type.tata_cara);
                    $('#6_tujuan .panel-body').text(data[0].operation_type.tujuan);
                    $('#7_resiko_tindakan .panel-body').text(data[0].operation_type.resiko_tindakan);
                    $('#8_komplikasi .panel-body').text(data[0].operation_type.komplikasi);
                    $('#9_prognosis .panel-body').text(data[0].operation_type.prognosis);
                    $('#10_alternatif_dan_resiko .panel-body').text(data[0].operation_type.alternatif_dan_resiko);
                    $('#11_lain .panel-body').text(data[0].operation_type.lain_lain);
                    
                   
                }
            });       
        }else{
            $('#operation-section').hide();
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

        var free = typeof($('#free-service:checked').val()) != "undefined" 
        && $('#free-service:checked').val() !== null? 1 : 0;

        if(values){
            $.ajax({
                url: $('.mainurl').val() +'/save/service',
                type: "POST",
                data:{
                    _token              : $('meta[name="csrf-token"]').attr('content'),
                    cd                  : $('#queue').val(),
                    values              : values,
                    type                : 'VISUS',
                    free                : free
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

