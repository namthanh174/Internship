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


    //FIlter and GET Titile and Node by JS
    window.scrape_get_dom_js = function(response,title_tagName,title_className,content_tagName,content_className){

                                                var xmlString = response
                                                , parser = new DOMParser()
                                                , doc = parser.parseFromString(xmlString, "text/html");

                                                    var title = false;                        
                                                    var contentDOM = false;                                                    
                                                    var nodes = doc.body.querySelectorAll('*');    
                                                    for(var i = (nodes.length-1);i >= 0;i--){
                                                        
                                                        tag_name = nodes[i].nodeName.toLowerCase();
                                                        if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){
                                                          class_name = nodes[i].className.toLowerCase(); 

                                                           if ((tag_name == title_tagName) && (class_name == title_className)) {                           
                                                            title = nodes[i];
                                                              break;
                                                            }
                                                        }
                                                        if (tag_name == title_tagName) {                           
                                                            title = nodes[i];
                                                              break;
                                                            }
                                                           
                                                    }

                                                    for(var i = (nodes.length-1);i >= 0;i--){
                                                        tag_name = nodes[i].nodeName.toLowerCase();


                                                        if(nodes[i].hasAttribute('class') && (nodes[i].className != '')){
                                                            class_name = nodes[i].className.toLowerCase();  
                                                           if ((tag_name == content_tagName) && (class_name == content_className)) {                           
                                                            contentDOM = nodes[i];
                                                            break;
                                                          } 
                                                        }

                                                    }

                                                    return {title:title,contentDOM: contentDOM};

                                            }
    
    
    









});
















 