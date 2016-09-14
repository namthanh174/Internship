jQuery(document).ready(function($){

	$('#scrape-form').submit(function(){
		
		$('#wait').show();
		
		var selected = [];
			$('#type input:checked').each(function() {
			    selected.push($(this).attr('id'));
			});

		var url = $('#url').val();
		// var type = $('#type').val();
		
		data = {action: 'scrape_process_ajax',
				url:url,
				type:selected
			};
		
		
		$.post(ajaxurl,data,function(response){
			 
			
			 if(response.hasOwnProperty('error')) {
			 			$('#wait').hide();
						$('.load').html('<b>Invalid URL 1</b>');
					}
					else if(response == false)
					{
						$('#wait').hide();
						$('.load').html('<b>Invalid URL 2</b>');
					}
					else {
						$('#wait').hide();
						$('.load').html(response);
					}

				
			});


		return false;
		
	});
});



 