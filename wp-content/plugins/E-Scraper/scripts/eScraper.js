jQuery(document).ready(function ($) {
    window.eScraper = {
        save_s3_setting_ajax: save_s3_setting_ajax,
        add_category_wp: add_category_wp,
        check_license_ajax: check_license_ajax,
        delete_license_ajax: delete_license_ajax,
        define_pattern_ajax: define_pattern_ajax,
        get_urls: get_urls,
        get_title: get_title,
        get_contains: get_contains,
        get_img: get_img,
        removeTag: removeTag,
        getLocation: getLocation,
        alertSuccess: alertSuccess,
        alertError: alertError,
        get_first_string: get_first_string,
        skip_node: skip_node,
        get_category_dom: get_category_dom,
        scrape_get_dom_js: scrape_get_dom_js,
        scrape_one_url: scrape_one_url,
        scrape_category: scrape_category

    }

    function save_s3_setting_ajax(data) {
        $.post('options.php', data).error(function () {
            eScraper.alertError('error');
        }).success(function () {
            eScraper.alertSuccess('Your AWS S3 Setting Saved.');
        });
    }
    function add_category_wp(name_cat, parent_cat) {
        var data = {
            action: 'add_category_ajax',
            name_cat: name_cat,
            parent_cat: parent_cat
        }
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        })
    }
    function check_license_ajax(b, license, secret_key, domain_register) {
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                action: 'check_license_ajax',
                license: license,
                secret_key: secret_key,
                domain_register: domain_register
            },
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                } else {
                    if (data.option != '') {
                        return false;
                    }
                    $.post('options.php', b).error(function () {
                        alert('error');
                    }).success(function () {
                        eScraper.alertSuccess('Congratulation! You upgraded to Pro Version. Thanks!')
                    });
                }
            }
        });
    }
    function delete_license_ajax() {
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {action: 'delete_license'},
            success: function (data) {
                if (data == 'completed') {
                    var license = $('#input_license').empty;
                    var secret_key = $('#input_secret_key').empty;
                    location.reload();
                }
            }
        });
    }

    function define_pattern_ajax(define_url, define_title, define_first_content, define_last_content) {
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            data: {
                action: 'scrape_raw_content_ajax',
                url: define_url,
            },
            success: function (data) {
                l = eScraper.getLocation(define_url);
                define_url = l.hostname;
                define_url = define_url.replace('www.', '');
                var response = data;
                var xmlString = response
                        , parser = new DOMParser()
                        , doc = parser.parseFromString(xmlString, "text/html");
                var title = false;
                var title_class = false;
                var title_tag = false;
                var parent_node = false;
                var contentDOM = false;
                var nodes = doc.body.querySelectorAll('*');
                var text = false;
                define_title = escape(define_title.toLowerCase());
                define_first_content = escape(define_first_content.toLowerCase());
                define_last_content = escape(define_last_content.toLowerCase());
                for (var i = 0; i < nodes.length; i++) {
                    text = eScraper.removeTag(nodes[i].innerHTML)
                    text = escape(text.toLowerCase());
                    if ((nodes[i].nodeName == 'H1') || (nodes[i].nodeName == 'H2') || (nodes[i].nodeName == 'H3')) {
                        if (text.search(define_title) != -1) {
                            if (nodes[i].hasAttribute('class')) {
                                if (nodes[i].hasAttribute('class') && (nodes[i].className != "")) {
                                    title_tag = nodes[i].nodeName;
                                    title_class = nodes[i].className;
                                    break;
                                }
                            } else {
                                title_tag = nodes[i].nodeName;
                                temp = nodes[i];
                                while (true) {
                                    if (temp.hasAttribute('class') && (temp.className != "")) {
                                        title_class = temp.className;
                                        break;
                                    } else {
                                        temp = temp.parentNode;
                                    }
                                }
                            }
                        }
                    }
                }//end for
                for (var i = (nodes.length - 1); i >= 0; i--) {
                    if (skip_node(nodes[i]))
                        continue;
                    text = eScraper.removeTag(nodes[i].innerHTML);
                    text = escape(text.toLowerCase());
                    if ((text.search(define_first_content) != -1) && (text.search(define_last_content) != -1)) {
                        nodeTemp = nodes[i];
                        while (true) {
                            if (skip_node(nodeTemp)) {
                                nodeTemp = nodeTemp.parentNode;
                                continue;
                            }
                            if (nodeTemp.hasAttribute('class') && (nodeTemp.className != "")) {
                                contentDOM = nodeTemp;
                                break;
                            }
                            nodeTemp = nodeTemp.parentNode;
                        }
                        nodeTemp1 = nodeTemp.parentNode;
                        while (true) {
                            if (skip_node(nodeTemp1)) {
                                nodeTemp1 = nodeTemp1.parentNode;
                                continue;
                            }
                            if (nodeTemp1.hasAttribute('class') && (nodeTemp1.className != "")) {
                                parent_node = nodeTemp1;
                                break;
                            }
                            nodeTemp1 = nodeTemp1.parentNode;
                        }
                        break;
                    }
                }
                if ((contentDOM != false) && (parent_node != false)) {
                    define_title = title_tag + "." + title_class;
                    define_contentDOM = contentDOM.nodeName + "." + contentDOM.className;
                    if (parent_node.nodeName == 'BODY') {
                        define_parent_node = parent_node.nodeName + ".";
                    } else {
                        define_parent_node = parent_node.nodeName + "." + parent_node.className;
                    }
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'insert_scrape_pattern_table',
                            define_url: define_url,
                            define_title: define_title,
                            define_content: define_contentDOM,
                            define_parent_node: define_parent_node
                        },
                        success: function (response) {
                            $("#tabs").tabs("option", "active", 0);  // Activate Tab one
                            $('#scrape-one-form').submit();
                        },
                        error: function (error) {
                            alert(error);
                        }
                    });
                } else {
                    eScraper.alertError("We can't get pattern from this url. Please send url to us through support form.");
                }
            }
        });
    }

    function get_urls(data) {
        var urls = [];
        $('h2, h1, h3, h4', data).each(function () {
            var href = $(this).find('a').attr('href');
            if (href) {
                urls.push(href);
            }
        });
        return urls;
    }

    function get_title(data) {
        var title = $(data).find('h1').html();
        return title;
    }
    function get_contains(filter_content) {
        var content = [];
        $('p', filter_content).each(function () {
            content.push($(this).html());
        });
        return content;
    }
    function get_img(filter_content) {
        var img = [];
        $('img', filter_content).each(function () {
            img.push($(this).attr('src'));
        });
        return img;
    }

    function removeTag(text) {
        text = text.replace(/<\/*.*?>/gi, '');
        text = text.replace(/&nbsp;/gi, ' ');
        text = text.replace(/amp;/gi, '');
        return text;
    }
    function getLocation(href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    }
    function alertSuccess(msg) {
        $("<div>" + msg + "</div>").dialog({
            dialogClass: 'success-dialog',
            modal: true,
            title: 'Success',
            width: 400,
            buttons: {
                Ok: function () {
                    $(this).dialog("close"); //closing on Ok click
                }
            },
            close: function (event, ui) {
                location.reload();
            }

        });
    }
    function alertError(msg) {
        $("<div>" + msg + "</div>").dialog({
            dialogClass: 'error_dialog',
            modal: true,
            title: 'Error',
            width: 400,
            buttons: {
                Ok: function () {
                    $(this).dialog("close"); //closing on Ok click
                }
            }
        });
    }
    function get_first_string(str) {
        //Only get first class of parent node
        var regex = /^[^\s]+/;
        return str.match(regex);
    }
    function skip_node(node) {
        if ((node.nodeName == 'SCRIPT') || (node.nodeName == 'svg') || (node.nodeName == 'STYLE') || (node.nodeName == "SECTION") || (node instanceof SVGElement))
            return true;
        return false;
    }
    function get_category_dom(response, category_tag, category_class) {
        var xmlString = response
                , parser = new DOMParser()
                , doc = parser.parseFromString(xmlString, "text/html");
        var contentDOM = false;
        var nodes = doc.body.querySelectorAll('*');
        for (var i = 0; i < nodes.length; i++) {
            if (skip_node(nodes[i])) {
                continue;
            }
            tag_name = nodes[i].nodeName.toLowerCase();
            if (nodes[i].hasAttribute('class') && (nodes[i].className != '')) {
                class_name = nodes[i].className.toLowerCase();
                if ((tag_name == category_tag) && (class_name == category_class)) {
                    contentDOM = nodes[i];
                    break;
                }
            }
        }
        if (contentDOM == false) {
            return response;
        }
        return contentDOM;
    }
    function scrape_get_dom_js(response, title_tagName, title_className, content_tagName, content_className, parent_tagName, parent_className) {
        var xmlString = response
                , parser = new DOMParser()
                , doc = parser.parseFromString(xmlString, "text/html");
        var title = false;
        var contentDOM = false;
        var nodes = doc.body.querySelectorAll('*');
        for (var i = 0; i < nodes.length; i++) {
            tag_name = nodes[i].nodeName.toLowerCase();
            if (nodes[i].hasAttribute('class') && (nodes[i].className != '')) {
                class_name = nodes[i].className;
                if ((tag_name == title_tagName) && (class_name == title_className)) {
                    title = nodes[i];
                    break;
                }
            }
        }
        if (title == false) {
            for (var i = 0; i < nodes.length; i++) {
                tag_name = nodes[i].nodeName.toLowerCase();
                if (tag_name == title_tagName) {
                    title = nodes[i];
                    break;
                }
            }
        }
        for (var i = 0; i < nodes.length; i++) {
            if (skip_node(nodes[i])) {
                continue;
            }
            tag_name = nodes[i].nodeName.toLowerCase();
            if (nodes[i].hasAttribute('class') && (nodes[i].className != '')) {
                class_name = nodes[i].className.toLowerCase();
                if ((tag_name == content_tagName) && (class_name == content_className)) {
                    parent_tag_name = false;
                    parent_class_name = false;
                    temp = nodes[i].parentElement;
                    while (true) {
                        if (skip_node(temp)) {
                            temp = temp.parentElement;
                            continue;
                        }
                        parent_tag_name = temp.nodeName.toLowerCase();
                        parent_class_name = temp.className.toLowerCase();
                        break;
                    }
                    if (parent_class_name != '') {
                        if ((parent_tag_name == parent_tagName) && (parent_class_name == parent_className)) {
                            contentDOM = nodes[i];
                            break;
                        }
                    } else {
                        var parent_node = false;
                        nodeTemp = nodes[i].parentNode;
                        while (true) {
                            if (skip_node(nodes[i])) {
                                nodeTemp = nodeTemp.parentNode;
                                continue;
                            }
                            if (nodeTemp.hasAttribute('class') && (nodeTemp.className != "")) {
                                parent_node = nodeTemp;
                                break;
                            }
                            nodeTemp = nodeTemp.parentNode;
                        }
                        parent_tag_name = parent_node.nodeName.toLowerCase();
                        parent_class_name = parent_node.className.toLowerCase();
                        if (parent_tag_name == 'body') {
                            contentDOM = nodes[i];
                            break;

                        }
                        if ((parent_tag_name == parent_tagName) && (parent_class_name == parent_className)) {
                            contentDOM = nodes[i];
                            break;
                        }
                    }
                }//End compare to get Node

            }
        }//End for
        return {title: title, contentDOM: contentDOM};
    }
    function scrape_one_url(define_url, url, choose_upload_img, remove_link, remove_link, progressbar, val, selected, post_status) {
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            dataType: 'json',
            data: {
                action: 'scrape_content_ajax',
                url: define_url,
                scrape_category: 0
            },
            success: function (data) {
                val += 20;
                progressbar.progressbar({'value': val});
                if (data.check_url == 0) {
                    eScraper.alertError("The Url is not support. Please define pattern for this url.");
                    $("#tabs").tabs("option", "active", 1);  // Activate Tab Three 
                    $('#define_url').val(url);
                    $('#define_title').val('');
                    $('#define_first_content').val('');
                    $('#define_last_content').val('');
                } else {
                    var title_tagName = data.title_tagName;
                    var title_className = data.title_className;
                    var content_tagName = data.content_tagName;
                    var content_className = data.content_className;
                    var parent_tagName = data.parent_tagName;
                    var parent_className = data.parent_className;
                    $.ajax({
                        type: 'GET',
                        url: ajaxurl,
                        data: {
                            action: 'scrape_raw_content_ajax',
                            url: url,
                        },
                        success: function (data) {
                            val += 30;
                            progressbar.progressbar({'value': val});
                            progress = 30;
                            var response = data;
                            var results = scrape_get_dom_js(response, title_tagName, title_className, content_tagName, content_className,
                                    parent_tagName, parent_className);
                            var title = results.title;
                            var contentDOM = results.contentDOM;
                            var img = eScraper.get_img(contentDOM.outerHTML);
                            $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType: 'json',
                                data: {
                                    action: 'scrape_post_content_ajax',
                                    content: contentDOM.outerHTML,
                                    title: title.innerText,
                                    define_url: define_url,
                                    img: img,
                                    type: selected,
                                    post_status: post_status,
                                    choose_upload_img: choose_upload_img,
                                    remove_link: remove_link
                                },
                                success: function (data) {
                                    val += 40;
                                    progressbar.progressbar({'value': val});
                                    if (data) {
                                        $('.result1').show().append("<div class='title_return'>1.\" " + data.title + " \" has been posted.</div><br />");
                                    } else {
                                        $('.result1').show().append("<div class='title_return'>The Post has been posted before.</div><br />");
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    progressbar.progressbar({'value': 100});
                                    console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                                }
                            });//End ajax post
                        }
                    });//end ajax get content
                }
            }
        });
    }
    function scrape_category(define_url, url, choose_upload_img, remove_link, remove_link, progressbar, val, selected, post_status) {
        //check url and get pattern from  database
        $.ajax({
            type: 'GET',
            url: ajaxurl,
            dataType: 'json',
            data: {
                action: 'scrape_content_ajax',
                url: define_url,
            },
            success: function (data) {
                val += 10;
                progressbar.progressbar({'value': val});
                if (data.check_url == 0) {
                    alert("Url not support");
                    $("#tabs").tabs("option", "active", 1);  // Activate Tab Three 
                    $('#define_url').val(data.url);
                    $('#define_title').val('');
                    $('#define_first_content').val('');
                    $('#define_last_content').val('');
                } else {
                    var title_tagName = data.title_tagName;
                    var title_className = data.title_className;
                    var content_tagName = data.content_tagName;
                    var content_className = data.content_className;
                    var parent_tagName = data.parent_tagName;
                    var parent_className = data.parent_className;
                    //Ajax get contents from url
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: ajaxurl,
                        data: {action: 'scrape_raw_content_ajax',
                            url: url,
                            scrape_category: 1,
                            define_url: define_url
                        },
                        success: function (data) {
                            //Get content category
                            if (data == null) {
                                alert('We can not get category');
                                return false;
                            }
                            response = get_category_dom(data.content, data.pattern_category.category_tag, data.pattern_category.category_class);
                            val += 10;
                            progressbar.progressbar({'value': val});
                            globalVar = 0;
                            var urls = get_urls(response);
                            var number_urls = urls.length;
                            num_temp = 70 / number_urls;
                            $.each(urls, function (key, url) {
                                $.ajax({
                                    type: 'GET',
                                    url: ajaxurl,
                                    data: {action: 'scrape_raw_content_ajax',
                                        url: url
                                    },
                                    success: function (data) {
                                        var results = scrape_get_dom_js(data, title_tagName, title_className, content_tagName, content_className, parent_tagName, parent_className);
                                        title = results.title;
                                        contentDOM = results.contentDOM;
                                        var img = get_img(contentDOM.outerHTML);
                                        $.ajax({
                                            type: 'POST',
                                            url: ajaxurl,
                                            dataType: 'json',
                                            data: {
                                                action: 'scrape_post_content_ajax',
                                                content: contentDOM.outerHTML,
                                                title: title.innerText,
                                                define_url: define_url,
                                                img: img,
                                                type: selected,
                                                post_status: post_status,
                                                choose_upload_img: choose_upload_img,
                                                remove_link: remove_link
                                            },
                                            success: function (response) {
                                                val += num_temp;
                                                progressbar.progressbar({'value': val});
                                                number_urls--;
                                                globalVar++;
                                                if (response) {
                                                    $('.result1').show().append("<div class='title_return'>" + globalVar + ".  \"" + response.title + "\" has been posted.</div> <br />");
                                                }
                                                if (number_urls == 0) {
                                                    $('#wait1').hide();
                                                    $('.result1').show().append("<div class='title_return'>Completed.</div> <br />");
                                                    progressbar.progressbar({'value': 100});
                                                }
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                number_urls--;
                                                if (number_urls == 0) {
                                                    $('#wait1').hide();
                                                    $('.result1').show().append("<div class='title_return'>Completed.</div> <br />");
                                                    progressbar.progressbar({'value': 100});
                                                }
                                                console.log('Could not get posts, server response: ' + textStatus + ': ' + errorThrown);
                                            }
                                        }); //End sesond ajax

                                    } // End Success

                                });//End first send ajax

                            }); //End Each loop
                        }
                    });//End ajax get contents from url
                }  //End Else
            } //End Success
        });//End check url and get pattern from  database
    }


});




