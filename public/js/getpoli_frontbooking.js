    
    $(document).ready(function()
    {
        $('select[name="pilih_poli"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID)
            {
                $.ajax({
                    url: '/getdokterajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('#pilih_dokter').empty();
                        if(data != ''){
                            $('#pilih_dokter').append('<option value="">- Pilih Dokter -</option>');
                            $.each(data, function(key, value) {
                                $('select[name="pilih_dokter"]').append('<option value="'+ value +'">'+ key +'</option>');
                            });
                        }else{
                            $('#pilih_dokter').append('<option value="">- Pilih Poliklinik Terlebih Dahulu -</option>');
                        }
                    }
                });
            }else
            {
                $('select[name="pilih_dokter"]').empty();
                $('#pilih_dokter').append('<option value="">- Pilih Poliklinik Terlebih Dahulu -</option>');
            }
        });

        
        $('#pilih_dokter').on('change', function() {
            var stateID = $(this).val();
            var tglbooking = $('#tanggal_booking').val();
            if(stateID)
            {
                $.ajax({
                    url: '/getwaktuajax/'+stateID+'/'+tglbooking,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('#pilih_waktu').empty();
                        if(data != ''){
                            $('#pilih_waktu').append('<option value="">- Pilih Waktu -</option>');
                            $.each(data, function(key, value) {
                                $('select[name="pilih_waktu"]').append('<option value="'+ value +'">'+ key +'</option>');
                            });
                        }else{
                            $('#pilih_waktu').append('<option value="">- Pilih Dokter Terlebih Dahulu -</option>');
                        }
                    }
                });
            }else
            {

                $('select[name="pilih_waktu"]').empty();
                $('#pilih_waktu').append('<option value="">- Pilih Dokter Terlebih Dahulu -</option>');
            }
        });
    });

  
   /* $(document).ready(function()
    {
        $('select[name="pilih_dokter"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID)
            {
                $.ajax({
                    url: '/getspesialisasi/'+stateID,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('select[name="pilih_spesialis"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="pilih_spesialis"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else
            {
                $('select[name="pilih_spesialis"]').empty();
            }
        });
    });

   /* $(document).ready(function()
    {
        $('select[name="pilih_spesialis"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID)
            {
                $.ajax({
                    url: '/kelurahan/'+stateID,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('select[name="kelurahan_dokter"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kelurahan_dokter"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else
            {
                $('select[name="kelurahan_dokter"]').empty();
            }
        });
    });


//REFERENSI URL 
// current url: http://sample.com/users
/* ajax code load from users page

$.ajax({
   url: '/yourFile.php',
   ...
});

// ajax url will be: http://sample.com/yourFile.php

2. If we don't use slash at the beginning, ajax url will add to the current url in the browser. example:

// current url: http://sample.com/users
// ajax code load from users page

$.ajax({
    url: 'yourFile.php',
    ...
});

//...ajax url will be http://simple.com/users/yourFile.php

*/