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












});
















 