jQuery(document).ready(function ($) {

    $('#scrape-one-form').submit(function () {
        $('#wait').show();
        $('.load').hide();



        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url').val().trim();

        data = {action: 'scrape_process_one_ajax',
            url: url,
            type: selected
        };


        $.post(ajaxurl, data, function (response) {
            $('.load').show().html(response);
        });


        return false;


    }).ajaxStop(function () {

        $('#wait').hide();
        //$('.load').show().html("1 post has been posted");

    });




    $('#scrape-multi-form').submit(function () {

        $('#wait').show();
        $('.load').hide();

        window.globalVar = 0;

        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url').val().trim();




        data = {action: 'scrape_process_multi_ajax',
            url: url,
            type: selected
        };

        $.post(ajaxurl, data, function (response) {

            var urls = get_urls(response);
            var content = get_contains(response);

            $.each(urls, function (key, url) {
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

                    },
                    fail: function (jqXHR, textStatus, errorThrown) {
                        console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                    }
                });
            });

        });

        return false;


    }).ajaxStop(function () {
        $('#wait').hide();
        $('.load').show().html(globalVar + " posts has been posted");

    });






    function get_urls(data) {

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

    function get_contains(data) {
        var title = '';
        var content = [];
        var img = [];
        $('p', data).each(function () {
            content.push($(this).html());
        });
        $('p', data).each(function () {
            img.push($(this).find('img').attr('href'));
        });


        return content;
    }









});










 