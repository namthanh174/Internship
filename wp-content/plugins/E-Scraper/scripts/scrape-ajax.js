jQuery(document).ready(function ($) {

//------------------------------------------------------------------------------------------------------------------------//
//Funtions
//-----------------------------------------------------------------------------------------------------------------------//

    window.get_urls;
    get_urls = function get_urls(data) {

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
    
   window.get_contains;
   get_contains =  function get_contains(filter_content) {

        var content = [];



        $('p', filter_content).each(function () {
            content.push($(this).html());
        });



        return content;
    }
   window.get_img;
    get_img = function get_img(filter_content) {
        var img = [];
        $('img', filter_content).each(function () {
            img.push($(this).attr('src'));
        });
        return img;
    }
    window.get_title;
    get_title = function get_title(data) {
        var title = $(data).find('h1').html();
//         $('h1',data).each(function(){
//            title.push($(this).html());
//        });

        return title;
    }

    window.removeTag = function removeTag(text){
      text = text.replace(/<\/*.*?>/gi, '');
      text = text.replace(/&nbsp;/gi, ' ');
      text = text.replace(/amp;/gi,'');

      return text;
    }

//Get domain url

    window.getLocation = function(href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };
    // var l = getLocation("http://example.com/path");
    // console.debug(l.hostname)
    // >> "example.com"
    // console.debug(l.pathname)
    // >> "/path"
//End funtion get domain url




//GET first string to space
window.get_first_string = function(str){
    //Only get first class of parent node
                      
                      var regex = /^[^\s]+/;
                      var result = str.match(regex);
                      return result;

}


    //FIlter and GET Titile and Node by JS
    window.scrape_get_dom_js = function(response,title_tagName,title_className,content_tagName,content_className,parent_tagName,parent_className){
        // console.log(response);
        // console.log(title_tagName);
        // console.log(title_className);
        // console.log(content_tagName);
        // console.log(content_className);
        // console.log(parent_tagName);
        // console.log(parent_className);

                                                var xmlString = response
                                                , parser = new DOMParser()
                                                , doc = parser.parseFromString(xmlString, "text/html");

                                                    var title = false;                        
                                                    var contentDOM = false;                                                    
                                                    var nodes = doc.body.querySelectorAll('*'); 


                                                    for(var i = 0;i < nodes.length;i++){
                                                        if((nodes[i].nodeName == 'SCRIPT') || (nodes[i].nodeName == 'svg') || (nodes[i].nodeName == 'STYLE')){
                                                            continue;
                                                        }
                                                          tag_name = nodes[i].nodeName.toLowerCase();

                                                          if(nodes[i].hasAttribute('class')){
                                                            if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){
                                                                class_name = nodes[i].className;                                                          

                                                               if ((tag_name == title_tagName) && (class_name == title_className)) {                           
                                                                title = nodes[i];
                                                                  break;
                                                                }
                                                            }  
                                                          }else{
                                                            temp = nodes[i];
                                                            while(true){
                                                              if(temp.hasAttribute('class') && (temp.className != "")){
                                                               class_name = temp.className;
                                                                break; 
                                                              }else{
                                                                temp = temp.parentNode;
                                                              }
                                                            }

                                                            if ((tag_name == title_tagName) && (class_name == title_className)) {                           
                                                                title = nodes[i];
                                                                  break;
                                                                }
                                                          }
                                                            
                                                    }


                                                    // console.log(title);
                                                    // alert('aa')

                                                    // if(title == false){
                                                    //     title = "No Title Found";
                                                    // }
                                                    //  console.log(title);
                                                    if(title == false){
                                                            for(var i = 0;i < nodes.length;i++){
                                                            if((nodes[i].nodeName == 'SCRIPT') || (nodes[i].nodeName == 'svg') || (nodes[i].nodeName == 'STYLE')){
                                                                continue;
                                                            }
                                                            tag_name = nodes[i].nodeName.toLowerCase();
                                                            if(tag_name == title_tagName) {                           
                                                                title = nodes[i];
                                                                  break;
                                                                }
                                                        }
                                                     }

                                                     console.log(title)

                                                    console.log(parent_tagName);
                                                    console.log(parent_className);

                                                    for(var i = 0;i < nodes.length;i++){
                                                        if((nodes[i].nodeName == 'SCRIPT') || (nodes[i].nodeName == 'svg') || (nodes[i].nodeName == 'STYLE') || (nodes[i].nodeName == 'SECTION') || (nodes[i] instanceof SVGElement)){
                                                            continue;
                                                        }

                                                        tag_name = nodes[i].nodeName.toLowerCase();


                                                        if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){

                                                            
                                                             class_name = nodes[i].className.toLowerCase();
                                                            
                                                            
                                                             
                                                           if ((tag_name == content_tagName) && (class_name == content_className)) { 
                                                               

                                                                 parent_tag_name = nodes[i].parentElement.nodeName.toLowerCase();
                                                                 parent_class_name  = nodes[i].parentElement.className.toLowerCase();
                                                                console.log(parent_tag_name)
                                                                console.log(parent_class_name);
                                                                    if(parent_class_name != ''){ 
                                                                        console.log(0)
                                                                        if((parent_tag_name == parent_tagName) && (parent_class_name == parent_className)){
                                                                            console.log(1)
                                                                            contentDOM = nodes[i];
                                                                                  console.log(contentDOM);
                                                                                break;
                                                                                }      
                                                                        }else{
                                                                           console.log(2)
                                                                            var parent_node;
                                                                            nodeTemp = nodes[i].parentNode; 
                                                                            while(true){

                                                                                if(nodeTemp.hasAttribute('class') && (nodeTemp.className != "")){
                                                                                         parent_node = nodeTemp;
                                                                                          console.log(parent_node);
                                                                                         break;
                                                                                        }
                                                                                        
                                                                                        nodeTemp = nodeTemp.parentNode;
                                                                                         
                                                                                        
                                                                             }
                                                                             parent_tag_name = parent_node.nodeName.toLowerCase();
                                                                             parent_class_name  = parent_node.className.toLowerCase();
                                                                             console.log(parent_tag_name);
                                                                             console.log(parent_tagName);
                                                                             console.log(parent_class_name);
                                                                             console.log(parent_className);
                                                                             
                                                                             if(parent_tag_name == 'body'){
                                                                                 contentDOM = nodes[i];
                                                                                  console.log(contentDOM);
                                                                                break;s
                                                                             }
                                                                            if((parent_tag_name == parent_tagName) && (parent_class_name == parent_className)){
                                                                                 contentDOM = nodes[i];
                                                                                  console.log(contentDOM);
                                                                                break;
                                                                            }
                                                                        }

                                                                }//End compare to get Node
                                                                


                                                                

                                                            }

                                                    }//End for


                                                    //return false;




                                                    // console.log(contentDOM);

                                                    // for(var i = (nodes.length-1);i >= 0;i--){
                                                        
                                                    //     tag_name = nodes[i].nodeName.toLowerCase();
                                                    //     if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){
                                                    //       class_name = nodes[i].className.toLowerCase(); 

                                                    //        if ((tag_name == title_tagName) && (class_name == title_className)) {                           
                                                    //         title = nodes[i];
                                                    //           break;
                                                    //         }
                                                    //     }
                                                    //     if (tag_name == title_tagName) {                           
                                                    //         title = nodes[i];
                                                    //           break;
                                                    //         }
                                                           
                                                    // }

                                                    // for(var i = (nodes.length-1);i >= 0;i--){
                                                    //     tag_name = nodes[i].nodeName.toLowerCase();


                                                    //     if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){
                                                    //         class_name = nodes[i].className.toLowerCase();  
                                                    //        if ((tag_name == content_tagName) && (class_name == content_className)) {                           
                                                    //         contentDOM = nodes[i];
                                                    //         break;
                                                    //       } 
                                                    //     }

                                                    // }

                                                    return {title:title,contentDOM: contentDOM};

                                            } //End scrape_get_dom_js
    
    
    









});
















 