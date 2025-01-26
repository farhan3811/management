/* <![CDATA[ */


// Jquery validate form contact
jQuery(document).ready(function(){

	$('#check_avail').submit(function(){

		var action = $(this).attr('action');

		$("#message-booking").slideUp(750,function() {
		$('#message-booking').hide();

 		$('#submit-check')
			.after(' <i class="icon-spin3 animate-spin loader"></i>')
			.attr('disabled','disabled');

		$.get(action, {
			tanggal_booking: $('#tanggal_booking').val(),
			pilih_poli: $('#pilih_poli').val(),
			id_generate_pasien: $('#id_generate_pasien').val(),
			pilih_dokter: $('#pilih_dokter').val(),
			quantity: $('#quantity').val(),
			child: $('#child').val()
	
		},
			function(data){
				document.getElementById('message-booking').innerHTML = data;
				$('#message-booking').slideDown('slow');
				$('#check_avail .loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit-check').removeAttr('disabled');
				if(data.match('success') != null) $('#check_avail').slideUp('slow');

			}
		);

		});

		return false;

	});
		});
		

  /* ]]> */