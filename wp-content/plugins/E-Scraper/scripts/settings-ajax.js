jQuery(document).ready(function($){
//------------------------------------------------------------------------------------------------------------------------//
//Save settings of scrape pages
//------------------------------------------------------------------------------------------------------------------------//
     
   
   
    
//------------------------------------------------------------------------------------------------------------------------//
//Save setting setting of AWS S3 Amazon
//------------------------------------------------------------------------------------------------------------------------//   
    save_s3_setting_ajax();
    function save_s3_setting_ajax() {
           $('#s3-setting-form').submit( function () {
                var b =  $(this).serialize();
                $.post( 'options.php', b ).error( 
                    function() {
                        alert('error');
                    }).success( function() {
                        alert('success');   
                    });
                    return false;    
                });
            }




//------------------------------------------------------------------------------------------------------------------------//
//Add License
//------------------------------------------------------------------------------------------------------------------------//   



 check_license_ajax();
    function check_license_ajax() {
           $('#upgrade-pro-form').submit( function () {

            
                var b =  $(this).serialize();
               console.log(b);

                var license = $('#input_license').val().trim();
                var secret_key = $('#input_secret_key').val().trim();
                var domain_register = window.location.host;
                console.log(domain_register);
                

                $.ajax({
                    type:'POST',
                    url: ajaxurl,
                    dataType: 'json',                
                    data:{
                        action: 'check_license_ajax',
                        license: license,
                        secret_key : secret_key,
                        domain_register : domain_register
                    },                      
                    success:function(data){
                        console.log(data);
                        if(data.error){
                            alert(data.error);
                            return false;
                        }else{
                            console.log(0);
                            if(data.option != ''){
                                console.log(1)
                                return false;
                            }
                            console.log(2)
                            $.post( 'options.php', b ).error( 
                                function() {
                                    alert('error');
                                }).success( function() {
                                    alert('success');
                                        // $('#s3_setting').attr('hidden',false);
                                        // $('#choose_category').attr('disabled',false);
                                        // $('#aws_upload_enable').attr('disabled',false);
                                    location.reload();   
                                });

                        }
                    
                    }


                });



                    return false;    




                });
            }





//------------------------------------------------------------------------------------------------------------------------//
//Delete License
//------------------------------------------------------------------------------------------------------------------------//   
    delete_license();
    function delete_license(){
    $('#upgrade_pro_delete').click(function(){

        console.log(0)
           $.ajax({
                        type:'POST',
                        url: ajaxurl,              
                        data:{
                            action: 'delete_license',                            
                        },                      
                        success:function(data){
                            console.log(1)
                            if(data == 'completed'){
                                var license = $('#input_license').empty;
                                var secret_key = $('#input_secret_key').empty;
                                location.reload();
                            }
                        }
                });


    });

    return false;
}




check_api();
function check_api(){
    $('#check_api').click(function(){
        console.log(0)
           $.ajax({
                        type:'POST',
                        url: ajaxurl,              
                        data:{
                            action: 'check_api',                            
                        },                      
                        success:function(data){
                            console.log(1);
                            console.log(data);
                        }
                });

           return false;
    });
}








    
    
});//End jquery






