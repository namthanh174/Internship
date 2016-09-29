jQuery(document).ready(function ($) {

    //------------------------------------------------------------------------------------------------------------------------//        
// Scrape One article
//------------------------------------------------------------------------------------------------------------------------//
    $('#scrape-one-form').submit(function () {
        if ($('#url_one').val() == "") {
            alert("please enter url!");
            die();
        }
//        $('.result1').innerHTML  = '';
        $('.result1').empty().hide();

        $('#wait1').show();



        var selected = [];
        $('#type input:checked').each(function () {
            selected.push($(this).attr('id'));
        });

        var url = $('#url_one').val().trim();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'scrape_process_one_ajax',
                url: url,
                type: selected
            },
            beforeSend: function () {
                //$("#progressbar").show();
            },
            complete: function () {
                //$("#progressbar").hide();

            },
            success: function (response) {

                $('.result1').show().append("<div class='title_return'>1. \"" + response + "\" has been posted.</div><br />");
                //$('.result1').show().append("<div class='title_return'>Completed</div><br />");
                $('#wait1').hide();
                $('.result2').hide();





            },
            error: function (error) {

            }


        });


        return false;


    });

});


