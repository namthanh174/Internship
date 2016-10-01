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

                        var title=[];
                        var first_content = [];
                        var last_content = [];
                       
                        // var nodes = doc.body.getElementsByTagName('*');
                        
                        
                        

                        
                        // for(i=0;i<nodes.length;i++){
                        //   console.log(nodes[i]);
                        // }
                        var array = []
                        var allEls = [].slice.call(doc.body.querySelectorAll('*'));
                        num  =0;
                        allEls.forEach( function (el) {
                              //do things with the element, e.g.
                              // console.log(el.type)
                              // console.log(el.id)

                          if(el.children.length === 0 && el.textContent.replace(/ |\n/g,'') !== '') {
                                 // Check the element has no children && that it is not empty
                                 array.push(el);
                                 console.log(num+" : "+el.outerHTML)
                              }
                              
                              num++
                        });

                       



                         // var array = [];

                         
                         // //element = nodes.childNodes;
                         // console.log(nodes.length);
                         //  for(var i = 0; i < nodes.length; i++) {
                         //     var current = nodes[i];
                         //      if(current.children.length === 0 && current.textContent.replace(/ |\n/g,'') !== '') {
                         //         // Check the element has no children && that it is not empty
                         //         array.push(current);
                         //      }
                              
                         //  } 

                         //  num= 1;
                         //  for(var i = 0; i< array.length;i++){
                         //      console.log(num+" : "+array[i].outerHTML)
                         //                                  num++;
                         //  }

                          

                          
                          


                        
                      var patt_title = new RegExp(define_title);
                      
                      var patt_first =  new RegExp(define_first_content);
                     

                      var patt_last =  new RegExp(define_last_content);
                      
                     // var str = '';
                     //console.log(nodes[1].innerText);
                     // console.log(nodes[1].innerText.search(define_title));
                     // for(var i =0;i<nodes.length;i++){
                     //  console.log(nodes[i])
                     //  if(i == 30)
                     //    break;
                     // }

                      for(var i = 0; i < nodes.length; i++){
                        //console.log(nodes[i].firstChild)
                        if(nodes[i].firstChild.nodeValue){
                          var match_title = patt_title.exec(nodes[i].firstChild.innerText);
                          if(match_title == define_title){

                         // console.log("title"+match_title)
                              title = nodes[i].firstChild;
                             console.log(title);
                             break;

                            }
                        }
                          

                      }

                      for(var i = 0; i < nodes.length; i++){
                        if(nodes[i].firstChild != ""){
                           var match_first = patt_first.exec(nodes[i].firstChild.innerText);
                        
                            
                            if(match_first == define_first_content){
                               //console.log(nodes[i])
                              
                               var number = 1;
                                  num = 0;
                                  while(number >= 1){     
                                  if(nodes[i-num].firstChild.hasAttribute('id')){
                                    first_content = nodes[i-num];

                                    break;
                                  }                         
                                  if(nodes[i-num].firstChild.hasAttribute("class") && (nodes[i-num].firstChild.className != "")){
                                      first_content = nodes[i-num].firstChild;
                                      number = 0;
                                      console.log(first_content);
                                      break;
                                        }else{
                                            num++;

                                        }
                                    }
                                      // console.log("match First " + match_first + "define first content" + define_first_content);
                                      
                              }
                              //console.log('First Content : '+first_content);
                              if(first_content != '')
                                break;
                        }

                        
                      }

                    for(var i = 0; i < nodes.length; i++){
                      if(nodes[i].firstChild != ""){



                      // console.log(i);
                      //console.log(nodes[i]);
                      
                      //console.log(match_title);
                     
                      var match_last = patt_last.exec(nodes[i].firstChild.innerText);
                      //var str = nodes[i].innerText;

                     


                      // console.log(str.search(define_title));
                      // console.log(str.search(define_first_content));
                      // console.log(str.search(define_last_content));
                      // console.log(nodes[i]);
                      


                       
                      if(match_last == define_last_content){
                          //console.log(nodes[i]);
                        var number = 1;
                            num = 0;
                            while(number >= 1){
                            if(nodes[i+num].firstChild.hasAttribute("class") && (nodes[i+num].firstChild.className != "")){
                                last_content = nodes[i+num].firstChild;
                                number = 0;
                                console.log(last_content);
                                break;
                                
                                  }else{
                                      num++;

                                  }
                                }
                                // console.log("match Last " + match_last);
                                //  console.log('Last Content : '+last_content);


                               
                        }
                      }


                      if(last_content != '')
                        break;


                    }
                      

                      
                       
                    

                        


            //             if(nodes[i].innerText == define_title){
                            
            //                 title = nodes[i];
            //             }
            //             if(nodes[i].innerText == define_first_content){
                            
            //                 var number = 1;
            //                 num = 0;
            //                 while(number >= 1){                              
            //                 if(nodes[i-num].hasAttribute('class') && (nodes[i-num].className != "")){
            //                     first_content = nodes[i-num];
            //                     number = 0;
            //                     console.log(number);
                                
            //                 }else{
            //                     num++;

            //                 }
            //             }
                        
                            
            //             }
            //             if(nodes[i].innerText == define_last_content){
            //                var number = 1;
            //                 num = 0;
            //                 while(number >= 1){
            //                 if(nodes[i+num].hasAttribute('class') && (nodes[i+num].className != "")){
            //                     last_content = nodes[i+num];
            //                     number = 0;
                                
                                
            //                       }else{
            //                           num++;

            //                       }
            //                     }

            //             }





            // }
                
