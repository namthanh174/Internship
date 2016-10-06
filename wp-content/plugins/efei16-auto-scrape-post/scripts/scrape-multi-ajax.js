// jQuery(document).ready(function ($) {
    
// //------------------------------------------------------------------------------------------------------------------------//
// //Scrape Multi Articles
// //------------------------------------------------------------------------------------------------------------------------//
//      window.globalVar = 0;
//     $('#scrape-multi-form').submit(function () {
//         if ($('#url_multi').val() == "") {
//             alert("please enter url!");
//             die();
//         }


//         $('.result2').hide().empty();

//         //$("#progressbar").show();
//         globalVar = 0;

//         $('#wait2').show();
//         //$('.load2').hide();




//         var selected = [];
//         $('#type input:checked').each(function () {
//             selected.push($(this).attr('id'));
//         });

//         var url = $('#url_multi').val().trim();



//         $.ajax({
//             type: 'GET',
//             url: ajaxurl,
//             data: {
//                 action: 'scrape_process_multi_ajax',
//                 url: url,
//                 type: selected
//             },
//             success: function (response) {
//                 var urls = get_urls(response);
//                 var content = get_contains(response);

//                 $.each(urls, function (key, url) {
//                     $.ajax({
//                         type: 'GET',
//                         url: ajaxurl,
//                         dataType: 'json',
//                         data: {action: 'scrape_process_multi',
//                             url: url,
//                             type: selected
//                         },
//                         success: function (response) {
//                             var data = response.data;
//                             globalVar++;
//                             if (data) {
//                                 $('.result2').show().append("<div class='title_return'>" + globalVar + ".  \"" + data + "\" has been posted.</div> <br />");
//                             }



//                         },
//                         fail: function (jqXHR, textStatus, errorThrown) {
//                             alert('error')
//                             console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
//                         }
//                     });
//                 });



//             },
//             done: function () {

//             },
//         });


//         return false;


//     }).ajaxSuccess(function () {
//         //progressLabel.text( "Completed" );
//         //$('#wait2').hide();
//         //$('.load2').show().html(globalVar + " posts has been posted");



//     }).ajaxStop(function () {
//         //$('.load2').show().html(globalVar + " posts has been posted");
//         //progressLabel.text( "Completed" );
//         $('#wait2').hide();
//         if (globalVar > 0) {
//             $('.result2').append("Completed");
//              globalVar = 0;
//         }
       


//     });
// });