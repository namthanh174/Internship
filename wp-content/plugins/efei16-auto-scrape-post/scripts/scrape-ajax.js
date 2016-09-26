jQuery(document).ready(function ($) {

     

        window.globalVar = 0;
        

//------------------------------------------------------------------------------------------------------------------------//        
// Scrape One article
//------------------------------------------------------------------------------------------------------------------------//
    $('#scrape-one-form').submit(function () {
        if($('#url_one').val() == ""){
            alert("please enter url!");
            die();
        }
//        $('.result1').innerHTML  = '';
        $('.result1').empty().hide();
      
        $('#wait1').show();
       
       

        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url_one').val().trim();
       
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data : {
                action: 'scrape_process_one_ajax',
                url: url,
                type: selected
            },
            beforeSend: function () {
                //$("#progressbar").show();
            },
            complete: function () {
                //$("#progressbar").hide();
                
            },
            success: function(response){
          
                $('.result1').show().append("<div class='title_return'>1. \"" + response + "\" has been posted.</div><br />");
                  //$('.result1').show().append("<div class='title_return'>Completed</div><br />");
                   $('#wait1').hide();
                   $('.result2').hide();
          
                 
                  
             
                      
            },
            error: function(error){
                
            }
            
            
        });


        return false;


    });

//------------------------------------------------------------------------------------------------------------------------//
//Scrape Multi Articles
//------------------------------------------------------------------------------------------------------------------------//

    $('#scrape-multi-form').submit(function () {
        if($('#url_multi').val() == ""){
            alert("please enter url!");
            die();
        }
       

        $('.result2').hide().empty();
        
        //$("#progressbar").show();
         globalVar = 0;
        
        $('#wait2').show();
        //$('.load2').hide();
       

       

        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url_multi').val().trim();


        
        $.ajax({
            type: 'GET',
            url : ajaxurl,
            data : {
                action: 'scrape_process_multi_ajax',
                url: url,
                type: selected
            },
            success : function(response){
            var urls = get_urls(response);
            var content = get_contains(response);
           
            $.each(urls, function (key, url) {
                $.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    dataType: 'json',
                    data: {action: 'scrape_process_multi',
                        url: url,
                        type: selected
                    },
                    success: function (response) {
                            var data = response.data;
                            globalVar++;
                            if(data){
                                $('.result2').show().append("<div class='title_return'>"+globalVar+".  \"" + data + "\" has been posted.</div> <br />");
                            }
                            
                            

                    },
                    fail: function (jqXHR, textStatus, errorThrown) {
                            alert('error')
                            console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                    }
                    });
            });
            
            

            },
            done: function(){
               
            },
            
            
        });


        return false;


    }).ajaxSuccess(function () {
        //progressLabel.text( "Completed" );
        //$('#wait2').hide();
        //$('.load2').show().html(globalVar + " posts has been posted");
         
        

    }).ajaxStop(function(){
        //$('.load2').show().html(globalVar + " posts has been posted");
        //progressLabel.text( "Completed" );
        $('#wait2').hide();
        if(globalVar > 0){
              $('.result2').append("Completed");
        }
     
        
    });

//------------------------------------------------------------------------------------------------------------------------//
//Funtions
//-----------------------------------------------------------------------------------------------------------------------//
    
    
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
    save_scrape_setting_ajax();
    
    
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
    save_s3_setting_ajax();



    function get_urls(data) {

        var urls = [];

        $('h2', data).each(function () {
            var href = $(this).find('a').attr('href');
            if (href) {
                urls.push(href);
            }


            //res.push($(this).attr('href')+"---");
        });

        return urls;
    }

    function get_contains(filter_content) {
        
        var content = [];
       
       
        
        $('p', filter_content).each(function () {
            content.push($(this).html());
        });
        
        
       
        return content;
    }
    
    function get_img(filter_content){
         var img = [];
        $('img', filter_content).each(function () {
            img.push($(this).attr('src'));
        });
        return img;
    }
    function get_title(data){
        var title = $(data).find('h1').html();
//         $('h1',data).each(function(){
//            title.push($(this).html());
//        });
        
        return title;
    }
    
   
    
    
    
    
   





});
















 