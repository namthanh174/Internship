jQuery(document).ready(function ($) {

    //------------------------------------------------------------------------------------------------------------------------//        
// Scrape Content
//------------------------------------------------------------------------------------------------------------------------//
    $('#scrape-one-form').submit(function () {
      

      var progressbar = $( "#progressbar" );
      var val = 10;
      progressbar.progressbar({'value':val});





        if ($('#url_one').val() == "") {
            return false;
        }

        $('.result1').empty().hide();

        // $('#wait1').show();



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
        l = getLocation(url);
        define_url  = l.hostname;
        define_url = define_url.replace('www.','');


      //Scarpe One Article
      if($('#choose_one_aritcle').attr('checked') == 'checked'){

        console.log(define_url);
        
        $.ajax({
                type:'GET',
                url: ajaxurl,
                dataType: 'json',
                data:{
                    action: 'scrape_content_ajax',
                    url: define_url,
                },                      
                success:function(data){
                              val += 20;
                               progressbar.progressbar({'value':val});
                                if(data.check_url == 0){
                                   

                                    alert("Url not support");
                                    // $('#wait1').hide();
                                    // $('.result2').hide();

                                    $( "#tabs" ).tabs( "option", "active", 1 );  <!-- Activate Tab Three -->
                                    $('#define_url').val(url);
                                    $('#define_title').val('');
                                    $('#define_first_content').val('');
                                    $('#define_last_content').val('');
                                    
                                   
                                }else{

                                   var title_tagName = data.title_tagName;
                                   var title_className = data.title_className;
                                   var content_tagName = data.content_tagName;
                                   var content_className = data.content_className;
                                   var parent_tagName = data.parent_tagName;
                                   var parent_className = data.parent_className;

                                  console.log(title_tagName);
                                  console.log(title_className);
                                  console.log(content_tagName);
                                  console.log(content_className);
                                  console.log(parent_tagName);
                                  console.log(parent_className);
                                  
                                                            
                                   

                                   $.ajax({
                                        type:'GET',
                                        url: ajaxurl,
                                        data:{
                                            action: 'scrape_raw_content_ajax',
                                            url: url,
                                        },
                                        success:function(data){
                                          val += 30;
                                           progressbar.progressbar({'value':val});
                                          progress = 30
                                            var response = data;
                                                      var results =  scrape_get_dom_js(response,title_tagName,title_className,content_tagName,content_className,
                                            parent_tagName,parent_className);
                                          title = results.title;
                                          contentDOM = results.contentDOM;

                                              
                                              var img = get_img(contentDOM.outerHTML);                                                   
                                              $.ajax({
                                                type:'POST',
                                                url: ajaxurl,
                                                dataType: 'json',
                                                data:{
                                                    action: 'scrape_post_content_ajax',
                                                    content: contentDOM.innerHTML,
                                                    title : title.innerText,
                                                    define_url : define_url,
                                                    img : img,
                                                    type: selected,
                                                    post_status : post_status
                                                },                                                
                                                success:function(data){
                                                  val += 40;
                                                   progressbar.progressbar({'value':val});
                                                 if(data){
                                                     $('.result1').show().append("<div class='title_return'>1.\" "+data.title+" \" has been posted.</div><br />");                                                                  
                                                    
                                                  }else{
                                                    $('.result1').show().append("<div class='title_return'>The Post has been posted before.</div><br />"); 
                                                  }
                                                           
                                                 
                                                },
                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                       progressbar.progressbar({'value':100});
                                                                     // $('#wait1').hide();
                                                                      console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                                                                    }
                                                                  
                                              });//End ajax post

                                                }
                                      });//end ajax get content
                                    

                                                          


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
                        url: define_url,
                    },
                    success:function(data){
                                    val += 10;
                                   progressbar.progressbar({'value':val});
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


                                           var title_tagName = data.title_tagName;
                                           var title_className = data.title_className;
                                           var content_tagName = data.content_tagName;
                                           var content_className = data.content_className;
                                           var parent_tagName = data.parent_tagName;
                                           var parent_className = data.parent_className;



                                      

                                      //Ajax get contents from url
                                       $.ajax({
                                                  type: 'GET',
                                                  url: ajaxurl,                                                                                                   
                                                  data: {action: 'scrape_raw_content_ajax',
                                                      url: url                                                      
                                                  },
                                                  success: function(data){
                                                                val += 10;
                                                               progressbar.progressbar({'value':val});
                                                              var response = data;
                                                    

                                                              globalVar = 0;
                                                           
                                                              var urls = get_urls(response);

                                                              console.log(urls);
                                                              var number_urls = urls.length;
                                                              //console.log(number_urls);
                                                              num_temp = 70/number_urls;
                                                              $.each(urls, function (key, url) {
                                                                //console.log(url);
                                                                $.ajax({
                                                                      type: 'GET',
                                                                      url: ajaxurl,                                                
                                                                      data: {action: 'scrape_raw_content_ajax',
                                                                          url: url                                                      
                                                                      },
                                                                      success: function(data){
                                                                        //console.log(data.content);
                                                                        var results =  scrape_get_dom_js(data,title_tagName,title_className,content_tagName,content_className,parent_tagName,parent_className);
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
                                                                                action: 'scrape_post_content_ajax',
                                                                                content: contentDOM.outerHTML,
                                                                                title : title.innerText,
                                                                                define_url : define_url,
                                                                                img : img,
                                                                                type: selected,
                                                                                post_status : post_status
                                                                            },
                                                                            success:function(response){

                                                                              val += num_temp;
                                                                              
                                                                              progressbar.progressbar({'value': val});
                                                                              number_urls--;
                                                                              globalVar++;
                                                                              if (response) {
                                                                                  $('.result1').show().append("<div class='title_return'>" + globalVar + ".  \"" + response.title + "\" has been posted.</div> <br />");
                                      
                                                                              }

                                                                              if(number_urls == 0){
                                                                                $('#wait1').hide();
                                                                                $('.result1').show().append("<div class='title_return'>Completed.</div> <br />");
                                      
                                                                              }


                                                                              },
                                                                              error : function (jqXHR, textStatus, errorThrown) {
                                                                                  number_urls--;
                                                                                  if(number_urls == 0){
                                                                                    $('#wait1').hide();
                                                                                    $('.result1').show().append("<div class='title_return'>Completed.</div> <br />");
                                                                                  }
                                                                                  console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                                                                              }
                                                                        

                                                                        }); //End sesond ajax

                                                                      } // End Success

                                                                });//End first send ajax

                                                              }); //End Each loop
                                                  }


                                            });//End ajax get contents from url

                                      

                                        
                                   }  //End Else
                        } //End Success

                                            


                                    
                              
                    });//End check url and get pattern from  database

           
    


       }  //End Scarpe Category




        return false;


    });

});


