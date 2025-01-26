$(function () {
    /* --------------------- SELECT VISUS, KACAMATA, ALL ---------------------*/
       $('#select-antrian-dt').on('change', function() {
           if(this.value == 'visus'){
   
               $('.js-exportable-ajax').attr('data-original-tb', 'queue-visus');
               $('.js-exportable-ajax').DataTable().destroy();
               $.tables_js_exportable_ajax();
   
           }else if(this.value == 'kacamata'){
   
               $('.js-exportable-ajax').attr('data-original-tb', 'queue-kacamata');
               $('.js-exportable-ajax').DataTable().destroy();
               $.tables_js_exportable_ajax();
   
           }else if(this.value == 'all'){
   
               $('.js-exportable-ajax').attr('data-original-tb', 'queue-visus-all');
               $('.js-exportable-ajax').DataTable().clear().destroy();
               $.tables_js_exportable_ajax();
   
           }
       });
       /* !--------------------- SELECT VISUS, KACAMATA, ALL --------------------- !*/
   
       
       /* ------------------------------ ENTRY VISUS ----------------------------- */
       $('.js-exportable-ajax').on('click', '.entry-visus, .entry-kacamata', function () {
                   
           var code_tab = table.row( $(this).parent().parent() ).data()[0].substr(0, 3);
           if(code_tab == 'QVN' || code_tab == 'QVG'){
               var tab = 'visus';
           }else if(code_tab == 'CON'){
               var tab = 'consult';
           }
   
           $.ajax({
               url: $('.mainurl').val() +'/'+tab+'/getmodalentry/'+table.row( $(this).parent().parent() ).data()[0],
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
                       $('.popover').popover('destroy');
   
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
                var type_price = "UNDEFINED";

                if($('#queue').val().substr(0, 3) == 'QVG'){
                    type_price = "GLASSES";
                }else if($('#queue').val().substr(0, 3) == 'QVN'){
                    type_price = "VISUS";
                }
                $.ajax({
                    url: $('.mainurl').val() +'/save/service',
                    type: "POST",
                    data:{
                        _token              : $('meta[name="csrf-token"]').attr('content'),
                        cd                  : $('#queue').val(),
                        values              : values,
                        type                : type_price,
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
   
   });
   
   
   function play (no, nama_pasien, tipe){
    //    responsiveVoice.speak(
    //     "Antrian nomor.    "+no+".       atas nama. "+nama_pasien+".  Untuk pemeriksaan.",
    //     "Indonesian Female",
    //     {
    //      pitch: 1, 
    //      rate: 1, 
    //      volume: 1
    //     }
    //    );
        responsiveVoice.speak(
            "No Mor. Antrian. "+no+". Atas Nama. "+nama_pasien+". Silah. Kan! menuju, Ke Ruang, Pemeriksaan! ",
            "Indonesian Male",
            {
            pitch: 0.95, 
            rate: 0.95, 
            volume: 2
            }
        );
   
       callQueue(no, nama_pasien);
   }
   
   function callQueue(no, name)
   {
       var socket = io.connect('http://192.168.1.2:8080');
       socket.emit('count_visus', {'no': no, 'name': name});
   
       $.ajax({
           url: 'queue/patient/called',
           type: 'PUT',
           data: {
               number: no
           },
           success: function(data) {
           }
       });
   }
