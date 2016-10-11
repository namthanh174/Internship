jQuery(document).ready(function($){
//------------------------------------------------------------------------------------------------------------------------//
//Save settings of scrape pages
//------------------------------------------------------------------------------------------------------------------------//
     save_scrape_setting_ajax(); 
    function save_scrape_setting_ajax() {
           $('#save_scrape_settings-form').submit( function () {
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
    
    
});


