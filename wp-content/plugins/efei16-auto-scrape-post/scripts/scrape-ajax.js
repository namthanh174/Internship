jQuery(document).ready(function ($) {

        //$("#progressbar").hide(); 

        window.globalVar = 0;
        

//------------------------------------------------------------------------------------------------------------------------//        
// Scrape One article
//------------------------------------------------------------------------------------------------------------------------//
    $('#scrape-one-form').submit(function () {
        if($('#url_one').val() == ""){
            alert("please enter url!");
            die();
        }
        $('.result1').val = '';
        $('.load1').val = '';
        $('.result1').hide();
        $('#wait1').show();
        
        $('.load1').hide();
        //var progressBar = $('#progress').val();
        //var display = $('#display').val();
       

        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url_one').val().trim();
       
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data : {
                action: 'scrape_process_one_ajax',
                url: url
            },
            beforeSend: function () {
                //$("#progressbar").show();
            },
            complete: function () {
                //$("#progressbar").hide();
                
            },
            success: function(response){
               
              //alert(response.data)
//               var content = get_contains(response.filter_content);
            var content = response.filter_content;
               
               var img = get_img(response.filter_content);
               
               var title = get_title(response.data);
               //alert(title);
               
               
               
                       $.ajax({
                            type: 'GET',
                            url: ajaxurl,
                            dataType: 'json',
                            data : {
                                action: 'scrape_process_one_ajax',
                                title : title,
                                content : content,
                                img : img,
                                category_id : selected
                            },
                            success : function(response){
                                $('.result1').show().html("<div class='title_return'>1. \"" + response.data + "\" has been posted</div><br />");
                                $('#wait1').hide();
                            }
                        });
               
               
               
               
            },
            error: function(error){
                
            }
            
            
        }).done(function(response){
             var data = response.data;

             if(data){
//                 
//                  $('.result1').show().append("<div class='title_return'>1. \"" + data + "\" has been posted</div><br />");
//                   $('#wait1').hide();
             }            
             else{
//                 $('.result1').show().append("<div>This post has been posted before</div><br />");
//                  $('#wait1').hide();
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
       
        
        
        //$("#progressbar").show();
         $('.result2').val = '';
        $('.load2').val = '';
        $('#wait2').show();
        //$('.load2').hide();
        $('.result2').hide();

       

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
                                $('.result2').show().append("<div class='title_return'>"+globalVar+".  \"" + data + "\" has been posted</div> <br />");
                            }
                            
                            

                    },
                    fail: function (jqXHR, textStatus, errorThrown) {
                            alert('error')
                            console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                    }
                    });
            });
            
            

            }
            
            
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
        $('.result2').append("Completed");
        globalVar = 0;
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
    
   
    
    
    
    
   


//
// var progressbar = $( "#progressbar" ), progressLabel = $( ".progress-label" );
//        //Set ProgressBar
//            function numberWithCommas(num) {
//                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//            }
//                     
                     
//                      progressbar.progressbar({
//                              value: false,
//                              change: function() {
////                                      progressLabel.text( numberWithCommas(progressbar.progressbar( "value" )*130000 ));
//                              progressLabel.text( numberWithCommas(progressbar.progressbar( "value" )+1 )+"%");
//                              },
//                              complete: function() {
//                                      //progressLabel.text( "Completed" );
//                              }
//                            });
//            function progress() {
//                        var val = progressbar.progressbar( "value" ) || 0;
//                        progressbar.progressbar( "value", val + 1 );
//                        if ( val < 99 ) {
//                                setTimeout( progress, 100 );
//                        }
//            }
//                             setTimeout( progress, 3000 );



});
















 