//                if(title.hasAttribute('id')){
//                     console.log(title.id);
//                }      
                // console.log(title.nodeName);
                // if(title.hasAttribute('class')){
                //      console.log(title.className);
                // }
                
                
                // console.log(first_content.nodeName);
                // if(first_content.hasAttribute('class')){
                //      console.log(first_content.className);
                // }
                
                
                // console.log(last_content.nodeName);
                // if(last_content.hasAttribute('class')){
                //      console.log(last_content.className);
                // }
               
               

               define_title = title.nodeName+"."+title.className;
               define_first_content = first_content.nodeName+"."+first_content.className;
               define_last_content = last_content.nodeName+"."+last_content.className;
               alert(define_url);
                 $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'insert_scrape_pattern_table',
                            define_url: define_url,
                            define_title: define_title,
                            define_first_content: define_first_content,
                            define_last_content: define_last_content
                        },
                        success: function (response) {

                            alert(response);
                        },
                        error: function (error) {
                            alert(error);
                        }


                    });       
                   
                }
            });
            
            




            return false;
        });
    }

//------------------------------------------------------------------------------------------------------------------------//
//End Define pattern form
//------------------------------------------------------------------------------------------------------------------------//



//get_pattern();
//function get_pattern(){
//    
//    window.url_content = '';
//    //Get title from page to set pattern
//    $('#choose_title').click(function(e){
//         $('.title_popup').empty();
//         $('.first_content_popup').empty();
//         $('.last_content_popup').empty();
//         var title,pattern_title;
//          //alert(url_content)
//           
//                 var url = $('#define_url').val();
//                var data = {
//                    action: 'scrape_content_pattern_ajax',
//                    url: url
//                }
//                $.get(ajaxurl, data, function (response) {
//                    var content = response;
//                    url_content = content;
//                     var last, bgc;
//                
//                var myscript = $('.mousehover').mouseover(function (e) {
//                var elem = e.target;
//                if (last != elem) {
//                    if (last != null) {
//                        last.classList.remove("hovered");
//                    }
//
//                    last = elem;
//                    elem.classList.add("hovered");
//                }
//
//            }).click(function (e) {
//                 e.target.classList.remove('hovered');
//                 title = e.target.outerText;
//                 pattern_title = e.target.offsetParent.nodeName+'.'+e.target.offsetParent.className;
//                 $('#define_title').val(title);
//                 
//            });
//             $('#iframe').contents().find('body').append('<script>'+myscript+'</script>');   
//              
//            });
//            
//            
//            //e.preventDefault();
//            
//           
//    });
//    }












