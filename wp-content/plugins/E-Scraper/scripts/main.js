
    

jQuery(document).ready(function($) {


    
                // if($('#input_secret_key').val() != ''){

                //           $.ajax({
                //                 type:'POST',
                //                 url: ajaxurl,              
                //                 data:{
                //                     action: 'check_session',                            
                //                 },                      
                //                 success:function(data){
                //                      console.log(1)
                //                     if(data == 'completed'){
                //                         $('#s3_setting').attr('hidden',false);
                //                         $('#choose_category').attr('disabled',false);
                //                         $('#aws_upload_enable').attr('disabled',false);
                //                     }
                //                 }
                        
                //         });  
                // }         
            

    $('#define_url').prop('required',true);
    $('#define_title').prop('required',true);
    $('#define_first_content').prop('required',true);
    $('#define_last_content').prop('required',true);
    $('#url_one').prop('required',true);


    $('#tabs').tabs();

    //Choose publish post or not
    $('.choose_publish').click(function(){
    	$('.choose_publish').attr("checked", true);
    	$('.choose_draft').removeAttr("checked");
    });
    $('.choose_draft').click(function(){
    	$('.choose_draft').attr("checked", true);
    	$('.choose_publish').removeAttr("checked");
    });



    // Show or Not Show form Add category
    $('#category-add-toggle').click(function(){    	
    	if($('#category-adder').attr('class') == 'wp-hidden-children'){
    		$('#category-adder').removeClass('wp-hidden-children');    		
    	}else{    		
    		$('#category-adder').addClass('wp-hidden-children');    		
    	}    	
    })
    //Add Category to Worspress Category
    $('#category-add-submit').click(function(){
    	var name_cat = $('#newcategory').val();
    	var parent_cat = $('#newcategory_parent').val();
    	//alert(name_cat + ' parent : '+ parent_cat);
    	data = {
    		action : 'add_category_ajax',
    		name_cat : name_cat,
    		parent_cat : parent_cat
    	}
    	$.ajax({
	    		type:'POST',
                url: ajaxurl,
                data : data,
                success: function(response){
                	console.log(response);
                	location.reload();
                },
                error : function(error){
                	console.log(error);
                }


    	})
    });




//Progress bar


    
  






    
    
});



