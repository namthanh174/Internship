jQuery(document).ready(function ($) {
    $('#define_url').prop('required', true);
    $('#define_title').prop('required', true);
    $('#define_first_content').prop('required', true);
    $('#define_last_content').prop('required', true);
    $('#url_one').prop('required', true);
    $('#tabs').tabs();
    //Choose publish post or not
    $('.choose_publish').click(function () {
        $('.choose_publish').attr("checked", true);
        $('.choose_draft').removeAttr("checked");
    });
    $('.choose_draft').click(function () {
        $('.choose_draft').attr("checked", true);
        $('.choose_publish').removeAttr("checked");
    });
    // Show or Not Show form Add category
    $('#category-add-toggle').click(function () {
        if ($('#category-adder').attr('class') == 'wp-hidden-children') {
            $('#category-adder').removeClass('wp-hidden-children');
        } else {
            $('#category-adder').addClass('wp-hidden-children');
        }
    })
    //Add Category to Wordpress Category
    $('#category-add-submit').click(function () {
        var name_cat = $('#newcategory').val();
        var parent_cat = $('#newcategory_parent').val();
        eScraper.add_category_wp(name_cat, parent_cat);
    });
    /*
     * Define pattern from input url and save to database server
     */
    $('#define-pattern-form').submit(function () {
        var define_url = $('#define_url').val().trim();
        var define_title = $('#define_title').val().trim();
        var define_first_content = $('#define_first_content').val().trim();
        var define_last_content = $('#define_last_content').val().trim();
        if ((define_url == "") || (define_title == "") || (define_first_content == "") || (define_last_content == "")) {
            return false;
        }
        eScraper.define_pattern_ajax(define_url, define_title, define_first_content, define_last_content);
        return false;
    });
    /*
     * Scrape content and post to wordpress from input url
     */
    $('#scrape-one-form').submit(function () {
        var choose_upload_img = $('input[name=upload_enable]:checked').val();
        var remove_link = $('#remove_link').attr('checked');
        var progressbar = $("#progressbar");
        var val = 10;
        progressbar.progressbar({'value': val});
        if ($('#url_one').val() == "") {
            return false;
        }
        $('.result1').empty().hide();
        var selected = [];
        $('#list_categories input:checked').each(function () {
            selected.push($(this).attr('id'));
        });
        var post_status;
        if ($('.choose_publish').attr('checked') == 'checked')
            post_status = $('.choose_publish').val();
        else
            post_status = $('.choose_draft').val();
        var url = $('#url_one').val().trim();
        var l = eScraper.getLocation(url);
        var define_url = l.hostname;
        define_url = define_url.replace('www.', '');
        //Scarpe One Article
        if ($('#choose_one_aritcle').attr('checked') == 'checked') {
            eScraper.scrape_one_url(define_url, url, choose_upload_img, remove_link, remove_link, progressbar, val, selected, post_status);
        }
        //Scrape Category
        if ($('#choose_category').attr('checked') == 'checked') {
            eScraper.scrape_category(define_url, url, choose_upload_img, remove_link, remove_link, progressbar, val, selected, post_status);
        }
        return false;
    });
    /*
     * Save setting setting of AWS S3 Amazon
     * @returns {undefined}
     */
    $('#s3-setting-form').submit(function () {
        var b = $(this).serialize();
        eScraper.save_s3_setting_ajax(b);
        return false;
    });

    /*
     * Add License
     * @returns {undefined}
     */
    $('#upgrade-pro-form').submit(function () {
        var b = $(this).serialize();
        var license = $('#input_license').val().trim();
        var secret_key = $('#input_secret_key').val().trim();
        var domain_register = window.location.host;
        eScraper.check_license_ajax(b, license, secret_key, domain_register);
        return false;
    });
    /*
     * Reset license
     */
    $('#upgrade_pro_delete').click(function () {
        eScraper.delete_license_ajax();
        return false;
    });


});




