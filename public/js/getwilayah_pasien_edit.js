
    $(document).ready(function()
    {
        $('select[name="provinsi_pasien_edit"]').on('change', function() {
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
                        //$('select[name="kota_pasien_edit"]').empty();
                        $('select[name="kota_pasien_edit"]').val($("#kota_pasien_edit option:first").val());
                        $.each(data, function(key, value) {
                            $('#kota_pasien_edit').selectpicker('refresh').append('<option value="'+ key +'">'+ value +'</option>').selectpicker('refresh');
                        });

                    }
                });
            }else
            {

                $('#kota_pasien_edit').empty();
            }
        });
    });

    $(document).ready(function()
    {
        $('select[name="kota_pasien_edit"]').on('change', function() {
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
                        // $('select[name="kecamatan_pasien_edit"]').empty();
                        $('select[name="kecamatan_pasien_edit"]').val($("#kecamatan_pasien_edit option:first").val());
                        $.each(data, function(key, value) {
                            $('select[name="kecamatan_pasien_edit"]').selectpicker('refresh').append('<option value="'+ key +'">'+ value +'</option>').selectpicker('refresh');
                        });

                    }
                });
            }else
            {
                $('select[name="kecamatan_pasien_edit"]').empty();
            }
        });
    });

    // $(document).ready(function()
    // {
    //     $('select[name="kota_pasien_edit"]').on('change', function() {
    //         var stateID = $(this).val();
    //         if(stateID)
    //         {
    //             $.ajax({
    //                 url: '/kecamatan/'+stateID,
    //                 type: "GET",
    //                 dataType: "json",
    //                 cache: false,
    //                 success:function(data)
    //                 {
    //                     console.log(data);
    //                     $('select[name="kecamatan_pasien_edit"]').empty();
    //                     $.each(data, function(key, value) {
    //                         $('select[name="kecamatan_pasien_edit"]').selectpicker('refresh').append('<option value="'+ key +'">'+ value +'</option>').selectpicker('refresh');
    //                     });

    //                 }
    //             });
    //         }else
    //         {
    //             $('select[name="kecamatan_pasien_edit"]').empty();
    //         }
    //     });
    // });

    $(document).ready(function()
    {
        $('select[name="kecamatan_pasien_edit"]').on('change', function() {
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
                        // $('select[name="kelurahan_pasien_edit"]').empty();
                        $('select[name="kelurahan_pasien_edit"]').val($("#kelurahan_pasien_edit option:first").val());
                        $.each(data, function(key, value) {
                            $('select[name="kelurahan_pasien_edit"]').selectpicker('refresh').append('<option value="'+ key +'">'+ value +'</option>').selectpicker('refresh');
                        });

                    }
                });
            }else
            {
                $('select[name="kelurahan_pasien_edit"]').empty();
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