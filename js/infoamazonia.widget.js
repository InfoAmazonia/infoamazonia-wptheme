var BASEURL = infoamazonia_widget.baseurl + '?';
var DEFAULTMAP = infoamazonia_widget.defaultmap;

// indexOf shim via
// developer.mozilla.org/en-US/docs/JavaScript/Reference/Global_Objects/Array/indexOf
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement /*, fromIndex */ ) {
        'use strict';
        if (this === null) {
            throw new TypeError();
        }
        var t = Object(this);
        var len = t.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = 0;
        if (arguments.length > 1) {
            n = Number(arguments[1]);
            if (n !== n) { // shortcut for verifying if it's NaN
                n = 0;
            } else if (n !== 0 && n != Infinity && n != -Infinity) {
                n = (n > 0 || -1) * Math.floor(Math.abs(n));
            }
        }
        if (n >= len) {
            return -1;
        }
        var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
        for (; k < len; k++) {
            if (k in t && t[k] === searchElement) {
                return k;
            }
        }
        return -1;
    };
}

(function($) {

    // Utils
    // ========================

    // Match on type of property
    function startsWith(string, pattern) {
        return string.slice(0, pattern.length) === pattern;
    }

    // value from url property splitting
    function value(string) {
        return string.split('=')[1];
    }

    // Group template partials into an accessible object
    var templates =  _($('script[data-template]')).reduce(function(memo, el) {
        memo[el.getAttribute('data-template')] = _(el.innerHTML).template();
        return memo;
    }, {});

    // All textarea in the app should auto select
    // its content if the element is in focus
    function autoSelect($el) {
        $el.focus(function() {
            $textarea = $(this);
            $textarea.select();
            // Unbind the mouseup event for chrome
            $textarea.mouseup(function() {
                $textarea.off('mouseup');
                return false;
            });
        });
    }
    var widget = {};

    // Widget Controls View
    // ========================
    widget.controls = function() {
        var $context = $('#ia-widget');
        var $maps = $('#maps');
        var $stories = $('#stories');
        var $output = $('#output');
        var iframe = document.getElementById('iframe');
        var hash = location.href.split('#/')[1];

        // autoselect the contents of the textarea
        autoSelect($output);

        var embed = {
            story: undefined,
            publisher: undefined,
            noStory: undefined,
            map: DEFAULTMAP,
            width: 960,
            height: 480
        };

        if($('#map-select').length) {
            $('#map-select').find('option[value="' + DEFAULTMAP + '"]').attr('selected', 'selected');
            $('a.select-map-layers').attr('href', '?map_id=' + DEFAULTMAP);
        }

        function serialize() {
            if(embed.map) {
                if (embed.story) {
                    return 'p=' + embed.story + '&map_id=' + embed.map;
                } else if (embed.publisher) {
                    return 'publisher=' + embed.publisher + '&map_id=' + embed.map;
                } else if (embed.noStory) {
                    return 'no_stories=1&map_id=' + embed.map;
                } else {
                    return 'map_id=' + embed.map;
                }
            } else if(embed.layers) {
                if (embed.story) {
                    return 'p=' + embed.story + '&layers=' + embed.layers;
                } else if (embed.publisher) {
                    return 'publisher=' + embed.publisher + '&layers=' + embed.layers;
                } else if (embed.noStory) {
                    return 'no_stories=1&layers=' + embed.layers;
                } else {
                    return 'layers=' + embed.layers;
                }
            }
        }

        function updateOutput() {
            $output.html('<iframe src="' + BASEURL + serialize() + '" width="' + embed.width + '" height="' + embed.height + '" frameborder="0"></iframe>');
        }

        function updateIframe() {
            //location.href = '#/' + serialize();
            //iframe.src = BASEURL + serialize();
            $('#widget-content').html($('<iframe id="iframe" src="' + BASEURL + serialize() + '" frameborder="0"></iframe>'));
            iframe = document.getElementById('iframe');
        }

        var updateInputs = function() {

            var val = $(this).val();

            if (this.id === 'stories-select') {

                if (val.split('&')[0] === 'publisher') {
                    embed.story = undefined;
                    embed.publisher = val.split('&')[1];
                    embed.noStory = false;

                } else if (val.split('&')[0] === 'story') {
                    embed.story = val.split('&')[1];
                    embed.publisher = undefined;
                    embed.noStory = false;

                } else if (val === 'no-story') {
                    embed.story = undefined;
                    embed.publisher = undefined;
                    embed.noStory = true;

                } else if (val === 'latest') {
                    embed.story = undefined;
                    embed.publisher = undefined;
                    embed.noStory = false;

                } else {
                    embed.story = val;
                    embed.publisher = undefined;
                    embed.noStory = false;
                }

            } else if (this.id === 'map-select') {

                embed.map = val;
                $('a.select-map-layers').attr('href', '?map_id=' + val);

            } else if (this.id === 'layers-select') {

                embed.map = undefined;
                embed.layers = undefined;
                if($('#layers-select').val()) {
                    if($('#layers-select').val().length === $('#layers-select option').length) {
                        embed.map = $('#layers-select').data('mapid');
                    } else {
                        embed.layers = $('#layers-select').val().join();
                    }
                } else {
                    embed.map = $('#layers-select').data('mapid');
                }

            }

            // Defer these next actions until the
            // stack is cleared. the change event otherwise fires too quickly.
            _.defer(function() {
                updateOutput();
                updateIframe();
            });

        }

        $('.chzn-select').each(updateInputs);
        $('.chzn-select').chosen().change(updateInputs);

        $('#widget-content').css({
            'width': '960px',
            'height': '480px'
        });

        $('#sizes a').click(function() {
            var width = $(this).data('width');
            var height = $(this).data('height');
            var size = $(this).data('size');

            $('#widget-content').css({
                'width': width + 'px',
                'height': height + 'px'
            });

            $('#sizes a').removeClass('active');
            $(this).addClass('active');

            embed.width = width;
            embed.height = height;

            // re-run
            updateOutput();
            return false;
        });
    };

    this.widget = widget;

})(jQuery);
