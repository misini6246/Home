(function (a) {
    a(document).ready(function () {
        var b = 0;
        var c = '';
        var d;
        a('#suggest').bind('keyup', e);
        a('#suggest').bind('keydown', g);
        if (document.activeElement.Id == 'suggest') {
            a('#suggest').trigger("keyup")
        }
        ;
        a('.search_btn').click(function () {
            /*王成*/
            if ($(this).prev().val() != "药品名称(拼音缩写)或厂家名称") {
                search_info($(this).prev().val(), '/category?keywords=' + $(this).prev().val() + '&showi=0');
            }
            /*end*/
        });
        a('#suggestions>li').live('mouseover', function () {
            var h = a(this).prevAll().length;
            b = h + 1;
            a(this).css('cursor', 'pointer').addClass('active').siblings('li').removeClass('active')
        });
        a('#suggestions>li').live('click', function () {
            a('#suggest').val(a(this).text());
            search_info($(this).prev().val(), '/category?keywords=' + a('#suggest').val() + '&showi=0');
        });
        a('#suggest').blur(function () {
            a('#suggestions_wrap').fadeOut();
            var h = a(this).val();
            if (h == '') {
                a(this).val('药品名称(拼音缩写)或厂家名称')
            }
        });
        a('#suggest').focus(function () {
            var h = a(this).val();
            if (h == '药品名称(拼音缩写)或厂家名称') {
                a(this).val('')
            }
            ;
            var i = a(this).val();
            if (i != '') {
                b = 0;
                if (d) d.abort();
                if (i.length >= 1) {
                    d = a.getJSON('/ajax/cart/searchKey', {keyword: i, step: 'suggest'}, f)
                }
            }
        });
        function e(h) {
            if (h.keyCode != 40 && h.keyCode != 38) {
                c = a.trim(a(this).val())
            }
            ;
            if (c == '' || h.which == 27) {
                a('#suggestions').empty();
                a('#suggestions_wrap').hide()
            }
            ;
            if ((h.which >= 65 && h.which <= 90) || h.which == 8 || h.which == 46 || h.which == 32 || h.which == 13 || h.which == undefined) {
                b = 0;
                if (d) d.abort();
                if (c.length >= 1) {
                    d = a.getJSON('/ajax/cart/searchKey', {keyword: c, step: 'suggest'}, f)
                }
            }
        };
        function f(h) {
            if (h == false) {
                a('#suggestions').empty();
                a('#suggestions_wrap').hide()
            } else {
                var i = '';
                for (var j = 0; j < h.length; j++) {
                    i += '<li>' + h[j] + '</li>'
                }
                ;
                a('#suggestions').html(i);
                a('#suggestions_wrap').show()
            }
        };
        function g(h) {
            switch (h.which) {
                case 38:
                    var i = '';
                    b = (b == 0 ? a("#suggestions li").length : b - 1);
                    if (b == 0) {
                        i = c;
                        a("#suggestions li").removeClass("active")
                    } else {
                        a("#suggestions li").removeClass("active");
                        a("#suggestions li").eq(b - 1).addClass("active");
                        i = a("#suggestions li").eq(b - 1).text()
                    }
                    ;
                    a("#suggest").val(i);
                    break;
                case 40:
                    var i = "";
                    if (b == a("#suggestions li").length) {
                        i = c;
                        a("#suggestions li").removeClass("active")
                    } else {
                        a("#suggestions li").removeClass("active");
                        i = a("#suggestions li").eq(b).text();
                        a("#suggestions li").eq(b).addClass("active")
                    }
                    ;
                    b = (b == a("#suggestions li").length ? 0 : b + 1);
                    a("#suggest").val(i);
                    break;
                case 13:
                    b = 0;
                    if (a('#suggestions>li.active').length != 0) {
                        a('#suggest').val(a('#suggestions>li.active').html())
                    }
                    ;
                    a('#suggestions').empty();
                    a('#suggestions_wrap').hide();
                    a('#suggest').unbind('keyup', e);
                    search_info($(this).prev().val(), '/category?keywords=' + a('#suggest').val() + '&showi=0');
                    break
            }
        }
    })
    a(document).ready(function () {
        var b = 0;
        var c = '';
        var d;
        a('#fixed-suggest').bind('keyup', e);
        a('#fixed-suggest').bind('keydown', g);
        if (document.activeElement.Id == 'suggest') {
            a('#fixed-suggest').trigger("keyup")
        }
        ;
        a('.fixed-search_btn').click(function () {
            /*王成*/
            if ($(this).prev().val() != "药品名称(拼音缩写)或厂家名称") {
                search_info($(this).prev().val(), '/category?keywords=' + $(this).prev().val() + '&showi=0');
            }
            /*end*/
        });
        a('#fixed-suggestions>li').live('mouseover', function () {
            var h = a(this).prevAll().length;
            b = h + 1;
            a(this).css('cursor', 'pointer').addClass('active').siblings('li').removeClass('active')
        });
        a('#fixed-suggestions>li').live('click', function () {
            a('#fixed-suggest').val(a(this).text());
            search_info($(this).prev().val(), '/category?keywords=' + a('#fixed-suggest').val() + '&showi=0');
        });
        a('#fixed-suggest').blur(function () {
            a('#fixed-suggestions_wrap').fadeOut();
            var h = a(this).val();
            if (h == '') {
                a(this).val('药品名称(拼音缩写)或厂家名称')
            }
        });
        a('#fixed-suggest').focus(function () {
            var h = a(this).val();
            if (h == '药品名称(拼音缩写)或厂家名称') {
                a(this).val('')
            }
            ;
            var i = a(this).val();
            if (i != '') {
                b = 0;
                if (d) d.abort();
                if (i.length >= 1) {
                    d = a.getJSON('/ajax/cart/searchKey', {keyword: i, step: 'suggest'}, f)
                }
            }
        });
        function e(h) {
            if (h.keyCode != 40 && h.keyCode != 38) {
                c = a.trim(a(this).val())
            }
            ;
            if (c == '' || h.which == 27) {
                a('#fixed-suggestions').empty();
                a('#fixed-suggestions_wrap').hide()
            }
            ;
            if ((h.which >= 65 && h.which <= 90) || h.which == 8 || h.which == 46 || h.which == 32 || h.which == 13 || h.which == undefined) {
                b = 0;
                if (d) d.abort();
                if (c.length >= 1) {
                    d = a.getJSON('/ajax/cart/searchKey', {keyword: c, step: 'suggest'}, f)
                }
            }
        };
        function f(h) {
            if (h == false) {
                a('#fixed-suggestions').empty();
                a('#fixed-suggestions_wrap').hide()
            } else {
                var i = '';
                for (var j = 0; j < h.length; j++) {
                    i += '<li>' + h[j] + '</li>'
                }
                ;
                a('#fixed-suggestions').html(i);
                a('#fixed-suggestions_wrap').show()
            }
        };
        function g(h) {
            switch (h.which) {
                case 38:
                    var i = '';
                    b = (b == 0 ? a("#fixed-suggestions li").length : b - 1);
                    if (b == 0) {
                        i = c;
                        a("#fixed-suggestions li").removeClass("active")
                    } else {
                        a("#fixed-suggestions li").removeClass("active");
                        a("#fixed-suggestions li").eq(b - 1).addClass("active");
                        i = a("#fixed-suggestions li").eq(b - 1).text()
                    }
                    ;
                    a("#fixed-suggest").val(i);
                    break;
                case 40:
                    var i = "";
                    if (b == a("#fixed-suggestions li").length) {
                        i = c;
                        a("#fixed-suggestions li").removeClass("active")
                    } else {
                        a("#fixed-suggestions li").removeClass("active");
                        i = a("#fixed-suggestions li").eq(b).text();
                        a("#fixed-suggestions li").eq(b).addClass("active")
                    }
                    ;
                    b = (b == a("#fixed-suggestions li").length ? 0 : b + 1);
                    a("#fixed-suggest").val(i);
                    break;
                case 13:
                    b = 0;
                    if (a('#fixed-suggestions>li.active').length != 0) {
                        a('#fixed-suggest').val(a('#fixed-suggestions>li.active').html())
                    }
                    ;
                    a('#fixed-suggestions').empty();
                    a('#fixed-suggestions_wrap').hide();
                    a('#fixed-suggest').unbind('keyup', e);
                    search_info($(this).prev().val(), '/category?keywords=' + a('#fixed-suggest').val() + '&showi=0');
                    break
            }
        }
    })
})(jQuery);

function search_info(keywords, url) {
    $.ajax({
        url: '/search_info',
        data: {keywords: keywords},
        headers: {

            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        },
        type: 'post',
        success: function () {
            location.href = url;
        }
    });
}

