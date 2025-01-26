
    $(document).ready(function()
    {
        $('select[name="provinsi_pasien"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID)
            {
                $.ajax({
                    url: '/kabupaten/'+stateID,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('select[name="kota_pasien"]').append('<option disabled selected> - Pilih Kabupaten - </option>');
                        $.each(data, function(key, value) {
                            $('select[name="kota_pasien"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else
            {

                $('select[name="kota_pasien"]').empty();
            }
        });
    });

    $(document).ready(function()
    {
        $('select[name="kota_pasien"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID)
            {
                $.ajax({
                    url: '/kecamatan/'+stateID,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('select[name="kecamatan_pasien"]').append('<option disabled selected> - Pilih Kecamatan - </option>');
                        $.each(data, function(key, value) {
                            $('select[name="kecamatan_pasien"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else
            {
                $('select[name="kecamatan_pasien"]').empty();
            }
        });
    });

    $(document).ready(function()
    {
        $('select[name="kota_pasien"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID)
            {
                $.ajax({
                    url: '/kecamatan/'+stateID,
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                        $('select[name="kecamatan_pasien"]').append('<option disabled selected> - Pilih Kecamatan - </option>');
                        $.each(data, function(key, value) {
                            $('select[name="kecamatan_pasien"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else
            {
                $('select[name="kecamatan_pasien"]').empty();
            }
        });
    });

    $(document).ready(function()
    {
        $('select[name="kecamatan_pasien"]').on('change', function() {
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
                        $('select[name="kelurahan_pasien"]').append('<option disabled selected> - Pilih kelurahan - </option>');
                        $.each(data, function(key, value) {
                            $('select[name="kelurahan_pasien"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else
            {
                $('select[name="kelurahan_pasien"]').empty();
            }
        });
    });

    $(document).ready(function()
    {
        $('select[name="booking_dokter"]').on('change', function() {
            $('#sum-dok').text('');
            $('select[name="booking_jam"]').empty();
            var code_docter = $(this).val();
            var nama_docter = $("#"+this.id+" option:selected").text();

            if(code_docter)
            {
                // $.ajax({
                //     url: '/getwaktuajax/'+code_docter+'/'+$('#booking_tanggal').val(),
                //     type: "GET",
                //     dataType: "json",
                //     cache: false,
                //     success:function(data)
                //     {
                //         console.log(data);
                //         $('select[name="booking_jam"]').append('<option disabled selected> - Pilih Jam Booking - </option>');
                //         $.each(data, function(key, value) {
                //             $('select[name="booking_jam"]').append('<option value="'+ value +'">'+ key +'</option>');
                //         });
                //         $('#sum-dok').text(nama_docter);
                //         $('#sum-dok').css("color", "#333");
                //     }
                // });
            }else
            {
                $('select[name="kelurahan_pasien"]').empty();
                
                $('#sum-dok').text("Belum diinput");
                $('#sum-dok').css("color", "red");
            }
        });
    });


    $(document).ready(function()
    {
        $('select[name="booking_jam"]').on('change', function() {
            $('#sum-jam').text('');
            var jam_val = $(this).val();
            var jam_name = $("#"+this.id+" option:selected").text();

            if(jam_val)
            {
                $('#sum-jam').text(jam_name);
                $('#sum-jam').css("color", "#333");
            }else{
                $('#sum-jam').text("Belum diinput");
                $('#sum-jam').css("color", "red");
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