jQuery(document).ready(function ($) {

    //------------------------------------------------------------------------------------------------------------------------//        
// Scrape Content
//------------------------------------------------------------------------------------------------------------------------//
    $('#scrape-one-form').submit(function () {

        if ($('#url_one').val() == "") {
            alert("please enter url!");
            die();
        }
//        $('.result1').innerHTML  = '';
        $('.result1').empty().hide();

        $('#wait1').show();



        var selected = [];
        $('#list_categories input:checked').each(function () {
            selected.push($(this).attr('id'));
        });


        var post_status;
        
          if($('.choose_publish').attr('checked') == 'checked')
           post_status = $('.choose_publish').val()
          else
            post_status = $('.choose_draft').val()
        




        var url = $('#url_one').val().trim();


      //Scarpe One Article
      if($('#choose_one_aritcle').attr('checked') == 'checked'){


        
        $.ajax({
                type:'GET',
                url: ajaxurl,
                dataType: 'json',
                data:{
                    action: 'scrape_content_ajax',
                    url: url,
                },
                success:function(data){

                                if(data.check_url == 0){
                                   

                                    alert("Url not support");
                                    $('#wait1').hide();
                                    $('.result2').hide();

                                    $( "#tabs" ).tabs( "option", "active", 1 );  <!-- Activate Tab Three -->
                                    $('#define_url').val(data.url);
                                    $('#define_title').val('');
                                    $('#define_first_content').val('');
                                    $('#define_last_content').val('');
                                    
                                   
                                }else{

                         
                                  var response = data.content;
                                   var define_url = data.domain_url;
                                   var title_tagName = data.title_tagName;
                                   var title_className = data.title_className;
                                   var content_tagName = data.content_tagName;
                                   var content_className = data.content_className;
                                var results =  scrape_get_dom_js(response,title_tagName,title_className,content_tagName,content_className);
                                title = results.title;
                                contentDOM = results.contentDOM;

                                
                                      //console.log(title_tagName + title_className + content_tagName + content_className)
                                       console.log(title)
                                       console.log(contentDOM)



                                      
                                      var img = get_img(contentDOM.outerHTML);                                                   
                                      $.ajax({
                                        type:'POST',
                                        url: ajaxurl,
                                        dataType: 'json',
                                        data:{
                                            action: 'scrape_content_pattern_ajax_demo',
                                            content: contentDOM.outerHTML,
                                            title : title.innerText,
                                            define_url : define_url,
                                            img : img,
                                            type: selected,
                                            post_status : post_status
                                        },
                                        success:function(data){
                                          
                                          //alert("Post success!")
                                          //console.log(data.img);
                                          if(data){
                                             $('.result1').show().append("<div class='title_return'>1.\" "+data.title+" \" has been posted.</div><br />");                                                                   
                                             $('#wait1').hide();
                                          }
                                                    
                                                      
                                         
                                        },
                                        fail: function (jqXHR, textStatus, errorThrown) {
                                                              
                                                             $('#wait1').hide();
                                                              console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                                                            }
                                                          
                                      });

                                                
                                           

                                                          


                                }     
                

                
                }


                });


      } // End Scrape One aricle
            
      //Scrape Category
       if($('#choose_category').attr('checked') == 'checked'){

            //check url and get pattern from  database
            $.ajax({
                    type:'GET',
                    url: ajaxurl,
                    dataType: 'json',
                    data:{
                        action: 'scrape_content_ajax',
                        url: url,
                    },
                    success:function(data){

                                    if(data.check_url == 0){
                                       

                                        alert("Url not support");
                                        $('#wait1').hide();
                                        $('.result2').hide();

                                        $( "#tabs" ).tabs( "option", "active", 1 );  <!-- Activate Tab Three -->
                                        $('#define_url').val(data.url);
                                        $('#define_title').val('');
                                        $('#define_first_content').val('');
                                        $('#define_last_content').val('');
                                        
                                       
                                    }else{

                                      var response = data.content;
                                       var define_url = data.domain_url;
                                       var title_tagName = data.title_tagName;
                                       var title_className = data.title_className;
                                       var content_tagName = data.content_tagName;
                                       var content_className = data.content_className;
                                      

                                        var urls = get_urls(response);

                                          globalVar = 0;
                                       
                                          var urls = get_urls(response);
                                          var number_urls = urls.length;
                                          //console.log(number_urls);

                                          $.each(urls, function (key, url) {
                                            //console.log(url);
                                            $.ajax({
                                                  type: 'GET',
                                                  url: ajaxurl,
                                                  dataType: 'json',                                                 
                                                  data: {action: 'scrape_raw_content_ajax',
                                                      url: url                                                      
                                                  },
                                                  success: function(data){
                                                    //console.log(data.content);
                                                    var results =  scrape_get_dom_js(data.content,title_tagName,title_className,content_tagName,content_className);
                                                    title = results.title;
                                                    contentDOM = results.contentDOM;
                                                        
                                                     console.log(title)
                                                     console.log(contentDOM)
                                                        
                                                    var img = get_img(contentDOM.outerHTML);

                                                    $.ajax({
                                                        type:'POST',
                                                        url: ajaxurl,
                                                        dataType: 'json',
                                                        data:{
                                                            action: 'scrape_content_pattern_ajax_demo',
                                                            content: contentDOM.outerHTML,
                                                            title : title.innerText,
                                                            define_url : define_url,
                                                            img : img,
                                                            type: selected,
                                                            post_status : post_status
                                                        },
                                                        success:function(response){
                                                          number_urls--;
                                                          globalVar++;
                                                          if (response) {
                                                              $('.result1').show().append("<div class='title_return'>" + globalVar + ".  \"" + response.title + "\" has been posted.</div> <br />");
                  
                                                          }

                                                          if(number_urls == 0){
                                                            $('#wait1').hide();
                                                          }


                                                          },
                                                          fail: function (jqXHR, textStatus, errorThrown) {
                                                              number_urls--;
                                                              if(number_urls == 0){
                                                                $('#wait1').hide();
                                                              }
                                                              console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                                                          }
                                                    

                                                    }); //End sesond ajax

                                                  } // End Success

                                            });//End first send ajax

                                          }); //End Each loop
                                        }  //End Else
                                    } //End Success

                                            


                                    
                              
                    });//End check url and get pattern from  database

           
    


       }  //End Scarpe Category











  




    






        return false;


    });

});


