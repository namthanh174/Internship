jQuery(document).ready(function ($) {

//------------------------------------------------------------------------------------------------------------------------//
//Funtions
//-----------------------------------------------------------------------------------------------------------------------//

    window.get_urls;
    get_urls = function get_urls(data) {

        var urls = [];

        $('h2, h1, h3, h4', data).each(function () {
            var href = $(this).find('a').attr('href');
            if (href) {
                urls.push(href);
            }

           
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
   
//End funtion get domain url




//GET first string to space
window.get_first_string = function(str){
    //Only get first class of parent node
                      
                      var regex = /^[^\s]+/;
                      var result = str.match(regex);
                      return result;

}

window.skip_node = function(node){
  if((node.nodeName == 'SCRIPT') || (node.nodeName == 'svg') || (node.nodeName == 'STYLE') || (node.nodeName == "SECTION") || (node instanceof SVGElement)){
    return true;                                                        
     }

     return false;
}


    //FIlter and GET Titile and Node by JS
    window.scrape_get_dom_js = function(response,title_tagName,title_className,content_tagName,content_className,parent_tagName,parent_className){
        

                                                var xmlString = response
                                                , parser = new DOMParser()
                                                , doc = parser.parseFromString(xmlString, "text/html");

                                                    var title = false;                        
                                                    var contentDOM = false;                                                    
                                                    var nodes = doc.body.querySelectorAll('*'); 


                                                    for(var i = 0;i < nodes.length;i++){
                                                       
                                                          tag_name = nodes[i].nodeName.toLowerCase();

                                                         
                                                         if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){
                                                                class_name = nodes[i].className;                                                          

                                                               if ((tag_name == title_tagName) && (class_name == title_className)){                           
                                                                  title = nodes[i];
                                                                  break;
                                                                }
                                                              
                                                          }
                                                          // else{
                                                          //   temp = nodes[i];
                                                          //   while(true){                                                             
                                                          //      console.log(temp);
                                                          //       if(temp.hasAttribute('class') && (temp.className != "")){
                                                          //      class_name = temp.className;
                                                          //       break; 
                                                                                                                             
                                                          //     }else{
                                                          //       temp = temp.parentNode;
                                                          //     }
                                                          //   }

                                                          //   if ((tag_name == title_tagName) && (class_name == title_className)) {                           
                                                          //       title = nodes[i];
                                                          //         break;
                                                          //       }
                                                          // }
                                                            
                                                    }


                                                    
                                                    if(title == false){
                                                            for(var i = 0;i < nodes.length;i++){
                                                             
                                                            tag_name = nodes[i].nodeName.toLowerCase();
                                                            if(tag_name == title_tagName) {                           
                                                                title = nodes[i];
                                                                  break;
                                                                }
                                                        }
                                                     }

                                                    //  console.log(title)

                                                    // console.log(parent_tagName);
                                                    // console.log(parent_className);

                                                    for(var i = 0;i < nodes.length;i++){
                                                         if(skip_node(nodes[i])){
                                                          // console.log(nodes[i]);
                                                            continue;
                                                         }

                                                        tag_name = nodes[i].nodeName.toLowerCase();
                                                        //console.log(tag_name)

                                                        if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){

                                                            
                                                             class_name = nodes[i].className.toLowerCase();
                                                            
                                                            
                                                             
                                                           if ((tag_name == content_tagName) && (class_name == content_className)) { 
                                                               parent_tag_name = false;
                                                                 parent_class_name  = false;
                                                               temp = nodes[i].parentElement;
                                                                while(true){
                                                                  if(skip_node(temp)){
                                                                    temp = temp.parentElement;
                                                                    continue;
                                                                  }

                                                                parent_tag_name = temp.nodeName.toLowerCase();
                                                                 parent_class_name  = temp.className.toLowerCase();
                                                                 break;
                                                                }
                                                                 
                                                                // console.log(parent_tag_name)
                                                                // console.log(parent_class_name);
                                                                    if(parent_class_name != ''){ 
                                                                        // console.log(0)
                                                                        if((parent_tag_name == parent_tagName) && (parent_class_name == parent_className)){
                                                                            // console.log(1)
                                                                            contentDOM = nodes[i];
                                                                                  // console.log(contentDOM);
                                                                                break;
                                                                                }      
                                                                        }else{
                                                                           // console.log(2)
                                                                            var parent_node;
                                                                            nodeTemp = nodes[i].parentNode; 
                                                                            while(true){
                                                                                 if(skip_node(nodes[i])){
                                                                                  nodeTemp = nodeTemp.parentNode;
                                                                                    continue;
                                                                                 }
                                                                                if(nodeTemp.hasAttribute('class') && (nodeTemp.className != "")){
                                                                                         parent_node = nodeTemp;
                                                                                          // console.log(parent_node);
                                                                                         break;
                                                                                        }
                                                                                        
                                                                                        nodeTemp = nodeTemp.parentNode;
                                                                                         
                                                                                        
                                                                             }
                                                                             parent_tag_name = parent_node.nodeName.toLowerCase();
                                                                             parent_class_name  = parent_node.className.toLowerCase();
                                                                             // console.log(parent_tag_name);
                                                                             // console.log(parent_tagName);
                                                                             // console.log(parent_class_name);
                                                                             // console.log(parent_className);
                                                                             
                                                                             if(parent_tag_name == 'body'){
                                                                                 contentDOM = nodes[i];
                                                                                  // console.log(contentDOM);
                                                                                break;s
                                                                             }
                                                                            if((parent_tag_name == parent_tagName) && (parent_class_name == parent_className)){
                                                                                 contentDOM = nodes[i];
                                                                                  // console.log(contentDOM);
                                                                                break;
                                                                            }
                                                                        }

                                                                }//End compare to get Node
                                                                


                                                                

                                                            }

                                                    }//End for

                                                    


                                                  // console.log(contentDOM);

                                                    return {title:title,contentDOM: contentDOM};

                                            } //End scrape_get_dom_js
    






    window.get_category_dom = function(response,category_tag,category_class){
                                  var xmlString = response
                                  , parser = new DOMParser()
                                  , doc = parser.parseFromString(xmlString, "text/html");

                                                      
                                      var contentDOM = false;                                                    
                                      var nodes = doc.body.querySelectorAll('*');

                                       for(var i = 0;i < nodes.length;i++){
                                                    if(skip_node(nodes[i])){
                                                          // console.log(nodes[i]);
                                                            continue;
                                                         }

                                                        tag_name = nodes[i].nodeName.toLowerCase();
                                                        //console.log(tag_name)

                                                        if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){                                                            
                                                             class_name = nodes[i].className.toLowerCase();
                                                              if ((tag_name == category_tag) && (class_name == category_class)){
                                                                contentDOM = nodes[i];
                                                                break;
                                                              }
                                                             

                                                      }                                       
                                       } 

                                       if(contentDOM == false){
                                        return response;
                                       }



          return contentDOM;

    }
    
    









});
















 