/*
 * - TABLE OF CONTENTS
 *
 * - 1. STICKY
 * - 2. ONE PAGE
 * - 3 EQUAL HEIGHT
 * - 4. DIALOG EFFECTS
 * - 5. MATCH MEDIA
 * 
 */
/////////////////////////////////////////////
// 1. STICKY PLUGIN
/////////////////////////////////////////////

// Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.

;(function($) {
    var defaults = {
            topSpacing: 0,
            topSticky: 0,
            animated: 'slideDown,slideUp',
            bottomSpacing: 0,
            className: 'is-sticky',
            wrapperClassName: 'yolo-sticky-wrapper',
            center: false,
            getWidthFrom: '',
            responsiveWidth: false
        },
        $window = $(window),
        $document = $(document),
        sticked = [],
        windowHeight = $window.height(),
        scroller = function() {
            var scrollTop = $window.scrollTop(),
                documentHeight = $document.height(),
                dwh = documentHeight - windowHeight,
                extra = (scrollTop > dwh) ? dwh - scrollTop : 0;


            var stickyInClearTimeOut = null,
                stickyOutClearTimeOut = null;

            for (var i = 0; i < sticked.length; i++) {
                var s = sticked[i],
                    elementTop = s.stickyWrapper.offset().top,
                    etse = elementTop - s.topSpacing - extra,
                    sticky_effect = s.animated.split(',');
                if (scrollTop <= etse) {
                    if ((s.currentTop !== null) && s.stickyElement.hasClass('sticky-on')) {
                        s.stickyElement.removeClass('sticky-on');
                        s.stickyElement.removeClass(sticky_effect['0']);
                        s.stickyElement.addClass(sticky_effect['1']);
                        s.stickyElement.removeClass('sticky-in');
                        s.stickyElement.addClass('sticky-out');

                        clearTimeout(stickyOutClearTimeOut);
                        stickyOutClearTimeOut = setTimeout(function() {
                            s.stickyElement.removeClass('sticky-out');
                            s.stickyElement.removeClass(sticky_effect['1']);
                            s.stickyElement
                                .css('position', '')
                                .css('top', '');

                            s.stickyElement.trigger('sticky-end', [s]).parent().removeClass(s.className);
                            s.currentTop = null;
                            if ((typeof(s.change) != "undefined") && (s.change != null)) {
                                s.change();
                            }
                        }, 300);
                    }
                
                }else {
                    var newTop = documentHeight - s.stickyElement.outerHeight()
                        - s.topSpacing - s.bottomSpacing - scrollTop - extra;
                    if (newTop < 0) {
                        newTop = newTop + s.topSticky;
                    } else {
                        newTop = s.topSticky;
                    }
                    if (s.currentTop != newTop) {
                        clearTimeout(stickyInClearTimeOut);
                        clearTimeout(stickyOutClearTimeOut);
                        s.stickyElement.addClass('sticky-on');
                        s.stickyElement.addClass(sticky_effect['0']);
                        s.stickyElement.addClass('sticky-in');
                        s.stickyElement.removeClass(sticky_effect['1']);
                        s.stickyElement.removeClass('sticky-out');
                        stickyInClearTimeOut = setTimeout(function () {
                            s.stickyElement.removeClass('sticky-in');
                        }, 500);

                        s.stickyElement
                            .css('position', 'fixed')
                            .css('top', newTop);

                        if (typeof s.getWidthFrom !== 'undefined') {
                            s.stickyElement.css('width', $(s.getWidthFrom).width());
                        }
                        s.stickyElement.trigger('sticky-start', [s]).parent().addClass(s.className);

                        s.currentTop = newTop;
                        if ((typeof(s.change) != "undefined") && (s.change != null)) {
                            s.change();
                        }
                    }
                }
            }
        },
        resizer = function() {
            windowHeight = $window.height();

            for (var i = 0; i < sticked.length; i++) {
                var s = sticked[i];
                if (typeof s.getWidthFrom !== 'undefined' && s.responsiveWidth === true) {
                    s.stickyElement.css('width', $(s.getWidthFrom).width());
                }
            }
        },
        methods = {
            init: function(options) {
                var o = $.extend({}, defaults, options);
                return this.each(function() {
                    var stickyElement = $(this);

                    var stickyId = stickyElement.attr('id');
                    var wrapperId = stickyId ? stickyId + '-' + defaults.wrapperClassName : defaults.wrapperClassName
                    var wrapper = $('<div></div>')
                        .attr('id', stickyId + '-yolo-sticky-wrapper')
                        .addClass(o.wrapperClassName);
                    stickyElement.wrapAll(wrapper);

                    if (o.center) {
                        stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
                    }

                    if (stickyElement.css("float") == "right") {
                        stickyElement.css({"float":"none"}).parent().css({"float":"right"});
                    }

                    var stickyWrapper = stickyElement.parent();
                    var stickyHeight = stickyElement.outerHeight(true);

                    if (stickyHeight > 0) {
                        stickyWrapper.css('height', stickyElement.outerHeight(true));
                    }
                    sticked.push({
                        topSpacing: o.topSpacing,
                        topSticky: o.topSticky,
                        animated: o.animated,
                        bottomSpacing: o.bottomSpacing,
                        stickyElement: stickyElement,
                        currentTop: null,
                        stickyWrapper: stickyWrapper,
                        className: o.className,
                        getWidthFrom: o.getWidthFrom,
                        responsiveWidth: o.responsiveWidth,
                        change: o.change
                    });
                });
            },
            update: scroller,
            unstick: function(options) {
                return this.each(function() {
                    var unstickyElement = $(this);

                    var removeIdx = -1;
                    for (var i = 0; i < sticked.length; i++)
                    {
                        if (sticked[i].stickyElement.get(0) == unstickyElement.get(0))
                        {
                            removeIdx = i;
                        }
                    }
                    if(removeIdx != -1)
                    {
                        sticked.splice(removeIdx,1);
                        unstickyElement.unwrap();
                        unstickyElement.removeAttr('style');
                    }
                });
            }
        };

    // should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
    if (window.addEventListener) {
        window.addEventListener('scroll', scroller, false);
        window.addEventListener('resize', resizer, false);
    } else if (window.attachEvent) {
        window.attachEvent('onscroll', scroller);
        window.attachEvent('onresize', resizer);
    }

    $.fn.sticky = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }
    };

    $.fn.unstick = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method ) {
            return methods.unstick.apply( this, arguments );
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }

    };
    $(function() {
        setTimeout(scroller, 0);
    });
})(jQuery);
/////////////////////////////////////////////
// 2. ONE PAGE
/////////////////////////////////////////////
/*!
 * jQuery One Page Nav Plugin
 * http://github.com/davist11/jQuery-One-Page-Nav
 *
 * Copyright (c) 2010 Trevor Davis (http://trevordavis.net)
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://jquery.org/license
 *
 * @version 3.0.0
 *
 * Example usage:
 * $('#nav').onePageNav({
 *   currentClass: 'current',
 *   changeHash: false,
 *   scrollSpeed: 750
 * });
 */

