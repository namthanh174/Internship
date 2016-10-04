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
                    
                            break;
                          }

                        }
                        



                        
                        // var img = get_img(contentDOM.outerHTML);
                        // // console.log(img);
                        // // console.log(title)
                        // $.ajax({
                        //   type:'POST',
                        //   url: ajaxurl,
                        //   dataType: 'json',
                        //   data:{
                        //       action: 'scrape_content_pattern_ajax_demo',
                        //       content: contentDOM.outerHTML,
                        //       title : title.innerText,
                        //       define_url : define_url,
                        //       img : img
                        //   },
                        //   success:function(data){
                        //     alert("Post success!")
                        //     console.log(data.img);
                           
                        //   }
                        // });










                        

                        
                      //   // for(i=0;i<nodes.length;i++){
                      //   //   console.log(nodes[i]);
                      //   // }
                      //   var nodes = []
                      //   var allElements = [].slice.call(doc.body.querySelectorAll('*'));
                      //   num  =0;
                      //   allElements.forEach( function (el) {
                      //         //do things with the element, e.g.
                      //         // console.log(el.type)
                      //         // console.log(el.id)
                      //         if(el.nodeName === "SCRIPT"){
                      //           return;
                      //         }

                      //     //if(el.children.length === 0 && el.textContent.replace(/ |\n/g,'') !== '') {
                      //            // Check the element has no children && that it is not empty
                      //            nodes.push(el);
                      //            //console.log(num+" : "+el.outerHTML)
                      //       //}
                              
                      //         num++
                      //   });


                       
                      //  for(var i=0;i<nodes.length;i++){
                      //    //console.log(i+" : " + "NodeName : " + nodes[i].nodeName + " Value: " +nodes[i].outerHTML );


                      //  }



                      // patt_title = new RegExp(define_title);
                      // patt_first_content = new RegExp(define_first_content);
                      // patt_last_content = new RegExp(define_last_content);
                      // //var regex = /(<([^>]+)>)/ig;
                      // for(var i=nodes.length-1;i >= 0;i--){
                      //   var nodeText = nodes[i].innerText;
                      //   nodeText = nodeText.replace(/(<([^>]+)>)/ig, ' ');
                      //   nodeText = nodeText.replace(/&nbsp;/g, ' ');
                      //   // nodeText = jQuery(nodes[i]).text();

                      //   if(patt_title.test(nodeText)){
                         
                      //    title = nodes[i].parentElement;

                      //   }
                        


                      //   // if(patt_last_content.test(nodeText)){
                      //   //   console.log(i+" : " + nodes[i].parentNode.innerHTML);
                      //   //  var number = 1;
                      //   //          num = 0;
                      //   //   // while(number >= 1){ 

                      //   //   //           if(nodes[i].parentElement.hasAttribute('class') && nodes[i].parentElement.className != ""){
                      //   //   //             first_content = nodes[i].parentElement;
                      //   //   //             number = 0;
                      //   //   //             console.log(first_content);
                      //   //   //             break;
                                    
                      //   //   //         }else{
                      //   //   //             num++;

                      //   //   //         }
                      //   //   //       }
                      //   // }
                      //   if(patt_last_content.test(nodeText)){
                      //     last_content = nodes[i].parentElement;
                      //     //console.log(nodes[i]);
                      //     // var number = 1;
                      //     //        num = 0;
                      //     // while(number >= 1){                                                             
                      //     //           if(nodes[i].parentElement.hasAttribute('class') && nodes[i].parentElement.className != ""){
                      //     //             last_content = nodes[i].parentElement;
                      //     //             number = 0;
                      //     //             console.log(last_content);
                      //     //             break;
                                    
                      //     //         }else{
                      //     //             num++;

                      //     //         }
                      //     //       }
                      //   }










                      // }
                          

                          
                          


                        
                    //   var patt_title = new RegExp(define_title);
                      
                    //    var patt_first =  new RegExp(define_first_content);
                    //   //alert(patt_first)

                    //   var patt_last =  new RegExp(define_last_content);

                    //   // var regex = /(<([^>]+)>)/ig;
          
                    //   alert(patt_first)
                     

                    //   for(var i=0;i<nodes.length;i++){
                        
                    //     var textNode = nodes[i].innerHTML;
                    //     textNode = textNode.replace(/<.*?>/g, ' ');
                    //     textNode = textNode.replace(/&nbsp;/g, ' ');

                    //     // textNode = jQuery(nodes[i]).text();
                    //     //console.log(i + " : " +textNode);
                    //     // var match_title = patt_title.exec(textNode);
                    //     // var match_first = patt_first.exec(textNode);

                    //     //  var match_last = patt_last.exec(textNode);
                          
                          
                    // // if(nodes[i].children.length === 0 && nodes[i].textContent.replace(/ |\n/g,'') !== '') {
                    //      //console.log(i +" : "+nodes[i].innerText + " className : " + nodes[i].className);

                    //  if(patt_title.test(textNode)){
                    //           title = nodes[i];
                    //           //console.log(title)
                    //          }
                         
                         
                        
                        
                    //     if(patt_first.test(textNode)){
                          
                    //         lert(match_first);
                    //         var number = 1;
                    //               num = 0;
                    //               while(number >= 1){                                                             
                    //               if(nodes[i-num].hasAttribute("class") && (nodes[i-num].className != "")){
                    //                   first_content = nodes[i-num];
                    //                   number = 0;
                    //                   console.log(first_content);
                    //                   break;
                    //                     }else{
                    //                         num++;

                    //                     }
                    //                 }
                    //       }
                             
                                   
                         
                         
                         
                        
                    //       if(patt_last.test(textNode)){
                    //        var number = 1;
                    //         num = 0;
                    //         while(number >= 1){
                    //         if(nodes[i+num].hasAttribute("class") && (nodes[i+num].className != "")){
                    //             last_content = nodes[i+num];
                    //             number = 0;
                    //             console.log(last_content);
                    //             break;
                                
                    //               }else{
                    //                   num++;

                    //               }
                    //             }
                            
                                

                    //      }




                         // if(patt_last.test(textNode)){
                         //  console.log(nodes[i].parentElement)
                         //   var number = 1;
                         //    num = 0;
                         //    while(number >= 1){
                         //    if(nodes[i+num].hasAttribute("class") && (nodes[i+num].className != "")){
                         //        last_content = nodes[i+num];
                         //        number = 0;
                         //        //console.log(last_content);
                         //        break;
                                
                         //          }else{
                         //              num++;

                         //          }
                         //        }
                            
                                

                         // }
                         

                        // }  

                         

                      // }



                      





                      

                     
               
               

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






















});






