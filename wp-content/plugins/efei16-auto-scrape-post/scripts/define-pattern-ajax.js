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

            $.ajax({
                type:'GET',
                url: ajaxurl,
                dataType: 'json',
                data:{
                    action: 'scrape_content_pattern_ajax',
                    url: define_url,
                },
                success:function(data){
                 var response = data.content;
                 define_url = data.domain_url;
                  var xmlString = response
                    , parser = new DOMParser()
                    , doc = parser.parseFromString(xmlString, "text/html");



                        var title = false;                        
                        var contentDOM = false;
                        //var nodes = doc.body.getElementsByTagName('*');
                        var nodes = doc.body.querySelectorAll('*');

                        var text = false;
                        define_title = escape(define_title.toLowerCase());
                        define_first_content = escape(define_first_content.toLowerCase());
                        define_last_content  = escape(define_last_content.toLowerCase());








                        for(var i= (nodes.length-1);i >= 0; i--){
                          //nodeText = nodes[i].innerHTML;
                          //text = nodeText.replace(/(<([^>]+)>)/ig, '');
                          text = removeTag(nodes[i].innerHTML)
                          text = escape(text.toLowerCase());
                          if(nodes[i].nodeName == 'H1' || nodes[i].nodeName == 'H2' ||nodes[i].nodeName == 'H3'){
                            if(text.search(define_title) != -1){
                              title = nodes[i];
                              break;
                            }
                          }
                        }


                        for(var i = (nodes.length-1);i >= 0;i--){


                          if(nodes[i].nodeName == "SCRIPT"){
                            continue;
                          }
                         text = removeTag(nodes[i].innerHTML);
                          //nodeText = nodes[i].innerHTML;
                          //text = text.replace(/(<([^>]+)>)/ig, '');
                          text = escape(text.toLowerCase());
                          //console.log(i +" : "+ text);
                          
                          if ((text.search(define_first_content) != -1) && (text.search(define_last_content) != -1)) {                            
                            nodeTemp = nodes[i]; 
                            var num = 1;                          
                            while(true){
                              if(nodeTemp.hasAttribute('class') && (nodeTemp.className != "")){
                               contentDOM = nodeTemp;
                               break;
                              }else{
                                nodeTemp = nodeTemp.parentElement;
                                
                               }
                            }

                            //contentDOM = nodes[i];
                    
                            break;
                          }

                        }
               if(contentDOM != false){
                      define_title = title.nodeName+"."+title.className;
                     define_contentDOM = contentDOM.nodeName+"."+contentDOM.className;
                     
                       $.ajax({
                              type: 'POST',
                              url: ajaxurl,
                              data: {
                                  action: 'insert_scrape_pattern_table',
                                  define_url: define_url,
                                  define_title: define_title,
                                  define_content:  define_contentDOM
                              },
                              success: function (response) {

                                  alert(response);
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