//get_pattern_demo_2();
//function get_pattern_demo_2(){
//    
//    window.url_content = '';
//    //Get title from page to set pattern
//    $('#choose_title').click(function(e){
//         $('.title_popup').empty();
//         $('.first_content_popup').empty();
//         $('.last_content_popup').empty();
//         var title,pattern_title;
//          //alert(url_content)
//            if(url_content == ''){
//                 var url = $('#define_url').val();
//            var data = {
//                action: 'scrape_content_pattern_ajax',
//                url: url
//            }
//                $.post(ajaxurl, data, function (response) {
//                    var data = response; 
//                    url_content = response;
//                $('.title_popup').append(data);
//                
//              
//            });
//            }else{
//                $('.title_popup').append(url_content);
//            }
//            
//            //e.preventDefault();
//            var myclass = '';
//            var last, bgc;
//            $('.title_popup').mouseover(function (e) {
//                var elem = e.target;
//                if (last != elem) {
//                    if (last != null) {
//                        last.classList.remove("hovered");
//                    }
//
//                    last = elem;
//                    elem.classList.add("hovered");
//                }
//
//                myclass = elem.className;
//
//
//            }).click(function (e) {
//                 e.target.classList.remove('hovered');
//                 title = e.target.outerText;
//                 pattern_title = e.target.offsetParent.nodeName+'.'+e.target.offsetParent.className;
//                 $('#define_title').val(title);
//                 
//            });
//           
//    });
//    
//    //Get first content from page to set pattern
//     $('#choose_first_content').click(function(e){
//          $('.title_popup').empty();
//         $('.first_content_popup').empty();
//         $('.last_content_popup').empty();
//           var first_content,pattern_first_content;
//         
//            
//            if(url_content == ''){
//                 var url = $('#define_url').val();
//            var data = {
//                action: 'scrape_content_pattern_ajax',
//                url: url
//            }
//                $.post(ajaxurl, data, function (response) {
//                    url_content = response;
//                $('.first_content_popup').html(response);
//                
//            });
//            }else{
//                $('.first_content_popup').append(url_content);
//            }
//            
//            
//            //e.preventDefault();
//            var myclass = '';
//            var last1, bgc1;
//            $('.first_content_popup').mouseover(function (e) {
//                var elem1 = e.target;
//                if (last1 != elem1) {
//                    if (last1 != null) {
//                        last1.classList.remove("hovered");
//                    }
//
//                    last1 = elem1;
//                    elem1.classList.add("hovered");
//                }
//
//                myclass = elem1.className;
//
//
//            }).click(function (e) {                  
//                e.target.classList.remove('hovered');
//                 first_content = e.target.outerText;
//                 pattern_first_content = e.target.offsetParent.nodeName+'.'+e.target.offsetParent.className;
//                 $('#define_first_content').val(first_content);
//               
//            });
//            
//    });
//    
//    
//    //Get last content from page to set pattern
//     $('#choose_last_content').click(function(e){
//         $('.title_popup').empty();
//         $('.first_content_popup').empty();
//         $('.last_content_popup').empty();
//          var last_content,pattern_last_content;
//            
//            if(url_content == ''){
//                 var url = $('#define_url').val();
//                var data = {
//                    action: 'scrape_content_pattern_ajax',
//                    url: url
//                }
//                $.post(ajaxurl, data, function (response) {
//                    url_content = response;
//               $('.last_content_popup').append(response);
//                
//            });
//            }else{
//                $('.last_content_popup').html(url_content);
//            }
//            
//            
//            //e.preventDefault();
//            var myclass = '';
//            var last2, bgc2;
//            $('.last_content_popup').mouseover(function (e) {
//                var elem2 = e.target;
//                if (last2 != elem2) {
//                    if (last2 != null) {
//                        last2.classList.remove("hovered");
//                    }
//
//                    last2 = elem2;
//                    elem2.classList.add("hovered");
//                }
//
//                myclass = elem2.className;
//
//
//            }).click(function (e) {               
//                e.target.classList.remove('hovered');
//                 last_content = e.target.outerText;
//                 pattern_last_content = e.target.offsetParent.nodeName+'.'+e.target.offsetParent.className;
//                 $('#define_last_content').val(last_content);
//                 
//            });
//            
//    });
//     
//}











//        function get_pattern_demo(e,id){
//
//                    var content,pattern;
//             //var url = $('#define_url').val();
//                    var url = "http://www.marrybaby.vn/tin-tuc/su-phuc-hoi-ki-dieu-cua-cau-be-viem-da-co-dia-nho-nuoc-khoang-avene-thien-nhien";
//
//                    var data = {
//                        action: 'scrape_process_multi_ajax',
//                        url: url
//                    }
//                    $.get(ajaxurl, data, function (response) {
//                        $('.popup_content').append(response);
//                    });
//                    e.preventDefault();
//        //            $("iframe").attr("src", url);
//        //            $(".links").fadeOut('slow');
//        //            $(".popup").fadeIn('slow');
//
//                    var myclass = '';
//                    var last, bgc;
//                    $('.popup_content').mouseover(function (e) {
//                        var elem = e.target;
//                        if (last != elem) {
//                            if (last != null) {
//                                last.classList.remove("hovered");
//                            }
//
//                            last = elem;
//                            elem.classList.add("hovered");
//                        }
//
//                        myclass = elem.className;
//
//
//                    }).click(function (e) {
//        //                $('#define_title').val(e.target.offsetParent.nodeName+'.'+e.target.offsetParent.className);
//        //                alert($('#define_title').val());
//                        console.log(e);
//        //                   alert(e.target.outerText);                    
//                        e.target.classList.remove('hovered');
//        //                    $('#demoResult').html(e.target.outerHTML);
//                        //alert(e.target.parentNode.className);
//        //                    e.target.classList.remove('hovered');
//        //                    console.log(e.target.className)
//        //                   alert(e.target.parentElement.outerHTML);
//                           //$('#demoResult').html(e.target.parentElement.outerHTML);
//
//                         content = e.target.outerHTML;
//                         contentText = e.target.outerText;
//                         pattern = e.target.offsetParent.nodeName+'.'+e.target.offsetParent.className;
//                         $(id).val(contentText);
//                         //return content;
//                    });
//
//                    //return [content,pattern];
//
//
//        }








});



function get_element(){
     //alert(response)
                   alert('aa3')
                  //$('#demoResult').html(response);
                  alert('aa3')
                  var myelement = '';
                  alert('aa2')
                    var all = document.getElementsByTagName("*");
                        alert('aa1')
                        for (var i=0, max=all.length; i < max; i++) {
                             // Do something with the element here
                             if(all[i].innerText == "Exploits patched by Apple today hint at years of surreptitious government hacks"){
                                 myelement.push(all[i]);
                             }
                        }

                        alert(myelement.nodeName)
                        alert('aa')
}