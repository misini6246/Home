//主页电梯导航
;
(function ($) {
    $.fn.extend({
        navigation: function (options) {
            var defaults = {
                target: options.target,
                current: options.current,
                top_show: options.top_show,
                bottom_show: options.bottom_show,
                parent: options.parent
            }
            var o = $.extend(defaults, options);
            var array = [];
            this.each(function () {
                for (var i = 0; i < o.target.length; i++) {
                    var t = $(o.target[i]).offset().top;
                    array.push(t);
                }
                var _this = $(this)

                function Selected(index) {
                    _this.children().eq(index).addClass(o.current).siblings().removeClass(o.current);
                }

                $(window).on("scroll", Check);

                function Check() {
                    var wst = $(window).scrollTop();
                    var key = 0;
                    var flag = true;
                    if (o.top_show != undefined || o.bottom_show != undefined) {
                        if (wst > parseInt(o.top_show) && wst < parseInt(o.bottom_show)) {
                            $(o.parent).fadeIn('fast');
                        } else {
                            $(o.parent).fadeOut('fast');
                        }
                    }
                    for (var i = 0; i < array.length; i++) {
                        key++;
                        if (flag) {
                            if (wst >= array[array.length - key] - 300) {
                                var index = array.length - key;
                                flag = false;
                            } else {
                                flag = true;
                            }

                        }
                    }
                    Selected(index);
                }
            })
        }
    })
    $.fn.extend({
        navigation: $.fn.navigation
    })
})(jQuery)