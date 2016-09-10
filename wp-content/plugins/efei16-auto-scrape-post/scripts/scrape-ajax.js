jQuery(document).ready(function($){
	$('#scrape-form').submit(function(){
		
		$('#wait').show();
		


		var url = $('#url').val();
		var type = $('#type').val();
		
		data = {action: 'scrape_process_ajax',
				url:url,
				type:type
			};
		
		
		$.post(ajaxurl,data,function(response){
			 

			 if(response.hasOwnProperty('error')) {
			 			$('#wait').hide();
						$('.load').html('<b>Invalid URL</b>');
					}
					else if(response == false)
					{
						$('#wait').hide();
						$('.load').html('<b>Invalid URL</b>');
					}
					else {
						$('#wait').hide();
						$('.load').html("The post with id "+response+" has been posted.");
					}


					
				



				
			});


		return false;
		
	});
});

