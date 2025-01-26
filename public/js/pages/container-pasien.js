$(function () {

    /* ------------------ SELECTED TABLE SHOW DATA CONTAINER --------------------*/
    if($('.js-exportable-ajax, .js-apotek-queue').attr('selected-row') == 1){

        $('.js-exportable-ajax tbody, .js-apotek-queue tbody').on('click', 'tr', function (e) {
 
            if( 
                    (
                        $(e.target).hasClass('untouch-column') == false
                            && 
                        $(e.target).index() != 7
                    ) 
                        || 
                    (
                        $(e.target).hasClass('untouch-column') == false
                            && 
                        $(e.target).index() == 0 
                    ) 
                ) {

                if ( $(this).hasClass('selected') ) {

                    $(this).removeClass('selected');
                    $( "#container-detail" ).fadeOut( "slow", function() {
                            $('#container-detail').hide();
                            $('#container-detail').empty();
                    });
                }else {

                    $(this).DataTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                    $.ajax({
                        url: $('.mainurl').val() +'/container/patient/getcontainerpasien/'+table.row( this ).data()[0],
                        type: "GET",
                        cache: false,
                        success:function(data)
                        {
                            $('#container-detail').hide();
                            $('#container-detail').empty();
                            $('#container-detail').append(data);
                            $( "#container-detail" ).fadeIn( 500 );
                            $('#link-print').attr('href', `export/pdf/${table.row($('tr.selected')).data()[0]}`);
                        }
                    });
                }

            }
        });
    }
    /* !------------------- SELECTED TABLE SHOW DATA CONTAINER -------------------!*/




    /* ------------------- SELECTED TABLE CONTAINER DETAIL  -----------------------*/
    $('#container-detail').on('click', '.booking-detail', function () {
        
        var code_tab = table.row( $('tr.selected') ).data()[0].substr(0, 3);

        if ( $(this).hasClass('selected-booking') ) {
            $(this).removeClass('selected-booking');
                $( "#container-detail-booking" ).fadeOut( "slow", function() {
                $.identity();
            }).done(function() {
            });
        }else {

            $('.selected-booking').removeClass('selected-booking');
            $(this).addClass("selected-booking");

            $.ajax({
                url: $('.mainurl').val() +'/container/patient/getcontainerdetail/'+this.id,
                type: "GET",
                cache: false,
                success:function(data)
                {
                    $('#container-detail-booking').hide();
                    $('#container-detail-booking').empty();
                    $('#container-detail-booking').append(data);
                    $( "#container-detail-booking" ).fadeIn( 500 );
                }
            });
        }
    });
    /* !-------------------- SELECTED TABLE CONTAINER DETAIL ------------------!*/


    /* ------------------------------ DATA PASIEN ------------------------------*/
    $.identity = function(){
        
        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienidentity/'+table.row( $('tr.selected') ).data()[0],
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#container-detail-booking').show();
                $('#container-detail-booking').empty();
                $('#container-detail-booking').append(data[0]);
                
                $('#judul-container').empty();
                $('#judul-container').append(data[1]);
            }
        });
	}
    /*! ------------------------------ DATA PASIEN -------------------------- !*/

    /* ------------------------------ DATA BOOKING ----------------------------*/
    $.paragraf_booking = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienbooking/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-booking').empty();
                $('#paragraf-booking').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA BOOKING -------------------------- !*/

    
    /* ------------------------------ DATA VISUS ----------------------------*/
    $.paragraf_visus = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienvisus/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-visus').empty();
                $('#paragraf-visus').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA VISUS -------------------------- !*/
    
    /* ------------------------------ DATA a ----------------------------*/
    $.paragraf_dokter = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienconsult/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-dokter').empty();
                $('#paragraf-dokter').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA a -------------------------- !*/
    
    /* ------------------------------ DATA a ----------------------------*/
    $.paragraf_kacamata = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienglasses/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-kacamata').empty();
                $('#paragraf-kacamata').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA a -------------------------- !*/
    
    /* ------------------------------ DATA a ----------------------------*/
    $.paragraf_obat = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienmedicine/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-obat').empty();
                $('#paragraf-obat').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA a -------------------------- !*/
    
    /* ------------------------------ DATA a ----------------------------*/
    $.paragraf_lab = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienlab/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-lab').empty();
                $('#paragraf-lab').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA a -------------------------- !*/
    
    /* ------------------------------ DATA a ----------------------------*/
    $.paragraf_operation = function(){

        $.ajax({
            url: $('.mainurl').val() +'/container/patient/getcontainerpasienvisus/'+$('.selected-booking').attr('id'),
            type: "GET",
            cache: false,
            success:function(data)
            {
                var data = $.parseJSON(data);

                $('#paragraf-operation').empty();
                $('#paragraf-operation').append(data[0]);
            }
        });
	}
    /*! ------------------------------ DATA a -------------------------- !*/
});

