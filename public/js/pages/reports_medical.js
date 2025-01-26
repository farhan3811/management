$(function () {

    $('.js-exportable-ajax, .header').on('click', '.medical-reports', function () {

        if(this.id.substr(0,2) == 'cr'){
            var cd = 0;
        }else if(this.id.substr(0,2) == 'up'){
            var cd = table.row( $(this).parent().parent() ).data()[0];
        }else if(this.id.substr(0,2) == 'dt'){
            var cd = table.row( $(this).parent().parent() ).data()[0];
        }

        $.ajax({
            url: $('.mainurl').val() +'/master/lab/entry/'+cd+'/'+this.id.substr(0,2),
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

 /* ------------------------------ DELETE  ----------------------------- */
 $('.js-exportable-ajax').on('click', '.delete-lab', function () {                

        
    $('.modal-body').empty();
    $('.modal-body').append('<input id="cd_delete" value="'+table.row( $(this).parent().parent() ).data()[0]+'" type="hidden" /><p style="text-align:center"><i>Anda yakin ingin menghapus data ini?</i></p>');
    $('#largeModalLabel').text('Data Detail Lab');
    $('.save').attr('id', 'save-lab');
    $('.save').show();

});
/* !------------------------------ DETAIL  ----------------------------! */

/* -------------------------------- SAVE  ------------------------------- */
$('#largeModal').on('click', '#save-lab', function () {

    $.ajax({
        url: $('.mainurl').val() +'/master/lab/store',
        type: "POST",
        data:{
            _token              : $('meta[name="csrf-token"]').attr('content'),
            cd                  : $('#cd').val(),
            cd_delete           : $('#cd_delete').val(),
            group_lab_data      : $('#group_lab_data').val(),
            detail_lab_data     : $('#detail_lab_data').val(),
            satuan_data         : $('#satuan_data').val(),
            nilai_normal_data   : $('#nilai_normal_data').val(),
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



});

