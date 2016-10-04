jQuery(document).ready(function ($) {

    //------------------------------------------------------------------------------------------------------------------------//        
// Scrape One article
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
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url_one').val().trim();
        
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

                                    $( "#tabs" ).tabs( "option", "active", 2 );  <!-- Activate Tab Three -->
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

                                              var xmlString = response
                                                , parser = new DOMParser()
                                                , doc = parser.parseFromString(xmlString, "text/html");



                                                    var title = false;                        
                                                    var contentDOM = false;                                                    
                                                    var nodes = doc.body.querySelectorAll('*');                                       

                                                    


                                                    for(var i = (nodes.length-1);i >= 0;i--){
                                                        
                                                        tag_name = nodes[i].nodeName.toLowerCase();
                                                        class_name = nodes[i].className.toLowerCase();    
                                                       
                                                      if ((tag_name == title_tagName) && (class_name == title_className)) {                           
                                                            title = nodes[i];
                                                        break;
                                                      }

                                                    }

                                                    for(var i = (nodes.length-1);i >= 0;i--){
                                                        tag_name = nodes[i].nodeName.toLowerCase();
                                                        class_name = nodes[i].className.toLowerCase();                                                     
                                                      
                                                      if ((tag_name == content_tagName) && (class_name == content_className)) {                           
                                                            contentDOM = nodes[i];
                                                        break;
                                                      }

                                                    }
                                                    console.log(title_tagName + title_className + content_tagName + content_className)
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
                                                          type: selected
                                                      },
                                                      success:function(data){
                                                        alert("Post success!")
                                                        //console.log(data.img);
                                                                   $('.result1').show().append("<div class='title_return'>1.\" "+data.title+" \" has been posted.</div><br />");                                                                   
                                                                    $('#wait1').hide();
                                                                    $('.result2').hide();
                                                       
                                                      }
                                                    });

                                                
                                           

                                                          


                                }     
                

                
                }


                });



            













        return false;


    });

});


