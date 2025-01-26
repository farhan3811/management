$(function () {
    
    $( ".identity-booking-offline" ).change(function() {

        $('#input-identity').attr("placeholder", $(this).next().text());

    });

    $('.card').on('click', '#submit-queue', function () {

         var type = ($("input[name='identity']:checked").val());
         var val = ($("#input-identity").val());
         if(type != '' && val != ''){
            $.ajax({
                url: $('.mainurl').val() +'/booking/' + type + '/' + val + '/0',
                type: "GET",
                cache: false,
                success:function(data)
                {
                    var data = $.parseJSON(data);

                    if(data[0] == 0){
                        $('#msg-view').removeClass();
                        $('#msg-view').addClass('alert alert-danger');
                    }else if(data[0] == 1){
                        $('#msg-view').removeClass();
                        $('#msg-view').addClass('alert alert-warning');
                    }else if(data[0] == 2){
                        $('#msg-view').removeClass();
                        $('#msg-view').addClass('alert alert-info');
                    }else if(data[0] == 9){
                        $('#msg-view').removeClass();
                        $('#msg-view').addClass('alert alert-warning');
                    }
                    
                    $('#msg-det').text(data[1]);
                    $('#msg-view').fadeIn('fast');
                    setTimeout(function() {
                        $('#msg-view').fadeOut('slow');
                        $('#msg-det').text('');
                        $('#msg-view').removeClass();
                        $('#input-identity').val('');
                        
                        if(data[0] == 9){
                            window.location = $('.mainurl').val() +'/booking/' + type + '/' + val + '/form/';
                        }
                    }, 6000);
                }
            });  

         }else{
            $(".help-block").show();
         }
    });


});

