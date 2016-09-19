jQuery(document).ready(function ($) {

    $('#scrape-form').submit(function () {

        $('#wait').show();
       
        window.globalVar = 0;

        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url').val();
        // var type = $('#type').val();



        data = {action: 'scrape_process_ajax',
            url: url,
            type: selected
        };


        $.post(ajaxurl, data, function (response) {
            //            if (response.hasOwnProperty('error')) {
            //                $('#wait').hide();
            //                $('.load').html('<b>Invalid URL 1</b>');
            //            } else if (response == false)
            //            {
            //                $('#wait').hide();
            //                $('.load').html('<b>Invalid URL 2</b>');
            //            } else {
            //                $('#wait').hide();
            //                $('.load').html(response);
            //            }





        });

        $.get(ajaxurl, data, function (response) {

            var urls = get_urls(response);
            var content = get_contains(response);
//            alert(urls);
//            var data2 = {action: 'scrape_process_content',
//                url: urls,
//                content: content,
//                type: selected
//
//            };
        
            
            $.each(urls,function(key,url){
                $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {action: 'scrape_process_content',
                    url: url,
                    content: content,
                    type: selected
                },
                success: function (response) {
                    globalVar++;
                    // uhm, maybe I don't even need this?
                    //var json = $.parseJSON(response);


                    //console.log(response.data);
//                    var content = [];
//                    $.each(response.data, function (key, value) {
//                        content.push(value);
//                    })
                   
                    

                    // return response;
                },
                fail: function (jqXHR, textStatus, errorThrown) {
                    console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                }
                });
            });

            
            //$('.load').html(content);

//            $('#wait').hide();
//            alert("completed");




                
//            $.post(ajaxurl, data2, function (response) {
//
//                $('#wait').hide();
//                $('.load').html(response);
//            });


        });

        return false;


    }).ajaxStop(function() {
          // place code to be executed on completion of last outstanding ajax call here
           $('#wait').hide();
           $('.load').html(globalVar + " posts has been posted");
          
        });




    function get_urls(data) {

        var urls = [];

        $('h2', data).each(function () {
            var href = $(this).find('a').attr('href');
            if(href){
                urls.push(href);
            }
       
            
            //res.push($(this).attr('href')+"---");
        });

        return urls;
    }

    function get_contains(data) {
        var title = '';
        var content = [];
        var img = [];
        $('p', data).each(function () {
            content.push($(this).html());
            //res.push($(this).attr('href')+"---");
        });
        $('p', data).each(function () {
            img.push($(this).find('img').attr('href'));
            //res.push($(this).attr('href')+"---");
        });

        //var data = {"img":img,"content":content};
        //data = JSON.stringify(data);

        return content;
    }



});




 