;(function($, window, document, undefined){

    // our plugin constructor
    var OnePageNav = function(elem, options){
        this.elem = elem;
        this.$elem = $(elem);
        this.options = options;
        this.metadata = this.$elem.data('plugin-options');
        this.$win = $(window);
        this.sections = {};
        this.didScroll = false;
        this.$doc = $(document);
        this.docHeight = this.$doc.height();
    };

    // the plugin prototype
    OnePageNav.prototype = {
        defaults: {
            navItems: 'a',
            currentClass: 'current',
            changeHash: false,
            easing: 'swing',
            filter: '',
            scrollSpeed: 750,
            scrollThreshold: 0.5,
            begin: false,
            end: false,
            scrollChange: false
        },

        init: function() {
            // Introduce defaults that can be extended either
            // globally or using an object literal.
            this.config = $.extend({}, this.defaults, this.options, this.metadata);

            this.$nav = this.$elem.find(this.config.navItems);

            //Filter any links out of the nav
            if(this.config.filter !== '') {
                this.$nav = this.$nav.filter(this.config.filter);
            }

            //Handle clicks on the nav
            this.$nav.on('click.onePageNav', $.proxy(this.handleClick, this));

            //Get the section positions
            this.getPositions();

            //Handle scroll changes
            this.bindInterval();

            //Update the positions on resize too
            this.$win.on('resize.onePageNav', $.proxy(this.getPositions, this));

            return this;
        },

        adjustNav: function(self, $parent) {
            self.$elem.find('.' + self.config.currentClass).removeClass(self.config.currentClass);
            $parent.addClass(self.config.currentClass);
        },

        bindInterval: function() {
            var self = this;
            var docHeight;

            self.$win.on('scroll.onePageNav', function() {
                self.didScroll = true;
            });

            self.t = setInterval(function() {
                docHeight = self.$doc.height();

                //If it was scrolled
                if(self.didScroll) {
                    self.didScroll = false;
                    self.scrollChange();
                }

                //If the document height changes
                if(docHeight !== self.docHeight) {
                    self.docHeight = docHeight;
                    self.getPositions();
                }
            }, 250);
        },

        getHash: function($link) {
            return $link.attr('href').split('#')[1];
        },

        getPositions: function() {
            var self = this;
            var linkHref;
            var topPos;
            var $target;

            self.$nav.each(function() {
                linkHref = self.getHash($(this));
                $target = $('#' + linkHref);

                if($target.length) {
                    topPos = $target.offset().top;
                    self.sections[linkHref] = Math.round(topPos);
                }
            });
        },

        getSection: function(windowPos) {
            var returnValue = null;
            var windowHeight = Math.round(this.$win.height() * this.config.scrollThreshold);

            for(var section in this.sections) {
                if((this.sections[section] - windowHeight - this.headerOffsetTop()) < windowPos) {
                    returnValue = section;
                }
            }

            return returnValue;
        },
        headerOffsetTop: function() {
            var offsetTop = 0;
            if (($('#wpadminbar').length > 0) && ($('#wpadminbar').css('position') == 'fixed')) {
                offsetTop = $('#wpadminbar').outerHeight();
            }

            if ($('header.yolo-main-header .header-sticky').length > 0) {
                if ($('header.yolo-main-header').css('position') == 'fixed') {
                    offsetTop += $('header.yolo-main-header').outerHeight();
                }
                else {
                    offsetTop += 60; // FIXED
                }
            }
            return offsetTop;
        },
        handleClick: function(e) {
            var self = this;
            var $link = $(e.currentTarget);
            var $parent = $link.parent();
            var newLoc = '#' + self.getHash($link);
            if (newLoc == '#undefined') {
                return;
            }

            if((1) || !$parent.hasClass(self.config.currentClass)) {
                //Start callback
                if(self.config.begin) {
                    self.config.begin();
                }

                //Change the highlighted nav item
                self.adjustNav(self, $parent);

                //Removing the auto-adjust on scroll
                self.unbindInterval();

                //Scroll to the correct position
                self.scrollTo(newLoc, function() {
                    //Do we need to change the hash?
                    if(self.config.changeHash) {
                        window.location.hash = newLoc;
                    }

                    //Add the auto-adjust on scroll back in
                    self.bindInterval();

                    //End callback
                    if(self.config.end) {
                        self.config.end();
                    }
                });
            }

            e.preventDefault();
        },

        scrollChange: function() {
            var windowTop = this.$win.scrollTop();
            var position = this.getSection(windowTop);
            var $parent;

            //If the position is set
            if(position !== null) {
                $parent = this.$elem.find('a[href$="#' + position + '"]').parent();

                //If it's not already the current section
                if(!$parent.hasClass(this.config.currentClass)) {
                    //Change the highlighted nav item
                    this.adjustNav(this, $parent);

                    //If there is a scrollChange callback
                    if(this.config.scrollChange) {
                        this.config.scrollChange($parent);
                    }
                }
            }
        },

        scrollTo: function(target, callback) {
            if ($(target).length == 0) {
                return;
            }

            var offset = $(target).offset().top - this.headerOffsetTop();

            $('html, body').animate({
                scrollTop: offset
            }, this.config.scrollSpeed, this.config.easing, callback);
        },

        unbindInterval: function() {
            clearInterval(this.t);
            this.$win.unbind('scroll.onePageNav');
        }
    };

    OnePageNav.defaults = OnePageNav.prototype.defaults;

    $.fn.onePageNav = function(options) {
        return this.each(function() {
            new OnePageNav(this, options).init();
        });
    };

})( jQuery, window , document );

