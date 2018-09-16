/**
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

(function($){
    "use strict";
    var AdminAPP = {
        initialize: function() {
            AdminAPP.meta_box_tab();
            AdminAPP.process_post_format();
            AdminAPP.widget_select2_process();
        },
        meta_box_tab: function() {
            //var tabBoxes = jQuery('#masonry_thumbnail_meta_box,#masonry_thumbnail_meta_box1');
            if( typeof meta_box_ids !== 'undefined' ) { // Check if RW metabox active
                var tabBoxes = jQuery(meta_box_ids);
                jQuery('#normal-sortables').after('<div class="yolo-meta-tabs-wrap postbox"><div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span>Page Options</span></h3><div id="yolo-tabbed-meta-boxes"></div></div>');

                jQuery(tabBoxes).appendTo('#yolo-tabbed-meta-boxes');
                jQuery(tabBoxes).hide().removeClass('hide-if-no-js');

                for (var a = 0, b = tabBoxes.length; a < b; a++ ) {
                    var newClass = 'editor-tab' + a;
                    jQuery(tabBoxes[a]).addClass(newClass);
                }

                var menu_html = '<ul id="yolo-meta-box-tabs" class="clearfix">\n';
                var total_hidden = 0;
                for (var i = 0, n = tabBoxes.length; i < n; i++ ) {
                    var target_id = jQuery(tabBoxes[i]).attr('id');
                    var tab_name = jQuery(tabBoxes[i]).find('.hndle > span').text();
                    var tab_class = "";

                    if (jQuery(tabBoxes[i]).hasClass('hide-if-js')) {
                        total_hidden++;
                    }

                    menu_html = menu_html + '\n<li id="li-'+ target_id +'" class="'+tab_class+'"><a href="#" rel="editor-tab' + i + '">' + tab_name + '</a></li>';
                }
                menu_html = menu_html + '\n</ul>';

                jQuery('#yolo-tabbed-meta-boxes').before(menu_html);
                jQuery('#yolo-meta-box-tabs a:first').addClass('active');

                jQuery('.editor-tab0').addClass('active').show();

                jQuery('.yolo-meta-tabs-wrap').on('click', '.handlediv', function() {
                    var metaBoxWrap = jQuery(this).parent();
                    if (metaBoxWrap.hasClass('closed')) {
                        metaBoxWrap.removeClass('closed');
                    } else {
                        metaBoxWrap.addClass('closed');
                    }
                });

                jQuery('#yolo-meta-box-tabs li').on('click', 'a', function() {
                    jQuery(tabBoxes).removeClass('active').hide();
                    jQuery('#yolo-meta-box-tabs a').removeClass('active');

                    var target = jQuery(this).attr('rel');

                    jQuery(this).addClass('active');
                    jQuery('.' + target).addClass('active').show();

                    return false;
                });
            }
        },
        process_post_format: function () {
            var prefix  = 'yolo_';
            var $cbxPostFormats = $( 'input[name=post_format]', '#post-formats-select' );
            var $meta_boxes = $('[id^="'+ prefix +'meta_box_post_format_"]').hide();
            $cbxPostFormats.change(function(){
                $meta_boxes.hide();
                $('#' + prefix +  'meta_box_post_format_' + $( this ).val()).show();
            });

            $cbxPostFormats.filter( ':checked' ).trigger( 'change' );

            $( 'body' ).on( 'change', '.checkbox-toggle input', function()
            {
                var $this = $( this ),
                    $toggle = $this.closest( '.checkbox-toggle' ),
                    action;
                if ( !$toggle.hasClass( 'reverse' ) )
                    action = $this.is( ':checked' ) ? 'slideDown' : 'slideUp';
                else
                    action = $this.is( ':checked' ) ? 'slideUp' : 'slideDown';

                $toggle.next()[action]();
            } );
            $( '.checkbox-toggle input' ).trigger( 'change' );
        },
        widget_select2: function(event, widget) {
            if (typeof (widget) == "undefined") {
                $('#widgets-right select.widget-select2:not(.select2-ready)').each(function(){
                    AdminAPP.widget_select2_item(this);
                });
            }
            else {
                $('select.widget-select2:not(.select2-ready)', widget).each(function(){
                    AdminAPP.widget_select2_item(this);
                });
            }
        },
        widget_select2_item: function(target){
            $(target).addClass('select2-ready');

            var data_value = $(target).attr('data-value');

            var choices = [];

            if (data_value != '') {
                var arr_data_value = data_value.split('||');

                for (var i = 0; i < arr_data_value.length; i++) {
                    var option = $('option[value='+ arr_data_value[i]  + ']', target);
                    choices[i] = { 'id':arr_data_value[i], 'text':option.text()};
                }

            }
            $(target).select2().select2('data', choices);
            $(target).on("select2-selecting", function(e) {
                var ids = $('input',$(this).parent()).val();
                if (ids != "") {
                    ids +="||";
                }
                ids += e.val;
                $('input',$(this).parent()).val(ids);
            }).on("select2-removed", function(e) {
                    var ids = $('input',$(this).parent()).val();
                    var arr_ids = ids.split("||");
                    var newIds = "";
                    for(var i = 0 ; i < arr_ids.length; i++) {
                        if (arr_ids[i] != e.val){
                            if (newIds != "") {
                                newIds +="||";
                            }
                            newIds += arr_ids[i];
                        }
                    }
                    $('input',$(this).parent()).val(newIds);
                });
        },
        widget_select2_process: function() {
            $(document).on('widget-added', AdminAPP.widget_select2);
            $(document).on('widget-updated', AdminAPP.widget_select2);
            AdminAPP.widget_select2();
        }
    };
    function yolo_updater_plugin(){
        $("#plugins").on("click", ".update-plugin", function(e) {

            if ($(this).attr("disabled")) {
                return
            }

            var p_name    = $(this).data('name'),
                n_version = $(this).data('new');

            if( confirm( yolo_admin["confirm_updater_plugin"].replace( "%PLUGIN%", p_name ) ) ){

                $(this).hide().prev().text(yolo_admin['updating']).prev().addClass('installing');

                $.ajax({
                    context: this,
                    url: yolo_admin["updater_plugin_url"],
                    type: "POST",
                    dataType: "json",
                    data: {
                        plugin: $(this).attr("data-plugin"),
                        nonce: yolo_admin["updater_plugin_nonce"]
                    },
                    complete: function(m) {

                        if ( !m.responseJSON && ( m.responseJSON = m.responseText.match( /\{"success":.+\}/ ) ) ) {
                            m.responseJSON = $.parseJSON(m.responseJSON[0])
                        }

                        if ( !m.responseJSON || !m.responseJSON.success ) {

                            if ( m.responseJSON && m.responseJSON.data ) {

                                alert(m.responseJSON.data)

                            } else {

                                alert(m.responseText ? m.responseText : yolo_admin.unknown_error)

                            }

                        } else {

                            $(this).prev().prev().removeClass('installing');
                            $(this).parents('.update').addClass('success').find('span').text(yolo_admin['updated']);
                            $(this).parents('.plugin-screenshort').next().find('span.version').text(n_version);

                        }


                    }
                })

            }

        });
    }

    function yolo_deactivate_plugin() {
        var p_slug;
        $("#plugins").on("click", ".deactivate-plugin", function(e) {
            e.preventDefault();

            var p_action = "deactivate",
                p_name   = $.trim($(this).parent().prev().text().replace(/[\s\t\r\n]{2,99}/g, " "));

            if ( confirm( yolo_admin["confirm_" + p_action + "_plugin"].replace( "%PLUGIN%", p_name ) ) ) {

                $(this).next().hide();
                $(this).hide().after('<span class="spinner is-active"></span>');

                var run = $.proxy(function() {

                    p_slug = $(this).attr("data-plugin")

                    $.ajax({
                        context: this,
                        url: yolo_admin[p_action + "_plugin_url"],
                        type: "POST",
                        dataType: "json",
                        data: {
                            plugin: $(this).attr("data-plugin"),
                            nonce: yolo_admin[p_action + "_plugin_nonce"]
                        },
                        complete: function(m) {

                            if ( !m.responseJSON && ( m.responseJSON = m.responseText.match( /\{"success":.+\}/ ) ) ) {
                                m.responseJSON = $.parseJSON(m.responseJSON[0])
                            }

                            if ( !m.responseJSON || !m.responseJSON.success ) {

                                if ( m.responseJSON && m.responseJSON.data ) {

                                    alert(m.responseJSON.data)

                                } else {

                                    alert(m.responseText ? m.responseText : yolo_admin.unknown_error)

                                }

                            } else {

                                $(this).removeClass(p_action + "-plugin").addClass("install-plugin");
                                $(this).text(yolo_admin["activate"]);

                            }

                            $(this).show().next().remove();
                            $(this).next().show();

                            $('#plugin .plugin-active span').text(yolo_admin['deactivated']);
                            $('#plugin .plugin-active').slideDown('slow');
                            // Set time out hidden notice
                            setTimeout( function(){
                                $('#plugin .plugin-active').slideToggle('slow');
                            }, 3000)

                        }
                    })

                }, this);

                run()
            }
        })
    }

    function yolo_install_plugin() {
        var p_slug;
        $("#plugins").on("click", ".install-plugin, .uninstall-plugin", function(e) {
            e.preventDefault();

            if ($(this).attr("disabled")) {
                return
            }

            var p_action = $(this).hasClass("install-plugin") ? "install" : "uninstall",
                p_name   = $.trim($(this).parent().prev().text().replace(/[\s\t\r\n]{2,99}/g, " "));

            if ( confirm( yolo_admin["confirm_" + p_action + "_plugin"].replace( "%PLUGIN%", p_name ) ) ) {

                $(this).parent().find('button').hide();
                $(this).after('<span class="spinner is-active"></span>');
                if( 'uninstall' == p_action )
                    $(this).prev().remove();

                var run = $.proxy(function() {

                    if ("install" == p_action) {
                        switch (p_slug) {
                            case "js_composer":
                                return setTimeout(k, 1000);
                                break
                        }
                        p_slug = $(this).attr("data-plugin")
                    }

                    $.ajax({
                        context: this,
                        url: yolo_admin[p_action + "_plugin_url"],
                        type: "POST",
                        dataType: "json",
                        data: {
                            plugin: $(this).attr("data-plugin"),
                            nonce: yolo_admin[p_action + "_plugin_nonce"]
                        },
                        complete: function(m) {

                            if ( !m.responseJSON && ( m.responseJSON = m.responseText.match( /\{"success":.+\}/ ) ) ) {
                                m.responseJSON = $.parseJSON(m.responseJSON[0])
                            }

                            if ( !m.responseJSON || !m.responseJSON.success ) {

                                if ( m.responseJSON && m.responseJSON.data ) {

                                    alert(m.responseJSON.data)

                                } else {

                                    alert(m.responseText ? m.responseText : yolo_admin.unknown_error)

                                }

                                "install" == p_action && (p_slug = null)

                            } else {

                                $(this).removeClass(p_action + "-plugin").addClass((p_action == "install" ? "deactivate" : "install") + "-plugin");
                                $(this).text(yolo_admin[p_action == "install" ? "deactivate" : "install"]);

                                if ("install" == p_action) {

                                    switch (p_slug) {
                                        case "js_composer":
                                            $.ajax({
                                                url: yolo_admin['ajaxurl'].replace("admin-ajax.php", "index.php"),
                                                complete: function() { p_slug = null }
                                            });
                                            break;
                                        default:
                                            p_slug = null;
                                            break
                                    }

                                }

                            }

                            $(this).parent().find('button').show()
                            $(this).next().remove();

                            if( 'uninstall' == p_action ){
                                if( $('#plugin #yolo-install-all-plugin').length == 0 ) {
                                    $('#plugin .plugin-active').after('<span id="yolo-install-all-plugin" class="button button-primary install-all-plugin">'+yolo_admin['install_all_plugin']+'</span>');
                                }
                                $('#plugin .plugin-active span').text(yolo_admin['uninstalled']);
                            }

                            if( 'install' == p_action ){
                                if( !$(this).next().hasClass('uninstall-plugin') )
                                    $(this).after(' <button class="button button-primary uninstall-plugin" data-plugin="yith-woocommerce-wishlist">'+yolo_admin['uninstall']+'</button>');

                                $('#plugin .plugin-active span').text(yolo_admin['installed']);

                                if( $('#plugins .item .install-plugin').length == 0 ){
                                    $('#plugin #yolo-install-all-plugin').remove();
                                }
                            }


                            $('#plugin .plugin-active').slideDown('slow');
                            // Set time out hidden notice
                            setTimeout( function(){
                                $('#plugin .plugin-active').slideToggle('slow');
                            }, 3000)
                        }
                    })

                }, this);

                run();

            }
        });
    }

    function yolo_install_plugin_all() {
        $('#plugin').on( 'click', '#yolo-install-all-plugin', function() {
            if( confirm( yolo_admin["confirm_install_all_plugin"] ) ){
                var p_item =  $( '#plugins .item');
                var el = 0;
                var doLoop = function(){

                    if( el > p_item.length ){
                        if( !$('#plugins .item .plugin-actions .button').hasClass('install-plugin') ){
                            $('#plugin .plugin-active span').text(yolo_admin['all_success']);
                            $('#plugin #yolo-install-all-plugin').remove();
                            $('#plugin .plugin-active').slideDown('slow');// Set time out hidden notice
                        }
                        setTimeout( function(){
                            $('#plugin .plugin-active').slideToggle('slow');
                        }, 3000)
                        return;
                    }

                    var p_button = p_item.eq(el).find( ".plugin-actions .button" ),
                        p_slug,
                        p_action = p_button.hasClass("install-plugin") ? "install" : "uninstall";

                    if( p_button.attr( 'disabled' ) || "uninstall" == p_action ){
                        el++;
                        doLoop();
                    }

                    if ( "install" == p_action && !p_button.attr( 'disabled' )) {
                        p_button.parent().find('button').hide();
                        p_button.parent().append('<span class="spinner is-active"></span>');

                        var run = $.proxy(function() {

                            if ("install" == p_action) {
                                switch (p_slug) {
                                    case "js_composer":
                                        return setTimeout(k, 1000);
                                        break }
                                p_slug = p_button.attr("data-plugin");
                                $.ajax({
                                    context: this,
                                    url: yolo_admin[p_action + "_plugin_url"],
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        plugin: p_button.attr("data-plugin"),
                                        nonce: yolo_admin[p_action + "_plugin_nonce"]
                                    },
                                    complete: function(m) {
                                        el++;
                                        if ( !m.responseJSON && ( m.responseJSON = m.responseText.match( /\{"success":.+\}/ ) ) ) {
                                            m.responseJSON = $.parseJSON(m.responseJSON[0])
                                        }
                                        if (!m.responseJSON || !m.responseJSON.success) {

                                            if (m.responseJSON && m.responseJSON.data) {
                                                alert(m.responseJSON.data)
                                            } else {
                                                alert(m.responseText ? m.responseText : yolo_admin.unknown_error)
                                            }

                                            "install" == p_action && (p_slug = null)

                                        } else {
                                            p_button.removeClass(p_action + "-plugin").addClass((p_action == "install" ? "uninstall" : "install") + "-plugin");
                                            p_button.text(yolo_admin[p_action == "install" ? "uninstall" : "install"]);
                                            if ("install" == p_action) {
                                                switch (p_slug) {
                                                    case "js_composer":
                                                        $.ajax({
                                                            url: yolo_admin['ajaxurl'].replace("admin-ajax.php", "index.php"),
                                                            complete: function() { p_slug = null }
                                                        });
                                                        break;
                                                    default:
                                                        p_slug = null;
                                                        break
                                                }
                                            }
                                        }
                                        p_button.show().next().remove();
                                        if( 'install' == p_action )
                                            p_button.before('<button class="button button-primary deactivate-plugin" data-plugin="yith-woocommerce-wishlist">'+yolo_admin["deactivate"]+'</button> ')

                                        doLoop();
                                    }
                                })
                            }

                        }, p_button);

                        run();
                    }

                }
                doLoop();
            }
        });

    }
    $(document).ready(function(){
        AdminAPP.initialize();
        yolo_deactivate_plugin();
        yolo_updater_plugin();
        yolo_install_plugin();
        yolo_install_plugin_all();
    });
})(jQuery);
