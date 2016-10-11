jQuery(document).ready(function ($) {

//------------------------------------------------------------------------------------------------------------------------//
//Define pattern form
//------------------------------------------------------------------------------------------------------------------------//


    define_pattern_ajax();
    function define_pattern_ajax() {
        $('#define-pattern-form').submit(function () {
            var define_url = $('#define_url').val().trim();            
            var define_title = $('#define_title').val().trim();
            var define_first_content = $('#define_first_content').val().trim();
            var define_last_content = $('#define_last_content').val().trim();
            
            if((define_url == "") || (define_title == "") || (define_first_content == "") || (define_last_content == "") ){ 
              return false;
            }

            

            $.ajax({
                type:'GET',
                url: ajaxurl,
                data:{
                    action: 'scrape_raw_content_ajax',
                    url: define_url,
                },
                success:function(data){
                  
                    l = getLocation(define_url);
                    define_url  = l.hostname;
                    define_url = define_url.replace('www.','');
                    
                    
                     var response = data;
                      var xmlString = response
                      , parser = new DOMParser()
                      , doc = parser.parseFromString(xmlString, "text/html");
                    
                 



                        var title = false;  
                        var title_class = false;
                        var title_tag = false; 
                        var parent_node  = false;                     
                        var contentDOM = false;
                        //var nodes = doc.body.getElementsByTagName('*');
                        var nodes = doc.body.querySelectorAll('*');

                        var text = false;
                        define_title = escape(define_title.toLowerCase());
                        define_first_content = escape(define_first_content.toLowerCase());
                        define_last_content  = escape(define_last_content.toLowerCase());




                        



                        for(var i= 0;i < nodes.length; i++){
                          if((nodes[i].nodeName == 'SCRIPT') || (nodes[i].nodeName == 'svg') || (nodes[i].nodeName == 'STYLE') || (nodes[i].className == 'clearfix')){
                                continue;
                            }
                          //nodeText = nodes[i].innerHTML;
                          //text = nodeText.replace(/(<([^>]+)>)/ig, '');
                          text = removeTag(nodes[i].innerHTML)
                          text = escape(text.toLowerCase());
                          if((nodes[i].nodeName == 'H1') || (nodes[i].nodeName == 'H2') ||(nodes[i].nodeName == 'H3')){

                            if(text.search(define_title) != -1){  
                              if(nodes[i].hasAttribute('class')){
                                if(nodes[i].hasAttribute('class') && (nodes[i].className != "")){
                                     //title = nodes[i];
                                     title_tag = nodes[i].nodeName;
                                     title_class = nodes[i].className;
                                     break;

                                     // console.log(title);
                                    }
                                  }else{
                                    title_tag = nodes[i].nodeName;
                                    temp = nodes[i];
                                    while(true){
                                      if(temp.hasAttribute('class') && (temp.className != "")){
                                       title_class = temp.className;
                                        break; 
                                      }else{
                                        temp = temp.parentNode;
                                      }
                                    }
                                  }          
                                
                              // title = nodes[i];
                              // break;
                            }
                          }
                      }//end for



                        for(var i = (nodes.length-1);i >= 0;i--){


                          if((nodes[i].nodeName == 'SCRIPT') || (nodes[i].nodeName == 'svg') || (nodes[i].nodeName == 'STYLE') ||(nodes[i].nodeName == 'SECTION') ||(nodes[i].className == 'clearfix')){
                                                            continue;
                                                        }
                         text = removeTag(nodes[i].innerHTML);
                          
                          text = escape(text.toLowerCase());
                          
                          
                          if ((text.search(define_first_content) != -1) && (text.search(define_last_content) != -1)) {                            
                           

                            nodeTemp = nodes[i];                                                     
                            while(true){
                             
                              if(nodeTemp.hasAttribute('class') && (nodeTemp.className != "")){
                               contentDOM = nodeTemp;
                               break;
                              }
                              nodeTemp = nodeTemp.parentNode;
                               
                              
                            }

                              nodeTemp1 = nodeTemp.parentNode; 
                              while(true){                                
                                if(nodeTemp1.hasAttribute('class') && (nodeTemp1.className != "")){
                                 parent_node = nodeTemp1;
                                 break;
                                }
                                
                                nodeTemp1 = nodeTemp1.parentNode;
                                 
                                
                              }

                            
                            
                              break;


                            
                          }

                        }

                       



               if((contentDOM != false) && (parent_node != false)){
                      
                      define_title = title_tag+"."+title_class;

                      define_contentDOM = contentDOM.nodeName+"."+contentDOM.className;


                      


                      if(parent_node.nodeName == 'BODY'){
                        define_parent_node = parent_node.nodeName+".";
                      }else{
                        define_parent_node = parent_node.nodeName+"."+parent_node.className;
                      }
                      
                     
                       $.ajax({
                              type: 'POST',
                              url: ajaxurl,
                              data: {
                                  action: 'insert_scrape_pattern_table',
                                  define_url: define_url,
                                  define_title: define_title,
                                  define_content:  define_contentDOM,
                                  define_parent_node : define_parent_node
                              },
                              success: function (response) {

                                  //alert(response);
                                  $( "#tabs" ).tabs( "option", "active", 0 );  <!-- Activate Tab one -->
                                  $('#scrape-one-form').submit();
                              },
                              error: function (error) {
                                  alert(error);
                              }


                          });       
                      
                 }else{
                  alert("Can not insert pattern");
                 }

                   
                }
            });
            
            




            return false;
        });
    }

//------------------------------------------------------------------------------------------------------------------------//
//End Define pattern form
//------------------------------------------------------------------------------------------------------------------------//






















});