/////////////////////////////////////////////
// 3. EQUAL HEIGHT
/////////////////////////////////////////////
;(function($) {
    'use strict';
    /**
     * Set all elements within the collection to have the same height.
     */
    $.fn.equalHeight = function(){
        var heights = [];
        $.each(this, function(i, element){
            var $element = $(element);
            var element_height;
            // Should we include the elements padding in it's height?
            var includePadding = ($element.css('box-sizing') == 'border-box') || ($element.css('-moz-box-sizing') == 'border-box');
            if (includePadding) {
                element_height = $element.innerHeight();

            } else {
                element_height = $element.height();
            }
            heights.push(element_height);
        });
        this.height(Math.max.apply(window, heights));
        return this;
    };

    /**
     * Create a grid of equal height elements.
     */
    $.fn.equalHeightGrid = function(columns){
        var $tiles = this;
        $tiles.css('height', 'auto');
        for (var i = 0; i < $tiles.length; i++) {
            if (i % columns === 0) {
                var row = $($tiles[i]);
                for(var n = 1;n < columns;n++){
                    row = row.add($tiles[i + n]);
                }
                row.equalHeight();
            }
        }
        return this;
    };

    /**
     * Detect how many columns there are in a given layout.
     */
    $.fn.detectGridColumns = function() {
        var offset = 0, cols = 0;
        this.each(function(i, elem) {
            var elem_offset = $(elem).offset().top;
            if (offset === 0 || elem_offset == offset) {
                cols++;
                offset = elem_offset;
            } else {
                return false;
            }
        });
        return cols;
    };

    /**
     * Ensure equal heights now, on ready, load and resize.
     */
    $.fn.responsiveEqualHeightGrid = function() {
        var _this = this;
        function syncHeights() {
            var cols = _this.detectGridColumns();
            _this.equalHeightGrid(cols);
        }
        $(window).bind('resize load', syncHeights);
        syncHeights();
        return this;
    };

})(jQuery);
jQuery(document).ready(function(){
    jQuery(function($) {
        if($('.column-equal-height').length) {
            $('.column-equal-height').each(function() {
                $('> div', this).responsiveEqualHeightGrid();
            })
        }
    });
});

