// Script for home

// Showcase Plugin
(function($) {
    $.fn.showcase = function(options) {
        var opts = $.extend(true, {}, $.fn.showcase.defaults, options);

        var target = this.find("img");
        var pos = 0;

        target.each(function(index, element) {
            $(element).css("opacity", 0);
        });
        $(target[0]).css("opacity", 1);

        setInterval(function() {
            var next_pos = (pos + 1) % target.length;
            $(target[pos]).animate({
                opacity: 0
            }, opts.duration, 'linear');
            $(target[next_pos]).animate({
                opacity: 1
            }, opts.duration, 'linear');
            pos = next_pos;
        }, opts.interval + opts.duration);

        return this;
    };

    $.fn.showcase.defaults = {
        duration: 1000,
        interval: 5000
    };
})(jQuery);

jQuery(document).ready(function($) {
    $('#home #showcase').showcase();
    $("#model-introduction-icon-img").height($("#model-introduction-icon-img").width());
    $(".modelImage").height($(".modelImage").width() / 3 * 2);
    window.onresize = function() {
        $(".modelImage").height($(".modelImage").width() / 3 * 2);
        $("#model-introduction-icon-img").height($("#model-introduction-icon-img").width());
    }

});