/////////////////////////////////////////////
// 4. DIALOG EFFECTS
/////////////////////////////////////////////
// Dialog effects
/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 *
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

;( function( window ) {
    'use strict';
    // class helper functions from bonzo https://github.com/ded/bonzo

    function classReg( className ) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
    }

    // classList support for class management
    // altho to be fair, the api sucks because it won't accept multiple classes at once
    var hasClass, addClass, removeClass;

    if ( 'classList' in document.documentElement ) {
        hasClass = function( elem, c ) {
            return elem.classList.contains( c );
        };
        addClass = function( elem, c ) {
            elem.classList.add( c );
        };
        removeClass = function( elem, c ) {
            elem.classList.remove( c );
        };
    }
    else {
        hasClass = function( elem, c ) {
            return classReg( c ).test( elem.className );
        };
        addClass = function( elem, c ) {
            if ( !hasClass( elem, c ) ) {
                elem.className = elem.className + ' ' + c;
            }
        };
        removeClass = function( elem, c ) {
            elem.className = elem.className.replace( classReg( c ), ' ' );
        };
    }

    function toggleClass( elem, c ) {
        var fn = hasClass( elem, c ) ? removeClass : addClass;
        fn( elem, c );
    }

    var classie = {
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

    // transport
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( classie );
    } else {
        // browser global
        window.classie = classie;
    }

})( window );

/////////////////////////////////////////////
// 5. MATCH MEDIA (https://github.com/paulirish/matchMedia.js/)
/////////////////////////////////////////////
/*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas, David Knight. Dual MIT/BSD license */
;window.matchMedia || (window.matchMedia = function() {
    "use strict";

    // For browsers that support matchMedium api such as IE 9 and webkit
    var styleMedia = (window.styleMedia || window.media);

    // For those that don't support matchMedium
    if (!styleMedia) {
        var style       = document.createElement('style'),
            script      = document.getElementsByTagName('script')[0],
            info        = null;

        style.type  = 'text/css';
        style.id    = 'matchmediajs-test';

        script.parentNode.insertBefore(style, script);

        // 'style.currentStyle' is used by IE <= 8 and 'window.getComputedStyle' for all other browsers
        info = ('getComputedStyle' in window) && window.getComputedStyle(style, null) || style.currentStyle;

        styleMedia = {
            matchMedium: function(media) {
                var text = '@media ' + media + '{ #matchmediajs-test { width: 1px; } }';

                // 'style.styleSheet' is used by IE <= 8 and 'style.textContent' for all other browsers
                if (style.styleSheet) {
                    style.styleSheet.cssText = text;
                } else {
                    style.textContent = text;
                }

                // Test if media query is true or false
                return info.width === '1px';
            }
        };
    }

    return function(media) {
        return {
            matches: styleMedia.matchMedium(media || 'all'),
            media: media || 'all'
        };
    };
}());
